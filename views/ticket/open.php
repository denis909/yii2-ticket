<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Support';

$this->params['enableCard'] = true;

$this->params['cardTitle'] = 'New Ticket';

/** @var \ricco\ticket\models\TicketHead $ticketHead */
/** @var \ricco\ticket\models\TicketBody $ticketBody */

$this->params['actionMenu'][] = [
    'label' => Yii::t('ticket', 'Go back'),
    'url' => Url::toRoute(['ticket/index']),
    'linkOptions' => [
        'class' => 'btn-secondary'
    ]
];

?>

<?php $form = ActiveForm::begin([
    'enableClientValidation' => false,
    'enableClientScript' => false
]);?>

<?= $form->errorSummary([$ticketHead, $ticketBody]);?>

<?= $form->field($ticketHead, 'topic')->textInput();?>

<?= $form->field($ticketHead, 'department')->dropDownList($ticketHead->departmentList);?>

<?= $form->field($ticketBody, 'text')->textarea([
    'style' => 'height: 150px; resize: none;',
]);?>

<?php

/*

<?= $form->field($fileTicket, 'fileName[]')->fileInput([
    'multiple' => true,
    'accept' => 'image/*',
])->label(false);?>

*/

?>

<div class="form-group">

    <?= Html::submitButton(Yii::t('ticket', 'Send Ticket'), ['class' => 'btn btn-primary']);?>

</div>

<?php $form->end();?>