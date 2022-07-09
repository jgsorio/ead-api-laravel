<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSupport;
use App\Http\Resources\SupportResource;
use App\Repositories\SupportRepository;
use Exception;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    private $repository;

    public function __construct(SupportRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $supports = $this->repository->getAllSupports($request->all());
        return SupportResource::collection($supports);
    }

    public function store(StoreSupport $request)
    {
        try {
            $support = $this->repository->storeSupport($request->validated());
            return new SupportResource($support);
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 3);
        }
    }
}
