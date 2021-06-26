<?php
namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

/**
 * Messeger
 * Option: https://hocwebchuan.com/tutorial/laravel/laravel_validate_values.php
 * Request Option: https://gist.github.com/jeffochoa/a162fc4381d69a2d862dafa61cda0798
 */
trait MsgCommons
{
    public function messages()
    {
        return [
            '*.required' => ':attribute Không được bỏ trống',
            '*.date' => ':attribute chứa thời gian không hợp lệ',
            '*.after' => ':attribute không hợp lệ',
            '*.exists' => ':attribute không tồn tại trên hệ thống',
            '*.regex' => ':attribute phải giống với dạng thức cung cấp'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(api_errors_common('Errors Validate', $validator->errors()), Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
