<?php
namespace App\Http\Requests;

class ResetPasswordRequest extends BaseRequest
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
            'email'                 => 'required|email',
            'password'              => 'required',
            'password_confirmation' => 'required',
            'token'                 => 'required',
        ];
    }

    public function messages()
    {
        return [
            'token.required'                 => 'Token is required',
            'email.required'                 => 'メールアドレスを入力してください',
            'email.email'                    => 'メールアドレスの形式が正しくありません。',
            'password.required'              => 'パスワードを入力してください',
            'password_confirmation.required' => '入力したパスワードと異なります',
        ];
    }
}
