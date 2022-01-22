<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LinksPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'descripcion' => ['required', 'max:255'],
            'link' => ['required', 'max:255', 'url'],
            'tipo-link_id' => ['required', 'integer', 'gt:0']
        ];
    }
}
