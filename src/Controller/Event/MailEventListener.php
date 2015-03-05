<?php

namespace CakeManager\Controller\Event;

use Cake\Event\EventListenerInterface;
use Cake\Network\Email\Email;
use Cake\Core\Configure;

class MailEventListener implements EventListenerInterface
{

    public function implementedEvents()
    {
        return [
            'Controller.Users.afterLogin' => 'afterLogin',
        ];
    }

    public function afterLogin(\Cake\Event\Event $event)
    {

        $user = $event->data['user'];

//        $email = new Email('default');
//        $email->from(Configure::read('CM.Mail.From'))
//                ->to($user['email'])
//                ->subject(__('You logged in succesfully'))
//                ->send('Congratulations!');
    }

}
