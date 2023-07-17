<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'media' => 'required|mimetypes:image/jpg,image/jpeg,image/png,image/gif,video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/avi|max:204800',
        ];
    }
}
