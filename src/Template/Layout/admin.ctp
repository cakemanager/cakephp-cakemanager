<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
$this->assign('title', $title);
?>
<!DOCTYPE html>
<html>
    <head>
        <?= $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>
            <?= $this->fetch('title') ?>
        </title>
        <?= $this->Html->meta('icon') ?>

        <?= $this->Html->css('base.css') ?>
        <?= $this->Html->css('cake.css') ?>
        <?= $this->Html->css('CakeManager.custom_admin') ?>

        <?= $this->fetch('meta') ?>
        <?= $this->fetch('css') ?>
        <?= $this->fetch('script') ?>
    </head>
    <body>
        <header>
            <div class="header-title">
                <span><?= $this->fetch('title') ?></span>
                <small>

                    <?=
                    (isset($authUser) ?
                            "Welcome " . $authUser['email'] . " | "
                            . $this->Html->link('Logout', [
                                'plugin'     => 'CakeManager',
                                'controller' => 'Users',
                                'action'     => 'logout',
                                'prefix'     => false,
                            ]) : $this->Html->link('Login', [
                                'plugin'     => 'CakeManager',
                                'controller' => 'Users',
                                'action'     => 'login',
                                'prefix'     => false,
                            ]) )
                    ?>


                </small>
            </div>
            <div class="header-help">
                <span><a target="_blank" href="http://cakemanager.readthedocs.org/en/develop/">CakeManager Documentation</a></span>
                <span><a target="_blank" href="https://github.com/bobmulder/cakephp-cakemanager">CakeManager GitHub</a></span>
                <span><a target="_blank" href="http://book.cakephp.org/3.0/">Documentation</a></span>
                <span><a target="_blank" href="http://api.cakephp.org/3.0/">API</a></span>
            </div>
        </header>
        <div id="container">

            <div id="content">
                <?= $this->Flash->render() ?>
                <?= $this->Flash->render('auth') ?>

                <div class="row">

                    <div class="actions columns large-2 medium-3">
                        <h3><?= __('Actions') ?></h3>
                        <ul class="side-nav">
                            <?= $this->Menu->menu('main') ?>
                        </ul>
                    </div>

                    <div class="users index large-10 medium-9 columns">

                        <?= $this->fetch('content') ?>

                    </div>

                </div>
            </div>
            <footer>
            </footer>
        </div>
    </body>
</html>
