<?php

namespace ricco\ticket\components;

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
                        'matchCallback' => function ($rule, $action) {

                            if (!in_array(Yii::$app->user->getId(), $this->module->adminId)) {
                                
                                return false;
                            }

                            return true;
                        }
                    ]
                ]
            ]
        ];
    }
    
}