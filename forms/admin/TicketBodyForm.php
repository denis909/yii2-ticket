<?php

namespace ricco\ticket\forms\admin;

use Exception;

class TicketBodyForm extends \ricco\ticket\models\TicketBody
{

    public function init()
    {
        parent::init();

        $this->is_client = 0;
    }

}