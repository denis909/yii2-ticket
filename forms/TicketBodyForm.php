<?php

namespace ricco\ticket\forms;

use Exception;

class TicketBodyForm extends \ricco\ticket\models\TicketBody
{

    public function init()
    {
        parent::init();

        $this->is_client = 1;
    }

    public function scenarios()
    {
        return [
            $this->scenario => [
                'text'
            ]
        ];
    }

}