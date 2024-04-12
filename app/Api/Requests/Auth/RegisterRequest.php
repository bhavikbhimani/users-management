<?php

namespace App\Api\Requests\Auth;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    	
    public function rules()
    {
        return [
			'name'     => 'required|string',
			'email'    => 'required|string|email|max:255',
			'password' => 'required|string|min:8',
		];
    }
}
