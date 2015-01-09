<?php

use Cake\Core\Configure;
use Cake\Network\Session;

Configure::write('Session', [
    'defaults' => 'php',
    'timeout'  => 2880
]);


Configure::write('CM.Roles', [
    'Administrators' => [1],
    'Moderators' => [2],
    'Users' => [3],
    'Unregistered' => [4],
]);
