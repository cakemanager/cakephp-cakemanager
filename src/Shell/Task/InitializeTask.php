<?php

namespace CakeManager\Shell\Task;

use Cake\Console\Shell;

class InitializeTask extends Shell
{

    /**
     * main() method.
     *
     */
    public function main() {

        // initialize the roles
        $this->roles();
    }

    /**
     * roles() method.
     *
     */
    protected function roles() {

        $this->loadModel('CakeManager.Roles');

        $list = $this->Roles->find('list')->toArray();

        if (empty($list)) {

            $this->out('No roles found.');
        }

        if (!in_array('Administrators', $list)) {

            // Creating administrators
            $data = [
                'name'           => 'Administrators',
                'login_redirect' => '/admin/manager/users',
            ];

            $new = $this->Roles->newEntity($data);
            $this->Roles->save($new);

            $this->out('Role "Administrators" created');
        }

        if (!in_array('Moderators', $list)) {

            // Creating moderators
            $data = [
                'name'           => 'Moderators',
                'login_redirect' => '/',
            ];

            $new = $this->Roles->newEntity($data);
            $this->Roles->save($new);

            $this->out('Role "Moderators" created');
        }

        if (!in_array('Users', $list)) {

            // Creating Users
            $data = [
                'name'           => 'Users',
                'login_redirect' => '/',
            ];

            $new = $this->Roles->newEntity($data);
            $this->Roles->save($new);

            $this->out('Role "Users" created');
        }

        if (!in_array('Users', $list)) {

            // Creating unregisterd
            $data = [
                'name'           => 'Unregistered',
                'login_redirect' => '/',
            ];

            $new = $this->Roles->newEntity($data);
            $this->Roles->save($new);

            $this->out('Role "Unregistered" created');
        }

        $this->out("Done");
    }

    /**
     * GetOptionParser method.
     *
     * @return type
     */
    public function getOptionParser() {
        $parser = parent::getOptionParser();

        return $parser;
    }

}
