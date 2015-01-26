<?php

namespace CakeManager\Shell;

use Cake\Console\Shell;

/**
 * Manager shell command.
 */
class ManagerShell extends Shell
{

    /**
     * Tasks
     * 
     * @var type
     */
    public $tasks = [
        'CakeManager.Initialize',
        'CakeManager.User'
    ];

    /**
     * main() method.
     *
     * @return bool|int Success or error code.
     */
    public function getOptionParser() {
        $parser = parent::getOptionParser();

        $parser->addSubcommand('initialize', [
            'help'   => 'Execute The Initialize-method. This will add some important data to your database.',
            'parser' => $this->Initialize->getOptionParser(),
        ]);
        $parser->addSubcommand('user', [
            'help'   => 'Execute The User-task. You will be able to create an user.',
            'parser' => $this->User->getOptionParser(),
        ]);

        return $parser;
    }

}
