<?php

return [
    'status' => [
        'OK' => '200',
        'ERROR' => [
            'NO_CONTENT' => 204,
            'BAD_REQUEST' => 400,
            'NOT_FOUND' => 404,
            'OTHER' => 500,
            'LOGGING_FAIL' => 203
        ]
    ],
    'message' => [
        'OK' => 'SUCCESS',
        'ERROR' => [
            'NO_CONTENT' => 'Don\'t have data.',
            'BAD_REQUEST' => 'Bad Request! Please check request params.',
            'NOT_FOUND' => 'Page Not Found!',
            'OTHER' => 'Server error! Please resend the request',
            'LOGGING_FAIL' => 'Login failed. The user or password incorrect!'
        ]
    ]
];
