<?php

namespace App\Components;

use Nette\Application\UI\Control;
use ReflectionObject;

/**
 * Třída BaseComponent určená k dědění.
 */
abstract class BaseComponent extends Control
{
    /** @var string jméno latte šablony */
    private $templateName;

    public function __construct()
    {
        parent::__construct();
        $reflector = new ReflectionObject($this);
        $this->templateName = str_replace(".php", ".latte", $reflector->getFileName());
    }

    /**
     * Renderování výstupu.
     */
    public function render()
    {
        $template = $this->template;
        $template->setFile($this->templateName);

        $template->render();
    }
}


