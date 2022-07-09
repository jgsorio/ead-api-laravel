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
            ->get();
    }

    private function getAuthUser()
    {
        return User::where('id', 'd33e7c7d-07c7-4b92-8079-4f3f7a4ceae9')->first();
    }
}
