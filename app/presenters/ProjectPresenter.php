<?php

namespace App\Presenters;

use App\Model\ProjectManager;
use App\Bs3FormRenderer;

use Nette\Application\UI\Form;

class ProjectPresenter extends BasePresenter
{
    /** @var ProjectManager */
    protected $projectManager;

    public function __construct(ProjectManager $projectManager)
    {
        parent::__construct();
        $this->projectManager = $projectManager;
    }

    public function actionEdit($projectId)
    {
        if ($project = $this->projectManager->getProject($projectId))
        {
            $values = $project->toArray();
            $values['deadline'] = strftime("%Y-%m-%d", strtotime($values['deadline']));
            $this['projectForm']->setDefaults($values);
        }
        else
        {
            $this->flashMessage('Projekt nebyl nalezen.', 'warning');
        }
    }

    public function actionRemove($projectId)
    {
        $this->projectManager->removeProject($projectId);
        $this->flashMessage('Článek byl úspěšně odstraněn.', 'success');
        $this->redirect('Homepage:default');
    }

    public function actionShow($projectId)
    {
        if ($project = $this->projectManager->getProject($projectId))
        {
            $values = $project->toArray();
            $values['deadline'] = strftime("%Y-%m-%d", strtotime($values['deadline']));
            $this['projectForm']->setDefaults($values);
            $this->template->project = $project;
        }
        else
        {
            $this->flashMessage('Projekt nebyl nalezen.', 'warning');
        }
    }

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
            ->setRequired('Datum odevzdání je povinný údaj!')
            ->setType('date');
        $form->addSelect('type','Typ:', $options)
            ->setRequired('Typ projektu je povinný údaj');
        $form->addCheckbox('web_project', ' webový projekt');
        $form->addSubmit('send', 'Uložit projekt');
        $form->onSuccess[] = [$this, 'projectFormSucceeded'];

        return $form;
    }

    public function projectFormSucceeded($form, $values)
    {
        $this->projectManager->saveProject($values);
        $this->flashMessage('Projekt úspěšně uložen.', 'success');
        $this->redirect(':Homepage:default');
    }




}