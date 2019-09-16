<?php

use yii\helpers\Url;

/** @var \ricco\ticket\models\TicketHead $dataProvider */

$this->params['actionMenu'][] = [
    'label' => Yii::t('ticket', 'New Ticket'),
    'url' => Url::toRoute(['admin/open'])
];

$this->params['enableCard'] = true;

$this->params['cardTitle'] = 'Tickets';

$this->title = 'Support';

?>

<?= Yii::$app->backendTheme->gridView([
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
        [
            'attribute' => 'user_id',
            'value' => 'userName',
        ],
        [
            'attribute' => 'department',
            'value'=> 'departmentName',
        ],
        [
            'attribute' => 'topic',
            'value' => 'topic',
        ],
        [
            'attribute' => 'status',
            'value' => function ($model) {

                return '<div class="label label-' . $model->statusLabel. '">' . $model->statusName . '</div>';
            },
            'format' => 'html'

            /*
            'value' => function ($model) {
                switch ($model->body['is_client']) {
                    case 1:
                        if ($model->status == \ricco\ticket\models\TicketHead::STATUS_CLOSED) {
                            return '<div class="label label-success">Client</div>&nbsp;<div class="label label-default">'.Yii::t('ticket', 'Close').'</div>';
                        }

                        return '<div class="label label-success">Client</div>';
                    case 0 :
                        if ($model->status == \ricco\ticket\models\TicketHead::STATUS_CLOSED) {
                            return '<div class="label label-primary">'.Yii::t('ticket', 'Administrator').'</div>&nbsp;<div class="label label-default">'.Yii::t('ticket', 'Close').'</div>';
                        }

                        return '<div class="label label-primary">'.Yii::t('ticket', 'Administrator').'</div>';
                }
            },
            */
        ],
        [
            'attribute' => 'date_update',
            'value' => 'date_update',
            'format' => ['date', 'php:d.m.y H:i'],
            'contentOptions' => [
                'style' => 'width: 1%; white-space: nowrap;'
            ]
        ],
        [
            'class' => Yii::$app->backendTheme::ACTION_COLUMN,
            'template' => '{view}'
        ]
        /*
        [
            'class'         => 'yii\grid\ActionColumn',
            'template'      => '{update}&nbsp;{delete}&nbsp;{closed}',
            'headerOptions' => [
                'style' => 'width:230px',
            ],
            'buttons'       => [
                'update' => function ($url, $model) {
                    return \yii\helpers\Html::a(Yii::t('ticket', 'Reply'),
                        \yii\helpers\Url::toRoute(['admin/answer', 'id' => $model['id']]),
                        [
                            'class' => 'btn btn-sm btn-primary'
                        ]);
                },
                'delete' => function ($url, $model) {
                    return \yii\helpers\Html::a(Yii::t('ticket', 'Delete'),
                        \yii\helpers\Url::to(['admin/delete', 'id' => $model['id']]),
                        [
                            'class'   => 'btn-xs btn-danger',
                            'onclick' => "return confirm(".Yii::t('ticket', 'Do you really want to delete?').")",
                        ]
                    );
                },
                'closed' => function ($url, $model) {
                    return \yii\helpers\Html::a(Yii::t('ticket', 'Close'),
                        \yii\helpers\Url::to(['admin/closed', 'id' => $model['id']]),
                        [
                            'class'   => 'btn-xs btn-primary',
                            'onclick' => "return confirm(".Yii::t('ticket', 'Are you sure you want to close the ticket?').")",
                        ]
                    );
                },
            ],
        ]
        */
    ]
]) ?>