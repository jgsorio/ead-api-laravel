<?php

namespace App\Repositories;

use App\Models\Support;
use App\Models\User;

class SupportRepository
{
    private $entity;

    public function __construct(Support $entity)
    {
        $this->entity = $entity;
    }

    public function getAllSupports(array $filters = [])
    {
        return $this->getAuthUser()
            ->support()
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

    public function storeReplyToSupportId(string $supportId, array $data)
    {
        $user = $this->getAuthUser();

        return $this->getSupport($supportId)
            ->replies()
            ->create([
                'description' => $data['description'],
                'user_id' => $user->id
            ]);
    }

    private function getSupport(string $supportId)
    {
        return $this->entity->where('id', $supportId)->first();
    }

    private function getAuthUser()
    {
        return User::where('id', '8bfcfa03-8855-4c31-ab80-a0265a255a7d')->first();
    }
}
