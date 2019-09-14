<?php

namespace ricco\ticket\forms;

class TicketHeadForm extends \ricco\ticket\models\TicketHead
{

    public function init()
    {
        parent::init();

        $this->status = static::STATUS_OPEN;
    }

    public function scenarios()
    {
        return [
            $this->scenario => [
                'department',
                'topic'
            ]
        ];
    }

}