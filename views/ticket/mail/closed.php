<?php
use ricco\ticket\models\TicketHead;
?>
<p style="text-align: left; font-size: 14px;"><?= \yii\bootstrap\Html::encode($textTicket)?></p>
<hr/>
<p>
    <strong><?= Yii::t('ticket', 'Ticket') ?>:&nbsp;</strong><?=$nameTicket?>
    <br/>
    <strong><?= Yii::t('ticket', 'Status') ?>:&nbsp;</strong>
    <?php
    switch ($status) {
        case TicketHead::STATUS_OPEN :
            echo Yii::t('ticket', 'Open');break;
        case TicketHead::STATUS_WAIT :
            echo Yii::t('ticket', 'Waiting');break;
        case TicketHead::STATUS_ANSWER :
            echo Yii::t('ticket', 'Answer');break;
        case TicketHead::STATUS_CLOSED :
            echo Yii::t('ticket', 'Close');break;
    }
    ?>
    <br/>
    <strong><?= Yii::t('ticket', 'Link') ?>:&nbsp;
        <a
            href="<?=$link?>"><?=$link?>
        </a>
    </strong>
</p>
<hr/>
<em>
    <span style="color: #808080;"><?= Yii::t('ticket', 'This email is generated automatically by the system notification service. You do not need to respond to it.') ?></span>
</em>
