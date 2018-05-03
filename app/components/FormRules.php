<?php


namespace App\Components;

use Nette\Forms\IControl;
use Nette\Utils\DateTime;

/**
 * Třída FormRules složí k validaci
 * polí formu, například datumu.
 * @package App\Components
 */
class FormRules
{
    const DATE = 'App\Components\FormRules::validateDate';

    /**
     * Validace datumu ve formu.
     *
     * @param IControl $control kontrolovaný form
     * @return false|static false - nevalidní datum
     *                      static - datum v pořádku
     */
    public static function validateDate(IControl $control)
    {
        return DateTime::createFromFormat('d.m.Y', $control->getValue());
    }
}