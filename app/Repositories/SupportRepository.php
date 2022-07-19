<?php

namespace App\Repositories;

use App\Models\Support;
use App\Repositories\Traits\TraitRepository;

class SupportRepository
{
    use TraitRepository;

    private $entity;

    public function __construct(Support $entity)
    {
        $this->entity = $entity;
    }

    public function getAllSupports(array $filters = [])
    {
        return $this->entity
            ->where(function($query) use ($filters) {
                if (isset($filters['lesson'])) {
                    $query->where('lesson_id', $filters['lesson']);
                }

                if (isset($filters['status'])) {
                    $query->where('status', $filters['status']);
                }

                if (isset($filters['description'])) {
                    $query->where('status', 'like',  "%{$filters['description']}%");
                }

                if (isset($filters['user'])) {
                    $user = $this->getAuthUser();
                    $query->where('user_id', $user->id);
                }
            })
            ->orderBy('updated_at')
            ->get();
    }

    public function storeSupport(array $data): Support
    {
        $user = $this->getAuthUser();

        return $this->entity->create([
            'lesson_id' => $data['lesson'],
            'user_id' => $user->id,
            'description' => $data['description'],
            'status' => $data['status']
        ]);
    }

    public function getSupport(string $supportId)
    {
        return $this->entity->where('id', $supportId)->first();
    }
}
