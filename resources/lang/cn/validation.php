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

    'accepted'             => ':attribute 必须确认.',
    'active_url'           => ':attribute is not a valid URL.',
    'after'                => ':attribute must be a date after :date.',
    'alpha'                => ':attribute may only contain letters.',
    'alpha_dash'           => ':attribute may only contain letters, numbers, and dashes.',
    'alpha_num'            => ':attribute may only contain letters and numbers.',
    'array'                => ':attribute 必须是个数组.',
    'before'               => ':attribute must be a date before :date.',
    'between'              => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file'    => 'The :attribute must be between :min and :max kilobytes.',
        'string'  => 'The :attribute must be between :min and :max characters.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => ':attribute 只能是true或者false.',
    'confirmed'            => ':attribute 确认的字段不匹配.',
    'date'                 => ':attribute 不是正确的时间格式.',
    'date_format'          => ':attribute 与指定的格式不匹配， :format.',
    'different'            => ':attribute 和 :other 必须不一样.',
    'digits'               => ':attribute must be :digits digits.',
    'digits_between'       => ':attribute must be between :min and :max digits.',
    'email'                => ':attribute 必须是个正确的邮箱地址.',
    'filled'               => ':attribute field is required.',
    'exists'               => 'The selected :attribute is invalid.',
    'image'                => 'The :attribute must be an image.',
    'in'                   => 'The selected :attribute is invalid.',
    'integer'              => 'The :attribute 必须是整数.',
    'ip'                   => 'The :attribute 必须是个正确的IP地址.',
    'max'                  => [
        'numeric' => ':attribute 不能大于 :max.',
        'file'    => ':attribute may not be greater than :max kilobytes.',
        'string'  => ':attribute 不能超过 :max 个字符.',
        'array'   => ':attribute may not have more than :max items.',
    ],
    'mimes'                => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => ':attribute 不能小于 :min.',
        'file'    => ':attribute must be at least :min kilobytes.',
        'string'  => ':attribute 不能少于 :min 个字符.',
        'array'   => ':attribute must have at least :min items.',
    ],
    'not_in'               => 'The selected :attribute is invalid.',
    'numeric'              => ':attribute 必须是个数字.',
    'regex'                => ':attribute 格式不正确.',
    'required'             => ':attribute 必填.',
    'required_if'          => '当 :other 是 :value 的时候，:attribute 必填.',
    'required_with'        => ':attribute field is required when :values is present.',
    'required_with_all'    => ':attribute field is required when :values is present.',
    'required_without'     => ':attribute field is required when :values is not present.',
    'required_without_all' => ':attribute field is required when none of :values are present.',
    'same'                 => ':attribute 和 :other 必须一致.',
    'size'                 => [
        'numeric' => 'The :attribute must be :size.',
        'file'    => 'The :attribute must be :size kilobytes.',
        'string'  => 'The :attribute must be :size characters.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'timezone'             => ':attribute must be a valid zone.',
    'unique'               => ':attribute 已经存在.',
    'url'                  => ':attribute 格式无效.',
    'captcha'              => ':attribute 不正确',

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
/*        'username'  => [
            'required'  => '请填写用户名.',
            'unique'    => '用户名已经存在.',
            'min'   => '用户名 不能少于 :min 个字符.',
            'max'   => '用户名 不能多于 :max 个字符.',
        ],*/
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
        'username'  => '用户名',
        'truename'  => '真实姓名',
        'password'  => '密码',
        'email'     => '邮箱',
        'title'     => '标题',
        'content'   => '内容',
        'catid'     => '分类',
        'name'      => '名称',
        'route'     => '路由',
        'ico'       => '图标',
        'captcha'   => '验证码'
    ],

];
