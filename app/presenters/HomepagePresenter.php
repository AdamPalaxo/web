<?php

namespace App\Presenters;

use App\Model\ProjectManager;
use Nette\Utils\Paginator;

use Nette;


class HomepagePresenter extends Nette\Application\UI\Presenter
{
    /**
     * @var string
     * @persistent
     */
    public $order = 'id';

    /**
     * @var string
     * @persistent
     */
    public $sort = 'asc';

    /** @var ProjectManager */
    protected $projectManager;

    public function __construct(ProjectManager $projectManager)
    {
        parent::__construct();
        $this->projectManager = $projectManager;
    }

    public function actionDefault($order, $sort = 'asc')
    {
        $this->order = (string)$order;
        $this->sort = $sort === 'desc' ? 'desc' : 'asc';
    }

    public function renderDefault($page = 1)
    {
        $this->template->order = $this->order;
        $this->template->sort = $this->sort;

        $projectsCount = $this->projectManager->getProjectsCount();

        $paginator = new Paginator();
        $paginator->setItemCount($projectsCount);
        $paginator->setItemsPerPage(10);
        $paginator->setPage($page);

        $projects = $this->projectManager->findProjects($paginator->getLength(), $paginator->getOffset());
        $projects = $this->sortData($projects);

        $this->template->projects = $projects;
        $this->template->paginator = $paginator;
    }

    /**
     * Seřazení dat v tabulce
     *
     * @param $projects array řazené projekty
     * @return mixed seřazené projekty
     */
    private function sortData($projects)
    {
        foreach ($projects as $key => $row)
        {
            $data[$key] = $row[$this->order];
        }

        if ($this->sort !== 'asc')
        {
            array_multisort($data, SORT_DESC, $projects);

        }
        else
        {
            array_multisort($data, SORT_ASC, $projects);
        }

        return $projects;
    }
}
