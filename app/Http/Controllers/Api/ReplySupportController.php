<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReplySupport;
use App\Http\Resources\ReplySupportResource;
use App\Repositories\ReplySupportRepository;
use Exception;
use Illuminate\Http\Request;

class ReplySupportController extends Controller
{
    private $repository;

    public function __construct(ReplySupportRepository $repository)
    {
        $this->repository = $repository;
    }

    public function store(StoreReplySupport $request)
    {
        try {
            $reply = $this->repository->storeReplyToSupportId($request->validated());
            return new ReplySupportResource($reply);
        } catch (Exception $e)
        {
            throw new Exception($e->getMessage(), 3);
        }
    }
}
