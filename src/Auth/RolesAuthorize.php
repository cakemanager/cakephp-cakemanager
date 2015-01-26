<?php

namespace CakeManager\Auth;

use Cake\Network\Request;
use Cake\Auth\ControllerAuthorize;

class RolesAuthorize extends ControllerAuthorize
{

    public function authorize($user, Request $request) {

        // if you access an prefix
        if (key_exists('prefix', $request->params)) {

            // if you are really admin, you can access
            if ($request->params['prefix'] == 'admin') {
                if ($this->Controller()->Manager->isAdmin($user)) {
                    return true;
                }
                return false;
            }

        }

        // if you don't access the admin-area follow the ControllerAuthorize
        return parent::authorize($user, $request);
    }

}
