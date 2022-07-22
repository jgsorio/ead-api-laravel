<?php

namespace App\Repositories;

use App\Models\Lesson;
use App\Models\View;
use App\Repositories\Traits\TraitRepository;
use Illuminate\Support\Facades\Auth;

class LessonRepository
{
    use TraitRepository;

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

    public function markLessonViewed(string $lessonId)
    {
       $user = $this->getAuthUser();

       $view = $user->views()->where('lesson_id', $lessonId)->first();

        if ($view) {
            $view->update([
                'quantity' => $view->quantity + 1
            ]);
        }

        return $user->views()->create([
            'lesson_id' => $lessonId,
            'quantity' => 1
        ]);
    }
}
