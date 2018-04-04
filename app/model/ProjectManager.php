<?php

namespace App\Model;

use App\Model\BaseManager;

class ProjectManager extends BaseManager
{
    const
        TABLE_NAME = 'project',
        COLUMN_ID = 'id';

    public function getProject($id)
    {
        return $this->database->table(self::TABLE_NAME)->where(self::COLUMN_ID, $id)->fetch();
    }

    public function getProjects()
    {
        return $this->database->table(self::TABLE_NAME)->order(self::COLUMN_ID . ' ASC');
    }

    public function getProjectsSorted($order)
    {
        return $this->database->table(self::TABLE_NAME)->order($order . ' ASC');
    }

    public function findProjects($limit, $offset)
    {
        return iterator_to_array($this->database->table(self::TABLE_NAME)->limit($limit, $offset)->order(self::COLUMN_ID));
    }

    public function getProjectsCount()
    {
        return $this->database->fetchField('SELECT COUNT(*) FROM ' . self::TABLE_NAME);
    }

    public function saveProject($project)
    {
        if (!$project[self::COLUMN_ID])
        {
            $this->database->table(self::TABLE_NAME)->insert($project);
        }
        else
        {
            $this->database->table(self::TABLE_NAME)->where(self::COLUMN_ID, $project[self::COLUMN_ID])->update($project);
        }
    }

    public function removeProject($projectId)
    {
        $this->database->table(self::TABLE_NAME)->where(self::COLUMN_ID, $projectId)->delete();
    }
}