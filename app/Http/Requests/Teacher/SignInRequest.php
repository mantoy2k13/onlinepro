<?php
namespace App\Http\Requests\Teacher;

use App\Http\Requests\BaseRequest;

class SignInRequest extends BaseRequest
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
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ];
    }

    public function messages()
    {
        return [
            'email.required'    => trans('validation.email_required'),
            'email.email'       => trans('validation.email_email'),
            'password.required' => trans('validation.password_required'),
            'password.min'      => trans('validation.password_min'),
        ];
    }
}
