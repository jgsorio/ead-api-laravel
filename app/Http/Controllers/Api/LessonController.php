<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LessonResource;
use App\Repositories\LessonRepository;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    private $repository;

    public function __construct(LessonRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(string $module_id)
    {
        $lessons = $this->repository->getLessonsByModuleId($module_id);
        return LessonResource::collection($lessons);
    }

    public function show(string $lessonId)
    {
        return new LessonResource($this->repository->getLesson($lessonId));
    }
}
