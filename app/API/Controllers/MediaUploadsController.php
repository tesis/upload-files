<?php

namespace App\API\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Uploads;
use App\Http\Requests\UploadsRequest;
use App\Http\Resources\UploadsResource;
use App\API\Services\UploadsService;

class MediaUploadsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        // $uploads = Uploads::all();
        $uploads = Uploads::where('user_id', $user->id)->get();

        return UploadsResource::collection($uploads);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UploadsRequest $request, UploadsService $service)
    {
        $user = auth()->user();

        $media = $service->storeFile(
            $request->validated(),
            $request->file('media')
        );

        return new UploadsResource($media);

    }

}
