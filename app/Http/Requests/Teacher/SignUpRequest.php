<?php
namespace App\Http\Requests\Teacher;

use App\Http\Requests\BaseRequest;

class SignUpRequest extends BaseRequest
{
    /*
     * Redirect action when validate fail
     * */
    protected $redirectAction = 'User\AuthController@getSignUp';

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
            'email'    => 'required|email|unique:users,email',
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
