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
    'exists' => 'The selected :attribute is invalid.',
    'filled' => 'The :attribute field is required.',
    'image' => 'The :attribute must be an image.',
    'in' => 'The selected :attribute is invalid.',
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
    'not_in' => 'The selected :attribute is invalid.',
    'numeric' => 'The :attribute must be a number.',
    'regex' => 'The :attribute format is invalid.',
    'required' => 'The :attribute field is required.',
    'required_if' => 'The :attribute field is required when :other is :value.',
    'required_unless' => 'The :attribute field is required unless :other is in :values.',
    'required_with' => 'The :attribute field is required when :values is present.',
    'required_with_all' => 'The :attribute field is required when :values is present.',
    'required_without' => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
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
    'url' => 'The :attribute format is invalid.',

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
    'email_required' => 'メールアドレスを入力してください',
    'email_email' => 'メールアドレスの形式が正しくありません。',
    'name_required' => 'ニックネームを入力してください',
    'password_required' => 'パスワードを入力してください',
    'password_confirmation_required' => '入力したパスワードと異なります',
    'password_min' => 'パスワードは6文字以上で作成してください。',
    'password_confirmation_min' => 'パスワードは6文字以上で作成してください。',
    'accept_terms_and_privacy_policy_required' => '利用規約とプライバシーポリシーを承諾する必要があります。',
    'year_of_birth_required' => '「生まれた年」は必須項目です。',
    'year_of_birth_date_format' => 'Year of birth must be a valid year format.',
    'gender_required' => '「性別」は必須項目です。',
    'gender_max' => 'Gender must be at least :max.',
    'gender_min' => 'Gender must be at least :min.',
    'living_country_code_required' => '「住んでいる国」は必須項目です。',
    'living_country_code_max' => '「住んでいる国」が正しくありません。.',
    'living_country_code_min' => '「住んでいる国」が正しくありません。',
    'living_city_id_required' => '「住んでいる都市」は必須項目です。',
    'current_password_required' => '「現在のパスワード」は必須項目です。',
    'current_password_min' => '「現在のパスワード」は:min 文字以上で設定してください。',
    'current_password_old_password' => '「現在のパスワード」が正しくありません。',
    'email_unique' => 'このメールアドレスは既に使用されています。',
    'email_different' => 'このメールアドレスは古いメールアドレスと異なります。',
    'password_confirmed' => 'パスワードが一致しません。',
    'skype_id_required' => 'SkypeID を入力してください。',
    'content_required' => ' 入力が必須です。',
    'rating_required' => '評価が必須です。',
    'rating_in' => '評価が無効になりました。',
];
