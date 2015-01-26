<?php

namespace CakeManager\Model\Behavior;

use Cake\ORM\Behavior;
use Cake\ORM\Table;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;

/**
 * Uploadable behavior
 */
class UploadableBehavior extends Behavior
{

    /**
     * Default configuration.
     *
     *
     * ### Path
     * {ROOT}
     * {id}
     * {model}
     * {DS}
     *
     *
     * @var array
     */
    protected $_defaultConfig = [
        'defaultPath'    => '{ROOT}{DS}{webroot}{DS}uploads{DS}{model}{DS}{id}{DS}',
        'files' =>[
            'file'
        ],
        'removeOnUpdate' => false,
        'removeOnDelete' => false,
    ];

    /**
     *
     * @var type The Table from the Behavior
     */
    protected $Table = null;

    public function __construct(Table $table, array $config = array()) {
        parent::__construct($table, $config);

        $this->Table = $table;
    }

    /**
     * BeforesSave event
     *
     * @param type $event
     * @param type $entity
     * @param type $options
     */
    public function beforeSave($event, $entity, $options) {

        $file = $entity->{$this->config('fields.file')};

        if ($this->_fileUploaded($file)) {
            // if is update
            if (!$entity->isNew()) {
                if ($this->config('removeOnUpdate')) {
                    $this->_removeAllFiles($entity->{$this->config('fields.path')}, ['except' => [$this->_getFullFilename($file)]]);
                }
            }

            $entity->{$this->config('fields.name')} = $this->_getFilename($file) . '.' . $this->_getExtension($file);
        }
    }

    public function afterSave($event, $entity, $options) {

        $file = $entity->{$this->config('fields.file')};

        if ($this->_fileUploaded($file)) {

            $tmp = $this->_getTmpName($file);
            $path = $this->_getAbsolutePath($event->subject()->alias(), $entity->id);

            $filename = $this->_getFilename($file);
            $extension = $this->_getExtension($file);

            if ($this->_uploadFile($tmp, $path, $filename, $extension)) {

                $entity->{$this->config('fields.name')} = $filename;
                $entity->{$this->config('fields.path')} = $this->_getRelativePath($event->subject()->alias(), $entity->id, false);
                $entity->{$this->config('fields.extension')} = $extension;

                $event->subject()->save($entity);
            }
        }
    }

    public function afterDelete($event, $entity, $options) {

        if (!empty($entity->{$this->config('fields.path')})) {

            $this->_removeAllFiles($entity->{$this->config('fields.path')});
        }
    }

    /**
     * Uploads the file to the given path
     * @param type $tmp
     * @param type $path
     * @param type $filename
     * @param type $extension
     */
    protected function _uploadFile($tmp, $path, $filename, $extension) {
        if (is_uploaded_file($tmp)) {
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            return move_uploaded_file($tmp, $path . $filename . '.' . $extension);
        }
        return false;
    }

    /**
     * Returns the extension of the given file
     *
     * @param $file
     * @return string
     */
    protected function _getExtension($file) {

        $info = pathinfo($file['name']);

        return $info['extension'];
    }

    /**
     * Returns the filename of the given file
     *
     * @param $file
     * @return string
     */
    protected function _getFilename($file) {

        $info = pathinfo($file['name']);

        return $info['filename'];
    }

    /**
     * Returns the full filename of the given file
     *
     * @param $file
     * @return string
     */
    protected function _getFullFilename($file) {

        return $this->_getFilename($file) . '.' . $this->_getExtension($file);
    }

    /**
     * Returns the tmpname
     *
     * @param $file
     * @return string
     */
    protected function _getTmpName($file) {

        return $file['tmp_name'];
    }

    protected function buildPath($path, $id, $options = []) {

        $replacements = array(
            '{ROOT}'  => ROOT,
            '{id}'    => $id,
            '{model}' => Inflector::underscore($this->Table->alias),
            '{DS}'    => DIRECTORY_SEPARATOR,
            '//'      => DIRECTORY_SEPARATOR,
            '/'       => DIRECTORY_SEPARATOR,
            '\\'      => DIRECTORY_SEPARATOR,
        );

        $builtPath = str_replace(array_keys($replacements), array_values($replacements), $path);

        return $builtPath;
    }

    protected function _removeAllFiles($path, $options = []) {

        $_options = [
            'except' => []
        ];

        $options = array_merge($_options, $options);

        $dir = new Folder($path);

        $files = $dir->find();

        foreach ($files as $_file) {

            $file = new File($dir->pwd() . DS . $_file);

            if (!in_array($_file, $options['except'])) {
                $file->delete();
            }
        }
    }

    /**
     * Checks if a file has been uploaded or not
     *
     * @param type $file
     * @return boolean
     */
    protected function _fileUploaded($file) {

        if (is_array($file)) {

            if ($file['tmp_name'] === '') {
                return false;
            }
        }
        return true;
    }

}
