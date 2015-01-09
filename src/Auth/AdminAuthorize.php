<?php

namespace CakeManager\Auth;

use Cake\Network\Request;
use Cake\Auth\ControllerAuthorize;

class AdminAuthorize extends ControllerAuthorize
{

    public function authorize($user, Request $request) {

        // if you access the admin-area
        if (key_exists('prefix', $request->params) && $request->params['prefix'] == 'admin') {

            // if you are really admin, you can access
            if ($user['role_id'] == 1) {
                return true;
            }

            // else you can't
            return false;
        }

        // if you don't access the admin-area follow the ControllerAuthorize
        return parent::authorize($user, $request);
    }

}
