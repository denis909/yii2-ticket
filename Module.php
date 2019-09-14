<?php

namespace ricco\ticket;

use ricco\ticket\models\User;
use Yii;

/**
 * ticket module definition class
 */
class Module extends \yii\base\Module
{

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    
        $this->registerTranslations();
    }
    /**
     * Registration of translation class.
     */
    protected function registerTranslations()
    {
        Yii::$app->i18n->translations['ticket'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en',
            'basePath' => '@ricco/ticket/messages',
            'fileMap' => [
              'ticket' => 'ticket.php',
            ]
        ];
    }

}