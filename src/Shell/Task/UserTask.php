<?php

namespace CakeManager\Shell\Task;

use Cake\Console\Shell;

class UserTask extends Shell
{

    /**
     * Main() method.
     *
     * @return type
     */
    public function main() {

        $this->loadModel('CakeManager.Users');

        $email = $this->in('Enter the e-mailaddress');

        $password = $this->in('Enter the password');

        $data = [
            'email'    => $email,
            'password' => $password,
        ];

        $new = $this->Users->newEntity($data);

        $new->set('role_id', 1);
        $new->set('active', 1);

        if ($this->Users->save($new)) {
            return $this->out('The user "' . $email . '" has been created.');
        }

        $this->out('Someting went wrong. The user could not be saved. We will debug the validation errors...');

        if ($new->errors()) {
            debug($new->errors());
        }
    }

    /**
     * GetOptionParser method.
     *
     * @return type
     */
    public function getOptionParser() {
        $parser = parent::getOptionParser();

        $parser->description(['Here you will be able to generate an user.']);

        return $parser;
    }

}
