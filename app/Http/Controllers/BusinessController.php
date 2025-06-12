<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;
use App\Services\BusinessService;

class BusinessController extends Controller
{
    public function show($slug, BusinessService $service)
    {
        $data = $service->showBusinessWithRelated($slug);

        return view('business.show', $data);
    }


}
