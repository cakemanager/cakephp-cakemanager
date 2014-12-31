<?php

namespace CakeManager\Shell;

use Cake\Console\Shell;

class InitShell extends Shell
{

    public function main() {
        $this->out('Welcome to the CakeManager.');
        $this->out('Use $ bake/cake CakeManager.Init Roles to load the default roles.');
        $this->out('Use $ bake/cake CakeManager.Init Admin [email] [password] to create an user-account.');
    }

    public function Admin($email = null, $password = null) {

        if (empty($email)) {
            return $this->error('Please enter an e-mailaddress.');
        }
        if (empty($password)) {
            return $this->error('Please enter a password.');
        }

        $this->loadModel('CakeManager.Users');

        $data = [
            'email'    => $email,
            'password' => $password,
            'role_id'  => 1,
        ];

        $new = $this->Users->newEntity($data);

        if( $this->Users->save($new)) {
            return$this->out('The user "'.$email.'" has been created as admin');
        }
        $this->out('Someting went wrong. The user could not be saved.');
    }

    /**
     * This command registers all default roles for the CakeManager
     */
    public function Roles() {

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

}
