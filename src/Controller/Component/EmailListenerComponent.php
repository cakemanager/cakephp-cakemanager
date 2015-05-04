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
namespace CakeManager\Controller\Component;

use Cake\Controller\Component;
use Cake\Core\Configure;
use Cake\Network\Email\Email;
use Cake\ORM\TableRegistry;

/**
 * EmailListener component
 */
class EmailListenerComponent extends Component
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [
        'config' => null,
        'emailFormat' => 'html'
    ];

    /**
     * Holder for the EmailObject
     *
     * @var mixed|Cake\Network\Email\Email EmailObject
     */
    public $EmailObject = null;

    /**
     * initialize
     *
     * @param array $config Configurations.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setEmailObject(new Email($this->config('config')));
    }

    /**
     * setEmailObject
     *
     * Setter for the Email-object to use.
     * Used for testing (using mocks).
     *
     * @param \Cake\Network\Email\Email $object The object.
     * @return void
     */
    public function setEmailObject($object)
    {
        $this->EmailObject = $object;
    }

    /**
     * getMailInstance
     *
     * Returns a new mail-instance with the given or default config.
     *
     * @param string $config Config to use.
     * @return \Cake\Network\Email\Email
     */
    public function getMailInstance($config = null)
    {
        if (!$config) {
            $config = $this->config('config');
        }

        $sender = Configure::read('CM.Mail.sender');

        $object = $this->EmailObject;

        $object->sender($sender['email'], $sender['name']);

        if (Configure::read('CM.Mail.transport')) {
            $object->transport(Configure::read('CM.Mail.transport'));
        }

        return $object;
    }

    /**
     * Register
     *
     * Sends mail to the given user
     *
     * @param array $user User.
     * @return void|\Cake\Network\Email\Email
     */
    public function activation($user)
    {
        $mail = $this->getMailInstance();

        $from = Configure::read('CM.Mail.from');
        $options = Configure::read('CM.Mail.activation');

        if ($options) {
            $fullBaseUrl = Configure::read('App.fullBaseUrl');

            $mail->viewVars([
                'user' => $user,
                'activationUrl' => $fullBaseUrl . '/users/activate/' . $user['email'] . '/' . $user['activation_key'],
                'fullBaseUrl' => $fullBaseUrl,
                'loginUrl' => $fullBaseUrl . '/login',
                'from' => reset($from),
            ]);

            $mail->template($options['template'], $options['layout']);

            $mail->emailFormat($this->config('emailFormat'));

            $mail->from($from);

            $mail->to($user['email']);

            $mail->subject($options['subject']);

            $mail->send();

            return $mail;
        }
    }

    /**
     * activationConfirmation
     *
     * Sends a confirmation of the activation to the specific user.
     *
     * @param array $user User.
     * @return void|\Cake\Network\Email\Email
     */
    public function activationConfirmation($user)
    {
        $mail = $this->getMailInstance();

        $from = Configure::read('CM.Mail.from');
        $options = Configure::read('CM.Mail.activationConfirmation');

        if ($options) {
            $fullBaseUrl = Configure::read('App.fullBaseUrl');

            $mail->viewVars([
                'user' => $user,
                'fullBaseUrl' => $fullBaseUrl,
                'loginUrl' => $fullBaseUrl . '/login',
                'from' => reset($from),
            ]);

            $mail->template($options['template'], $options['layout']);

            $mail->emailFormat($this->config('emailFormat'));

            $mail->from($from);

            $mail->to($user['email']);

            $mail->subject($options['subject']);

            $mail->send();

            return $mail;
        }
    }

    /**
     * ForgotPassword
     *
     * Sends a mail to the user who's forgot its password.
     *
     * @param array $user User.
     * @return void|\Cake\Network\Email\Email
     */
    public function forgotPassword($user)
    {
        $mail = $this->getMailInstance();

        $from = Configure::read('CM.Mail.from');
        $options = Configure::read('CM.Mail.forgotPassword');

        if ($options) {
            $fullBaseUrl = Configure::read('App.fullBaseUrl');

            $mail->viewVars([
                'user' => $user,
                'url' => $fullBaseUrl . '/users/resetPassword/' . $user['email'] . '/' . $user['activation_key'],
                'fullBaseUrl' => $fullBaseUrl,
                'loginUrl' => $fullBaseUrl . '/login',
                'from' => reset($from),
            ]);

            $mail->template($options['template'], $options['layout']);

            $mail->emailFormat($this->config('emailFormat'));

            $mail->from($from);

            $mail->to($user['email']);

            $mail->subject($options['subject']);

            $mail->send();

            return $mail;
        }
    }

    /**
     * PasswordConfirmation
     *
     * Sends a confirmation to the user who changed its password.
     *
     * @param array $user User.
     * @return void|\Cake\Network\Email\Email
     */
    public function passwordConfirmation($user)
    {
        $mail = $this->getMailInstance();

        $from = Configure::read('CM.Mail.from');
        $options = Configure::read('CM.Mail.passwordConfirmation');

        if ($options) {
            $fullBaseUrl = Configure::read('App.fullBaseUrl');

            $mail->viewVars([
                'user' => $user,
                'fullBaseUrl' => $fullBaseUrl,
                'loginUrl' => $fullBaseUrl . '/login',
                'from' => reset($from),
            ]);

            $mail->template($options['template'], $options['layout']);

            $mail->emailFormat($this->config('emailFormat'));

            $mail->from($from);

            $mail->to($user['email']);

            $mail->subject($options['subject']);

            $mail->send();

            return $mail;
        }
    }

    /**
     * afterRegister event
     *
     * Called after a user has been registered
     *
     * @param \Cake\Event\Event $event Event.
     * @param array $user User.
     * @return void
     */
    public function afterRegister($event, $user)
    {
        $sendMail = key_exists('sendMail', $event->data) ? $event->data['sendMail'] : true;
        if ($sendMail) {
            if (Configure::read('CM.ActivationOnRegister')) {
                $this->activation($user);
            }
        }
    }

    /**
     * afterActivate event
     *
     * Sends mail after an user activated its account
     * successfully.
     *
     * @param \Cake\Event\Event $event Event.
     * @param array $email E-mailaddress of the user.
     * @return void
     */
    public function afterActivate($event, $email)
    {
        $Users = TableRegistry::get(Configure::read('CM.UserModel'));

        $user = $Users->findByEmail($email)->first()->toArray();

        $this->activationConfirmation($user);
    }

    /**
     * afterForgotPassword event
     *
     * Sends mail to the user if forgot his password.
     *
     * @param \Cake\Event\Event $event Event.
     * @param array $user User.
     * @return void
     */
    public function afterForgotPassword($event, $user)
    {
        $this->forgotPassword($user);
    }

    /**
     * afterResetPassword event
     *
     * Sends mail to the user if the new password was
     * registerd successfully.
     *
     * @param \Cake\Event\Event $event Event.
     * @param array $user User.
     * @return void
     */
    public function afterResetPassword($event, $user)
    {
        $this->passwordConfirmation($user);
    }

    /**
     * implementedEvents
     *
     * Lists all defined events.
     *
     * @return array
     */
    public function implementedEvents()
    {
        $_events = parent::implementedEvents();

        $events = [
            'Controller.Users.afterRegister' => 'afterRegister',
            'Controller.Users.afterActivate' => 'afterActivate',
            'Controller.Users.afterForgotPassword' => 'afterForgotPassword',
            'Controller.Users.afterResetPassword' => 'afterResetPassword'
        ];

        return array_merge($_events, $events);
    }
}
