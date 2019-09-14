<?php

namespace ricco\ticket\components;

use Yii;

class TicketComponent extends \yii\base\Component
{

    public $supportName = 'Support';

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'ricco\ticket\controllers';

    /** @var bool Уведомление на почту о тикетах */
    public $mailSend = true;

    /** @var string Тема email сообщения когда пользователю приходит ответ */
    public $subjectAnswer = 'Response by the ticket';

    /** @var  User */
    public $userComponent = 'user';

    /** @var  User */
    public $adminUserComponent = 'user';

    public $qq = [
        'ask_question' => 'Ask Question',
        'bug' => 'Report a Bug',
        'new_feature' => 'New Feature',
    ];

    /** @var array Ники администраторав */
    public $admin = ['admin'];

    /** @var string  */
    public $uploadFilesDirectory = '@webroot/fileTicket';

    /** @var string  */
    public $uploadFilesExtensions = 'png, jpg';

    /** @var int  */
    public $uploadFilesMaxFiles = 5;

    /** @var null|int */
    public $uploadFilesMaxSize = null;

    /** @var bool|int */
    public $pageSize = false;

    public function getUserModel()
    {
        return Yii::$app->{$this->userComponent}->identityClass;
    }

    public function getAdminUserModel()
    {
        return Yii::$app->{$this->adminUserComponent}->identityClass;
    }

    public function getUserId()
    {
        return Yii::$app->{$this->userComponent}->id;
    }

    public function getUserIdentity()
    {
        return Yii::$app->{$this->userComponent}->identity;
    }

    public function getAdminUserId()
    {
        return Yii::$app->{$this->adminUserComponent}->id;
    }

    public function getAdminUserIdentity()
    {
        return Yii::$app->{$this->adminUserComponent}->identity;
    }

}