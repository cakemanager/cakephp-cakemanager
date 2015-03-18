<?php
/**
 * CakeManager (http://cakemanager.org)
 * Copyright (c) http://cakemanager.org
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) http://cakemanager.org
 * @link          http://cakemanager.org CakeManager Project
 * @since         1.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace CakeManager\Shell\Task;

use Cake\Console\Shell;

/**
 * User task
 *
 * This task is able to create a new administrator via the shell.
 * This can be helpful when there are no user after the plugin has been loaded.
 *
 */
class UserTask extends Shell
{

    /**
     * Main() method.
     *
     * @return void|int|bool
     */
    public function main()
    {
        $this->loadModel('CakeManager.Users');

        $email = $this->in('Enter the e-mailaddress');

        $password = $this->in('Enter the password');

        $data = [
            'email' => $email,
            'password' => $password,
        ];

        $new = $this->Users->newEntity($data);

        $new->set('role_id', 1);
        $new->set('active', 1);

        if ($this->Users->save($new)) {
            $this->out('The user "' . $email . '" has been created.');
            return true;
        }

        $this->out('Someting went wrong. The user could not be saved. We will debug the validation errors...');

        if ($new->errors()) {
            $errors = $new->errors();
            foreach ($errors as $key => $error) {
                foreach($error as $message) {
                    $this->out($key . ': ' . ($message));
                }
            }
        }

        return false;
    }

    /**
     * GetOptionParser method.
     *
     * @return ConsoleOptionParser
     */
    public function getOptionParser()
    {
        $parser = parent::getOptionParser();

        $parser->description(['Here you will be able to generate an user.']);

        return $parser;
    }
}
