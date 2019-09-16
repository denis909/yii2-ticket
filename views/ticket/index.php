<?php

use yii\helpers\Url;
use ricco\ticket\models\TicketHead;

/** @var TicketHead $dataProvider */

$this->title = 'Support';

$this->params['enableCard'] = true;

$this->params['cardTitle'] = 'All Tickets';

$this->params['actionMenu'][] = [
    'label' => Yii::t('ticket', 'Create New Ticket'),
    'url' => Url::to(['ticket/open'])
];

echo Yii::$app->theme->gridView([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'attribute' => 'id',
            'headerOptions' => [
                'style' => 'white-space: nowrap;'
            ],
            'contentOptions' => [
                'style' => 'text-align: right; width: 1%;'
            ],
            'value' => function($model) {
                return '#' . $model->id;
            }
        ],        
        'topic',
        [
            'attribute' => 'department',
            'value' => function($model) {
                return $model->departmentName;
            }
        ],
        [
            'attribute' => 'status',
            'value' => function ($model) {
                return '<div class="label label-' . $model->statusLabel. '">' . $model->statusName . '</div>';
            },
            'format' => 'html'
        ],
        [
            'contentOptions' => [
                'style' => 'text-align:right; width: 1%; white-space: nowrap;'
            ],
            'attribute' => 'date_update',
            'format' => ['date', 'php:d.m.y H:i']
        ],          
        [
            'class' => Yii::$app->theme::ACTION_COLUMN,
            'template' => '{view}'
        ]
    ]
]);