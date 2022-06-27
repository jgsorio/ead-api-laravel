<?php

namespace App\Repositories;

use App\Models\Module;

class ModuleRepository
{
    private $entity;

    public function __construct(Module $module)
    {
        $this->entity = $module;
    }

    public function getModulesByCourseId($courseId)
    {
        return $this->entity->where('course_id', $courseId)->get();
    }
}
