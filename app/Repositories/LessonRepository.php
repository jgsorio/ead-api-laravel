<?php

namespace App\Repositories;

use App\Models\Lesson;

class LessonRepository
{
    private $entity;

    public function __construct(Lesson $lesson)
    {
        $this->entity = $lesson;
    }

    public function getLessonsByModuleId(string $module_id)
    {
        return $this->entity->where('module_id', $module_id)->get();
    }

    public function getLesson(string $identify)
    {
        return $this->entity->findOrFail($identify);
    }
}
