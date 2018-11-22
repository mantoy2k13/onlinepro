<?php
namespace App\Http\Requests\Teacher;

use App\Http\Requests\BaseRequest;

class ReviewRequest extends BaseRequest
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
            'booking_id' => 'required',
            'content'    => 'required',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => '',
            'email.email'    => '',
        ];
    }
}
