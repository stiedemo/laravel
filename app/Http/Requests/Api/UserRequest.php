<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\MsgCommons;

class UserRequest extends FormRequest
{
    use MsgCommons;
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

        ];
    }

    public function attributes()
    {
        return [

        ];
    }
}
