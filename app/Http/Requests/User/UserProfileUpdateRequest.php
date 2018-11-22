<?php
namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;
use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use App\Services\UserServiceInterface;

class UserProfileUpdateRequest extends BaseRequest
{
    /** @var \App\Repositories\UserRepositoryInterface */
    protected $userRepository;

    /** @var \App\Services\UserServiceInterface */
    protected $userService;

    public function __construct(
        UserRepositoryInterface $userRepository,
        UserServiceInterface $userService
    ) {
        $this->userRepository = $userRepository;
        $this->userService    = $userService;
    }

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
        $user  = $this->userService->getUser();
        $rules = [
            'name'          => 'required|max:255|min:2',
            'year_of_birth' => 'required|date_format:Y',

        ];
        if ((bool) \Request::get('password')) {
            $passwordRules = [
                'current_password'      => 'required|min:6|old_password',
                'password'              => 'required|min:6|confirmed',
                'password_confirmation' => 'required|min:6',
            ];
            $rules = array_merge($rules, $passwordRules);
        }
        if ((bool) \Request::get('email') and !empty($user)) {
            $emailRules = [
                'email' => 'required|email|different:old_email|unique:email_logs,new_email|unique:email_logs,old_email|unique:users,email,'.$user->id,
                ];
            if (empty($user->userServicesAuthentications)) {
                $emailRules['current_password'] = 'required|min:6|old_password';
            }

            $rules = array_merge($rules, $emailRules);
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required'                  => trans('validation.name_required'),
            'name.min'                       => trans('validation.name_min'),
            'name.max'                       => trans('validation.name_max'),
            'year_of_birth.required'         => trans('validation.year_of_birth_required'),
            'year_of_birth.date_format'      => trans('validation.year_of_birth_date_format'),
            'gender.required'                => trans('validation.gender_required'),
            'gender.max'                     => trans('validation.gender_max'),
            'gender.min'                     => trans('validation.gender_min'),
            'living_country_code.required'   => trans('validation.living_country_code_required'),
            'living_country_code.max'        => trans('validation.living_country_code_max'),
            'living_country_code.min'        => trans('validation.living_country_code_min'),
            'living_city_id.required'        => trans('validation.living_city_id_required'),
            'current_password.required'      => trans('validation.current_password_required'),
            'current_password.min'           => trans('validation.current_password_min'),
            'current_password.old_password'  => trans('validation.current_password_old_password'),
            'password.confirmed'             => trans('validation.password_confirmed'),
            'password.required'              => trans('validation.password_required'),
            'password.min'                   => trans('validation.password_min'),
            'password_confirmation.required' => trans('validation.password_confirmation_required'),
            'password_confirmation.min'      => trans('validation.password_confirmation_min'),
            'email.different'                => trans('validation.email_different'),
            'email.unique'                   => trans('validation.email_unique'),
        ];
    }
}
