<?php

namespace App\Http\Controllers;

use App\Http\Resources\OfficeResource;
use App\Models\Office;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OfficeController extends Controller
{   
    public function __invoke()
{
    return $this->index();
}

    
    public function index(): AnonymousResourceCollection
    {
        $offices = Office::query()
        ->where('approval_status', Office::APPROVAL_APPROVED)
        ->when(request('host_id'), fn ($builder) => $builder->whereUserId(request('host_id')))
        ->when(request('user_id'), fn ($builder) => $builder->whereRelation('reservations','user_id', '=', request('user_id')))
        ->where('hidden',false)
        ->with(['images','tags','user'])
        ->latest('id')
        ->paginate(20);

        return OfficeResource::collection(
            $offices
        );
    }
}
