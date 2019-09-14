<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;

$this->title = 'Support';

$this->params['enableCard'] = true;

$this->params['cardTitle'] = 'Ticket #' . $ticketHead->id . ' (' . $ticketHead->statusName . ')';

$this->params['actionMenu'][] = [
    'label' => Yii::t('ticket', 'Go back'),
    'url' => Url::to(['ticket/index']),
    'linkOptions' => [
        'class' => 'btn-secondary'
    ]    
];

/** @var \ricco\ticket\models\TicketBody $newTicket */
/** @var \ricco\ticket\models\TicketBody $thisTicket */
/** @var \ricco\ticket\models\TicketFile $fileTicket */

?>

<div class="mb-4"><?= Html::encode($ticketHead->topic);?></div>

<?php foreach ($thisTicket as $ticket) : ?>
    <div class="card mb-2">
        <div class="card-header">
    <span><?= $ticket->userName;?>

        <span
            style="font-size: 12px"><?= ($ticket['is_client'] == 0) ? '' : '(' . Yii::t('ticket', 'Client') . ')';?></span></span>

            <span class="pull-right"><?= $ticket['date'] ?></span>
        </div>
        <div class="card-body" style="word-wrap: break-word;">
            <?= nl2br(Html::encode($ticket['text']));?>

            <?php if (!empty($ticket->file)) : ?>
                <hr>
                <?php foreach ($ticket->file as $file) : ?>
                    <a href="/fileTicket/<?= $file->fileName ?>" target="_blank"><img
                            src="/fileTicket/reduced/<?= $file->fileName ?> " alt="..."
                            class="img-thumbnail"></a>
                <?php endforeach; ?>
            <?php endif; ?>
            
        </div>
    </div>
<?php endforeach; ?>

<div class="clearfix" style="margin-bottom: 20px"></div>

<?php if ($error = Yii::$app->session->getFlash('error')) : ?>

    <div class="alert alert-danger" style="margin-top: 10px;"><?= $error;?></div>

<?php endif; ?>

<?php $form = ActiveForm::begin([
    'options' => [
        'enctype' => 'multipart/form-data'
    ],
    'enableClientValidation' => false,
    'enableClientScript' => false
]);?>

<?= $form->errorSummary($newTicket);?>

<?= $form->field($newTicket, 'text')
    ->textarea(['style' => 'height: 150px; resize: none;'])
    ->label(Yii::t('ticket', 'Message'))
    ->error() ?>

<?php
/*

<?= $form->field($fileTicket, 'fileName[]')->fileInput([
    'multiple' => true,
    'accept'   => 'image/*',
])->label(false); ?>

*/

?>

<div class="form-group">

    <?= Html::submitButton(Yii::t('ticket', 'Send'), ['class' => 'btn btn-primary']);?>

</div>

<?php $form->end() ?>