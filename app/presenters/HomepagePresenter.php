<?php

namespace App\Presenters;

use App\Model\ProjectManager;
use Nette\Utils\Paginator;

use Nette;

/**
 * Třída HomepagePresenter se
 * statrá o vykreslení projektů.
 */
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

    /**
     * Změna sloupce a směru řazení.
     *
     * @param string $order sloupec podle kterého se řadí
     * @param string $sort směr řazení
     */
    public function actionDefault($order, $sort = 'asc')
    {
        $this->order = (string)$order;
        $this->sort = $sort === 'desc' ? 'desc' : 'asc';
    }

    /**
     * Renderování projektů.
     *
     * @param int $page pozžadovaná stránka s projekty
     */
    public function renderDefault($page = 1)
    {
        $this->template->order = $this->order;
        $this->template->sort = $this->sort;

        $projectsCount = $this->projectManager->getProjectsCount();

        $paginator = new Paginator();
        $paginator->setItemCount($projectsCount);
        $paginator->setItemsPerPage(10);
        $paginator->setPage($page);

        $projects = $this->projectManager->findProjects($paginator->getLength(), $paginator->getOffset(), $this->order, $this->sort);

        $this->template->projects = $projects;
        $this->template->paginator = $paginator;
    }
}
