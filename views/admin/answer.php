<?php

/** @var \ricco\ticket\models\TicketHead $newTicket */

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Support';

$this->params['enableCard'] = true;

$this->params['cardTitle'] = 'Ticket #' . $ticketHead->id . ' (' . $ticketHead->statusName . ')';

$this->params['actionMenu'][] = [
    'label' => Yii::t('ticket', 'Go back'),
    'url' => Url::toRoute(['admin/index']),
    'linkOptions' => [
        'class' => 'btn-secondary'
    ]
];

$this->params['actionMenu'][] = [
    'label' => Yii::t('ticket', 'Close'),
    'url' => Url::toRoute(['admin/close', 'id' => $ticketHead->id]),
    'linkOptions' => [
        'class' => 'btn-success',
        'data-method' => 'post',
        'data-confirm' => Yii::t('ticket', 'Are you sure you want to close the ticket?')
    ]
];

$this->params['actionMenu'][] = [
    'label' => Yii::t('ticket', 'Delete'),
    'url' => Url::toRoute(['admin/delete', 'id' => $ticketHead->id]),
    'linkOptions' => [
        'class' => 'btn-danger',
        'data-method' => 'post',
        'data-confirm' => Yii::t('ticket', 'Do you really want to delete?') 
    ]
];

/** @var \ricco\ticket\models\TicketBody $thisTicket */
?>

<div class="mb-4"><?= Html::encode($ticketHead->topic);?></div>

<?php foreach ($thisTicket as $ticket) : ?>
    <div class="card mb-2">
        <div class="card-header">
            <span><?= $ticket->userName;?></span>
            <span style="float: right;"><?= $ticket->formattedDate;?></span>
        </div>
        <div class="card-body">
            <?= nl2br(Html::encode($ticket['text'])) ?>
            <?php if (!empty($ticket['file'])) : ?>
                <hr>
                <?php foreach ($ticket['file'] as $file) : ?>
                    <a href="/fileTicket/<?= $file['fileName'] ?>" target="_blank"><img
                                src="/fileTicket/reduced/<?= $file['fileName'] ?> " alt="..."
                                class="img-thumbnail"></a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
<?php endforeach; ?>

<?php $form = \yii\widgets\ActiveForm::begin() ?>

<?= $form->field($newTicket, 'text')
    ->textarea(['style' => 'height: 150px; resize: none;'])
    ->label(Yii::t('ticket', 'Message'))
    ->error();?>

<?= $form->errorSummary($newTicket) ?>

<div class="form-group">

    <?= Html::submitButton(Yii::t('ticket', 'Send'), [
        'class' => 'btn btn-primary'
    ]);?>

</div>

<?php $form->end() ?>




