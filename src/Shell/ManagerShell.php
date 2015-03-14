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
namespace CakeManager\Shell;

use Cake\Console\Shell;

/**
 * Manager shell command.
 *
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
    public function getOptionParser()
    {
        $parser = parent::getOptionParser();

        $parser->addSubcommand('initialize', [
            'help' => 'Execute The Initialize-method. This will add some important data to your database.',
            'parser' => $this->Initialize->getOptionParser(),
        ]);
        $parser->addSubcommand('user', [
            'help' => 'Execute The User-task. You will be able to create an user.',
            'parser' => $this->User->getOptionParser(),
        ]);

        return $parser;
    }
}
