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
        ->latest('id')
        ->paginate(20);

        return OfficeResource::collection(

            $offices
        );
    }
}
