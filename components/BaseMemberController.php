<?php

namespace ricco\ticket\components;

use yii\filters\AccessControl;
use yii\filters\AccessRule;

abstract class BaseMemberController extends \yii\web\Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'ruleConfig' => [
                    'class' => AccessRule::class,
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ]
        ];
    }    

}