<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'The :attribute must be accepted.',
    'active_url' => 'The :attribute is not a valid URL.',
    'after' => 'The :attribute must be a date after :date.',
    'alpha' => 'The :attribute may only contain letters.',
    'alpha_dash' => 'The :attribute may only contain letters, numbers, and dashes.',
    'alpha_num' => 'The :attribute may only contain letters and numbers.',
    'array' => 'The :attribute must be an array.',
    'before' => 'The :attribute must be a date before :date.',
    'between' => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file' => 'The :attribute must be between :min and :max kilobytes.',
        'string' => 'The :attribute must be between :min and :max characters.',
        'array' => 'The :attribute must have between :min and :max items.',
    ],
    'boolean' => 'The :attribute field must be true or false.',
    'confirmed' => 'The :attribute confirmation does not match.',
    'date' => 'The :attribute is not a valid date.',
    'date_format' => 'The :attribute does not match the format :format.',
    'different' => 'The :attribute and :other must be different.',
    'digits' => 'The :attribute must be :digits digits.',
    'digits_between' => 'The :attribute must be between :min and :max digits.',
    'email' => 'The :attribute must be a valid email address.',
    'exists' => 'The selected :attribute is sai định dạng.',
    'filled' => 'The :attribute field không được trống.',
    'image' => 'The :attribute must be an image.',
    'in' => 'The selected :attribute is sai định dạng.',
    'integer' => 'The :attribute must be an integer.',
    'ip' => 'The :attribute must be a valid IP address.',
    'json' => 'The :attribute must be a valid JSON string.',
    'max' => [
        'numeric' => 'The :attribute may not be greater than :max.',
        'file' => 'The :attribute may not be greater than :max kilobytes.',
        'string' => 'The :attribute may not be greater than :max characters.',
        'array' => 'The :attribute may not have more than :max items.',
    ],
    'mimes' => 'The :attribute must be a file of type: :values.',
    'min' => [
        'numeric' => 'The :attribute must be at least :min.',
        'file' => 'The :attribute must be at least :min kilobytes.',
        'string' => 'The :attribute must be at least :min characters.',
        'array' => 'The :attribute must have at least :min items.',
    ],
    'not_in' => 'The selected :attribute is sai định dạng.',
    'numeric' => 'The :attribute must be a number.',
    'regex' => 'The :attribute format is sai định dạng.',
    'required' => 'The :attribute field không được trống.',
    'required_if' => 'The :attribute field không được trống when :other is :value.',
    'required_unless' => 'The :attribute field không được trống unless :other is in :values.',
    'required_with' => 'The :attribute field không được trống when :values is present.',
    'required_with_all' => 'The :attribute field không được trống when :values is present.',
    'required_without' => 'The :attribute field không được trống when :values is not present.',
    'required_without_all' => 'The :attribute field không được trống when none of :values are present.',
    'same' => 'The :attribute and :other must match.',
    'size' => [
        'numeric' => 'The :attribute must be :size.',
        'file' => 'The :attribute must be :size kilobytes.',
        'string' => 'The :attribute must be :size characters.',
        'array' => 'The :attribute must contain :size items.',
    ],
    'string' => 'The :attribute must be a string.',
    'timezone' => 'The :attribute must be a valid zone.',
    'unique' => 'The :attribute has already been taken.',
    'url' => 'The :attribute format is sai định dạng.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'old_password' => 'The :attribute is not correct.',
    ],
    'email_required' => 'Email không được trống.',
    'email_email' => 'Email must be a valid email address.。',
    'name_required' => 'Name không được trống.',
    'name_min' => 'Name must be at least :min.',
    'name_max' => 'Name must be at least :max.',
    'password_required' => 'Password không được trống.',
    'password_confirmation_required' => 'Password confirm không được trống.',
    'password_min' => 'Password must be at least :min.',
    'password_confirmation_min' => 'Password confirm must be at least :min.',
    'accept_terms_and_privacy_policy_required' => 'You must our accept terms and privacy policy.',
    'year_of_birth_required' => 'Year of birth không được trống.',
    'year_of_birth_date_format' => 'Year of birth must be a valid year format.',
    'gender_required' => 'Gender không được trống.',
    'gender_max' => 'Gender must be at least :max.',
    'gender_min' => 'Gender must be at least :min.',
    'living_country_code_required' => 'Living country không được trống.',
    'living_country_code_max' => 'Living country sai định dạng.',
    'living_country_code_min' => 'Living country sai định dạng.',
    'living_city_id_required' => 'Living city không được trống.',
    'current_password_required' => 'Current password không được trống.',
    'current_password_min' => 'Current password must be at least :min.',
    'current_password_old_password' => 'Current password is not correct.',
    'email_unique' => 'Email này đã được sử dụng.',
    'email_different' => 'The email and old email must be different',
    'password_confirmed' => 'The password confirmation does not match.',
    'skype_id_required' => 'Skype id không được trống.',
    'content_required' => 'The content không được trống.',
    'rating_required' => 'The rating không được trống.',
    'rating_in' => 'The rating sai định dạng',

];
