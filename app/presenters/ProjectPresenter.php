<?php

namespace App\Presenters;

use App\Components\ProjectControl;
use App\Components\IProjectFormFactory;
use App\Model\ProjectManager;

/**
 * Třída ProjectPresenter
 * se stará o zobrazení,
 * editaci a mazání projektů
 * pomocí formu.
 */
class ProjectPresenter extends BasePresenter
{

    /** @var IProjectFormFactory @inject */
    public $projectFormFactory;

    /** @var ProjectManager */
    protected $projectManager;

    public function __construct(ProjectManager $projectManager)
    {
        parent::__construct();
        $this->projectManager = $projectManager;
    }

    /**
     * Editace projektu.
     *
     * @param $projectId int id projektu
     */
    public function actionEdit($projectId)
    {
        if ($project = $this->projectManager->getProject($projectId))
        {
            $values = $project->toArray();
            $values['deadline'] = strftime("%d.%m.%Y", strtotime($values['deadline']));

            $this['projectForm']['projectForm']->setDefaults($values);
        }
        else
        {
            $this->flashMessage('Projekt nebyl nalezen.', 'warning');
        }
    }

    /**
     * Smazání projektu.
     *
     * @param $projectId int id projektu
     */
    public function actionRemove($projectId)
    {
        if ($this->projectManager->removeProject($projectId))
        {
            $this->flashMessage('Projekt úspěšně smazán.', 'success');
        }
        else
        {
            $this->flashMessage('Projekt se nepodařilo smazat.', 'danger');
        }
        $this->redirect('Homepage:default');
    }

    /**
     * Zobrazení projektu.
     *
     * @param $projectId int id projektu
     */
    public function actionShow($projectId)
    {
        if ($project = $this->projectManager->getProject($projectId))
        {
            $values = $project->toArray();
            $values['deadline'] = strftime("%d.%m.%Y", strtotime($values['deadline']));
            $this['projectForm']['projectForm']->setDefaults($values);
            $this->template->project = $project;
        }
        else
        {
            $this->flashMessage('Projekt nebyl nalezen.', 'warning');
        }
    }

    /**
     * Vytvoření formu pro
     * vytvoření a editaci formu.
     *
     * @return ProjectControl form
     */
    protected function createComponentProjectForm()
    {
        $form = $this->projectFormFactory->create();
        $form->onProjectSave[] = function (ProjectControl $form, $values)
        {
            if ($this->projectManager->saveProject($values))
            {
                $this->flashMessage('Projekt úspěšně uložen.', 'success');
            }
            else
            {
                $this->flashMessage('Projekt se nepodařilo uložit.', 'danger');
            }
            $this->redirect(':Homepage:default');
        };

        return $form;
    }



}