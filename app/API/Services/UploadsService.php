<?php

namespace App\API\Services;

use App\Models\Uploads;

class UploadsService {

    public function storeFile(
         array $validatedData,
         object $file): Uploads
    {
        $filename = $file->getClientOriginalName();
        $file->storeAs( 1, $filename, 'public');

        $validatedData['media'] = $filename;
        $validatedData['size'] = $file->getSize();
        $validatedData['type'] = $file->getMimeType();

        $media = Uploads::create($validatedData);

        return $media;
    }

}