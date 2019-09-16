<?php

/** @var \ricco\ticket\models\TicketHead $ticketHead */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use common\models\User;
use yii\helpers\ArrayHelper;

/** @var \ricco\ticket\models\TicketBody $ticketBody */

$this->params['actionMenu'][] = [
    'label' => Yii::t('ticket', 'Go Back'),
    'url' => Url::to(['admin/index']),
    'linkOptions' => [
        'class' => 'btn-secondary'

    ]
];

$form = ActiveForm::begin([
    'enableClientValidation' => false,
    'enableClientScript' => false
]);

$this->params['enableCard'] = true;

$this->params['cardTitle'] = 'New Ticket';

$this->title = 'Support';

?>

<?= $form->field($ticketHead, 'user_id')->dropDownList(ArrayHelper::map($users, 'id', 'label'), ['prompt' => '...']);?>

<?= $form->field($ticketHead, 'department')->dropDownList($ticketHead->departmentList);?>

<?= $form->field($ticketHead, 'topic')->textInput();?>

<?= $form->field($ticketBody, 'text')->textarea(['rows' => 5, 'style' => 'resize: none;']);?>

<div class="form-group">

    <?= Html::submitButton(Yii::t('ticket', 'Send Ticket'), ['class' => 'btn btn-primary']);?>

</div>

<?= $form->errorSummary([$ticketBody, $ticketHead]);?>

<?php $form->end();?>
