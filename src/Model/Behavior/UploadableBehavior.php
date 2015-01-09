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
     * @var array
     */
    protected $_defaultConfig = [
        'path'           => false,
        'fields'         => [
            'file'      => 'file',
            'name'      => 'file_name',
            'path'      => 'file_path',
            'extension' => 'file_ext',
        ],
        'removeOnUpdate' => false,
        'removeOnDelete' => false,
    ];

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

            if ($this->uploadFile($tmp, $path, $filename, $extension)) {

                $entity->{$this->config('fields.name')} = $filename;
                $entity->{$this->config('fields.path')} = $this->_getRelativePath($event->subject()->alias(), $entity->id, false);
                $entity->{$this->config('fields.extension')} = $extension;

                $event->subject()->save($entity);
            }
        }
    }

    public function afterDelete($event, $entity, $options) {

        if(!empty($entity->{$this->config('fields.path')})) {

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
    public function uploadFile($tmp, $path, $filename, $extension) {
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

    protected function _getAbsolutePath($model, $id) {

        if ($this->config('path') === false) {

            $path = ROOT . DS . 'webroot' . DS . 'uploads' . DS . $model . DS . $id . DS;

            return $path;
        }

        return $this->config('path');
    }

    protected function _getRelativePath($model, $id) {

        if ($this->config('path') === false) {

            $path = 'uploads' . '/' . $model . '/' . $id . '/';

            return $path;
        }

        return $this->config('path');
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
