<?php

namespace ricco\ticket\models;

class TicketHeadQuery extends \yii\db\ActiveQuery
{

    public function statusAnswer()
    {
        return $this->andWhere([
            'status' => TicketHead::STATUS_ANSWER
        ]);
    }

    public function userId($userId)
    {
        return $this->andWhere([
            'user_id' => $userId
        ]);
    }

}