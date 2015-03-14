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
namespace CakeManager\Controller\Event;

use Cake\Core\Configure;
use Cake\Event\EventListenerInterface;

class MailEventListener implements EventListenerInterface
{

    /**
     * ImplementedEvents Method
     *
     * Lists all defined events.
     *
     * @return array
     */
    public function implementedEvents()
    {
        return [
            'Controller.Users.afterLogin' => 'afterLogin',
        ];
    }

    /**
     * afterLogin
     *
     * @param \Cake\Event\Event $event Event.
     * @return void
     */
    public function afterLogin(\Cake\Event\Event $event)
    {
        if (Configure::read('CM.Mail.afterLogin')) {
            $user = $event->data['user'];

//        $email = new Email('default');
//        $email->from(Configure::read('CM.Mail.From'))
//                ->to($user['email'])
//                ->subject(__('You logged in succesfully'))
//                ->send('Congratulations!');
        }
    }
}
