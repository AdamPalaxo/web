<?php

namespace App\Enum;

class ProjectTypes
{
    const TIME = 'time';
    const CONTINUOUS = 'continuous';

    public static $states = [
        self::TIME => 'časově omezený projekt',
        self::CONTINUOUS => 'Continuous Integration',
    ];

}