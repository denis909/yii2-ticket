<?php

namespace ricco\ticket\components;

use Yii;
use yii\filters\AccessControl;

abstract class BaseAdminController extends \yii\web\Controller
{

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'matchCallback' => function($rule, $action) {

                            $userComponent = Yii::$app->ticket->adminUserComponent;

                            if (!Yii::$app->{$userComponent}->isGuest)
                            {
                                if (in_array(Yii::$app->{$userComponent}->identity->username, Yii::$app->ticket->admin))
                                {                           
                                    return true;
                                }                        
                            }

                            return false;
                        }
                    ]
                ]
            ]
        ];
    }
    
}