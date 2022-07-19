<?php

namespace App\Repositories;

use App\Models\ReplySupport;
use App\Repositories\Traits\TraitRepository;

class ReplySupportRepository
{
    use TraitRepository;

    private $entity;

    public function __construct(ReplySupport $entity)
    {
        $this->entity = $entity;
    }

    public function storeReplyToSupportId(array $data)
    {
        $user = $this->getAuthUser();

        return $this->entity
            ->create([
                'description' => $data['description'],
                'support_id' => $data['support'],
                'user_id' => $user->id
            ]);
    }
}
