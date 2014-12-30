<?php

use Cake\Core\Configure;
use Cake\Network\Session;

Configure::write('Session', [
    'defaults' => 'php',
    'timeout'  => 2880
]);
