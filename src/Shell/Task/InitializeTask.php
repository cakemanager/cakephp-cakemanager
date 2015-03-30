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
 * Initialize task.
 *
 * This task is used to initiaze the CakeManager Plugin.
 * That means that roles will be created, and configures will be set.
 *
 */
class InitializeTask extends Shell
{

    /**
     * main() method.
     *
     * @return bool
     */
    public function main()
    {
        // initialize the roles
        return $this->_roles();
    }

    /**
     * roles() method.
     *
     * @return bool
     */
    protected function _roles()
    {
        $this->loadModel('CakeManager.Roles');

        $list = $this->Roles->find('list')->toArray();

        if (empty($list)) {
            $this->out('No roles found.');
        }

        // Creating administrators
        if (!in_array('Administrators', $list)) {
            $data = [
                'name' => 'Administrators',
                'login_redirect' => '/admin/manager/pages/dashboard',
            ];

            $new = $this->Roles->newEntity($data);
            if ($this->Roles->save($new)) {
                $this->out('Role "Administrators" created');
            } else {
                $this->out('Role "Administrators" could not be created');
                return false;
            }
        }

        // Creating moderators
        if (!in_array('Moderators', $list)) {
            $data = [
                'name' => 'Moderators',
                'login_redirect' => '/',
            ];

            $new = $this->Roles->newEntity($data);
            if ($this->Roles->save($new)) {
                $this->out('Role "Moderators" created');
            } else {
                $this->out('Role "Moderators" could not be created');
                return false;
            }
        }

        // Creating Users
        if (!in_array('Users', $list)) {
            $data = [
                'name' => 'Users',
                'login_redirect' => '/',
            ];

            $new = $this->Roles->newEntity($data);
            if ($this->Roles->save($new)) {
                $this->out('Role "Users" created');
            } else {
                $this->out('Role "Users" could not be created');
                return false;
            }
        }

        // Creating unregisterd
        if (!in_array('Users', $list)) {
            $data = [
                'name' => 'Unregistered',
                'login_redirect' => '/',
            ];

            $new = $this->Roles->newEntity($data);
            if ($this->Roles->save($new)) {
                $this->out('Role "Unregistered" created');
            } else {
                $this->out('Role "Unregistered" could not be created');
                return false;
            }
        }

        $this->out("Done.");
        return true;
    }

    /**
     * GetOptionParser method.
     *
     * @return ConsoleOptionParser
     */
    public function getOptionParser()
    {
        $parser = parent::getOptionParser();

        return $parser;
    }
}
