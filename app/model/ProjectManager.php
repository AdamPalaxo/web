<?php

namespace App\Model;

use App\Model\BaseManager;
use Nette\Utils\DateTime;

/**
 * Třída ProjectManager se stará o
 * přidání, čtení, editaci a mazání projektů v databázi.
 *
 * @package App\Model
 */
class ProjectManager extends BaseManager
{
    const
        TABLE_NAME = 'project',
        COLUMN_ID = 'id';

    /**
     * Vrácení projektu podle id.
     *
     * @param $id int id projektu
     * @return false|\Nette\Database\Table\ActiveRow
     */
    public function getProject($id)
    {
        return $this->database->table(self::TABLE_NAME)->where(self::COLUMN_ID, $id)->fetch();
    }


    /**
     * Navrací projekty z daného výběru.
     *
     * @param $limit int počet projektů
     * @param $offset int posunutí dolní hranice výčtu
     * @param $sort string řazení podle daného sloupce
     * @param $order string pořadí prvků
     * @return \Nette\Database\Table\Selection výběr z databáze
     */
    public function findProjects($limit, $offset, $sort, $order)
    {
        if ($order === 'asc')
        {
            return $this->database->table(self::TABLE_NAME)->limit($limit, $offset)->order($sort . ' ASC');
        }
        return $this->database->table(self::TABLE_NAME)->limit($limit, $offset)->order($sort . ' DESC');
    }

    /**
     * Vrací celkový počet projektů.
     *
     * @return int počet projektů
     */
    public function getProjectsCount()
    {
        return $this->database->table(self::TABLE_NAME)->count();
    }

    /**
     * Uloží nového projektu, popřípadě
     * editace (update) projektu stávajícího.
     *
     * @param $project object projekt ke vložení
     * @return bool true - uložení se podařilo
     *              false - uložení se selhalo
     */
    public function saveProject($project, $dateFormat = 'd.m.Y')
    {
        $project['deadline'] = DateTime::createFromFormat($dateFormat, $project['deadline']);


        if (!$project[self::COLUMN_ID])
        {
            if ($this->database->table(self::TABLE_NAME)->insert($project))
            {
                return TRUE;
            }
        }
        else
        {
            if ($this->database->table(self::TABLE_NAME)->where(self::COLUMN_ID, $project[self::COLUMN_ID])->update($project))
            {
                return TRUE;
            }
        }

        return FALSE;
    }

    /**
     * Odstranění projektu z databáze.
     *
     * @param $projectId int id projektu
     * @return bool
     */
    public function removeProject($projectId)
    {
        if ($this->database->table(self::TABLE_NAME)->where(self::COLUMN_ID, $projectId)->delete())
        {
            return TRUE;
        }

        return FALSE;
    }
}