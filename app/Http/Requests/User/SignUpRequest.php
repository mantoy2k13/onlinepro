<?php
namespace App\Http\Requests\User;

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
            'email'                           => 'required|email|unique:email_logs,old_email|unique:users,email|unique:email_logs,new_email',
            'name'                            => 'required',
            'password'                        => 'required|min:6|confirmed',
            'password_confirmation'           => 'required|min:6',
            'accept_terms_and_privacy_policy' => 'required',
            'skype_id'                        => 'required',
        ];
    }

    public function messages()
    {
        return [
            'email.required'                           => trans('validation.email_required'),
            'email.email'                              => trans('validation.email_email'),
            'email.unique'                             => trans('validation.email_unique'),
            'name.required'                            => trans('validation.name_required'),
            'password.required'                        => trans('validation.password_required'),
            'password_confirmation.required'           => trans('validation.password_confirmation_required'),
            'password.min'                             => trans('validation.password_min'),
            'password_confirmation.min'                => trans('validation.password_confirmation_min'),
            'accept_terms_and_privacy_policy.required' => trans('validation.accept_terms_and_privacy_policy_required'),
            'password.confirmed'                       => trans('validation.password_confirmed'),
            'skype_id.required'                        => trans('validation.skype_id_required'),
        ];
    }
}
