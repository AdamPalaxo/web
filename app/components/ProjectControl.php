<?php

namespace App\Components;

use Nette\Application\UI\Form;
use App\Bs3FormRenderer;

/**
 * Třída ProjectControl
 * slouží k vytvoření formu
 * pro editaci projektů.
 */
class ProjectControl extends BaseComponent
{
    public $onProjectSave;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Metoda pro vytvoření formu, ve kterém lze přidávat
     * a editovat projekty.
     *
     * @return Form
     */
    protected function createComponentProjectForm()
    {
        $options = [
            'time' => 'časově omezený projekt',
            'continuous' => 'Continuous Integration',
        ];

        $form = new Form;
        $form->setRenderer(new Bs3FormRenderer());
        $form->addHidden('id');
        $form->addText('title', 'Název:')
            ->setRequired('Název je povinný údaj!');
        $form->addText('deadline', 'Vytvořen:')
            ->setHtmlAttribute('placeholder', 'DD.MM.YYYY')
            ->setRequired('Datum odevzdání je povinný údaj!')
            ->addRule(FormRules::DATE, "Datum musí být ve formátu DD.MM.YYYY");
        $form->addSelect('type','Typ:', $options)
            ->setRequired('Typ projektu je povinný údaj');
        $form->addCheckbox('web_project', ' webový projekt');
        $form->addSubmit('send', 'Uložit projekt');

        $form->onSuccess[] = [$this, 'processForm'];

        return $form;
    }

    /**
     * Metoda pro zpracování
     * vstupu z formu.
     *
     * @param $form form
     * @param $values array hodnoty z formu
     */
    public function processForm($form, $values)
    {
        $this->onProjectSave($this, $values);
    }


}

/** rozhranní pro generovanou továrnu */
interface IProjectFormFactory
{
    /**
     * @return ProjectControl
     */
    function create();
}