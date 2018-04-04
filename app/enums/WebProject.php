<?php

namespace App\Enum;

class WebProject
{
    const NO = 0;
    const YES = 1;

    public static $states = [
        self::NO => 'NE',
        self::YES => 'ANO',
    ];

}