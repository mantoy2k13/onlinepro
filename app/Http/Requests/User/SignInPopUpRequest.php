<?php
namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;

class SignInPopUpRequest extends BaseRequest
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
            'field_email'    => 'required|email',
            'field_password' => 'required|min:6',
        ];
    }

    public function messages()
    {
        return [
            'email.required'          => trans('validation.email_required'),
            'email.email'             => trans('validation.email_email'),
            'field_password.required' => trans('validation.password_required'),
            'field_password.min'      => trans('validation.password_min'),
        ];
    }
}
