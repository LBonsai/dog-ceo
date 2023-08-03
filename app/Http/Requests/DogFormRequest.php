<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

/**
 * DogFormRequest
 *
 * @package App\Http\Requests
 * @author Lee Benedict Baniqued
 * @since 2023.08.02
 * @version 1.0
 */
class DogFormRequest extends FormRequest
{
    /**
     * authorize
     * Determine if the user is authorized to make this request.
     * @since 2023.07.07
     * @return bool
     */
    public function authorize() : bool
    {
        return true;
    }

    /**
     * rules
     * Get the validation rules that apply to the request.
     * @since 2023.08.02
     * @return array
     */
    public function rules() : array
    {
        return [
            'id'    => ['sometimes', 'integer'],
            'name'  => ['required', 'string', 'regex:/^[A-Za-z ]{1,50}$/', 'unique:dog,name,' . (int)Route::current()->parameter('id')],
            'url'   => ['required', 'string', 'regex:/^https:\/\//']
        ];
    }

    /**
     * messages
     * Set custom messages for input fields errors
     * @since 2023.08.02
     * @return array
     */
    public function messages() : array
    {
        return [
            'name.required' => 'Name is a required field.',
            'name.regex'    => 'Name should only contain letters, spaces. It must be between 1 and 50 characters long.',
            'name.unique'   => 'Name you entered is already exists. Please choose a different name.',
            'url.required'  => 'URL is a required field.',
            'url.regex'     => 'URL must be in the format "https://"'
        ];
    }
}
