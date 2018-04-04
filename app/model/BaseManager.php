<?php

namespace App\Model;

use Nette\Database\Context;
use Nette\SmartObject;

/*
 * Základní model pro dědění
 */
abstract class BaseManager
{
    /** @var Context */
    protected $database;

    public function __construct(Context $database)
    {
        $this->database = $database;
    }

}

