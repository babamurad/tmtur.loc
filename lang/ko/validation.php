<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    */

    'accepted' => ':attribute 필드는 필수입니다.',
    'required' => ':attribute 필드는 필수입니다.',
    // Add other standard rules as needed

    'custom' => [
        'gdpr_consent' => [
            'accepted' => '개인정보 처리방침에 동의해야 합니다.',
        ],
    ],

    'attributes' => [
        'title' => '제목',
        // ...
    ],
];
