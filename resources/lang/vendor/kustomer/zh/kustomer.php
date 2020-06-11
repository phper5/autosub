<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Tooltip Message
    |--------------------------------------------------------------------------
    |
    | Text that appears in the tooltip when the cursor hover the bubble, before
    | the popup opens.
    |
    */

    'tooltip' => '意见反馈',

    /*
    |--------------------------------------------------------------------------
    | Popup Title
    |--------------------------------------------------------------------------
    |
    | This is the text that will appear below the logo in the feedback popup
    |
    */

    'title' => '我们服务的完善离不开您的参与',

    /*
    |--------------------------------------------------------------------------
    | Success Message
    |--------------------------------------------------------------------------
    |
    | This message will be displayed if the feedback message is correctly sent.
    |
    */

    'success' => '感谢您的反馈',

    /*
    |--------------------------------------------------------------------------
    | Placeholder
    |--------------------------------------------------------------------------
    |
    | This text will appear as the placeholder of the textarea in which the
    | the user will type his feedback.
    |
    */

    'placeholder' => '请在此输入您的意见...',

    /*
    |--------------------------------------------------------------------------
    | Button Label
    |--------------------------------------------------------------------------
    |
    | Text of the confirmation button to send the feedback.
    |
    */

    'button' => '发送反馈',

    /*
    |--------------------------------------------------------------------------
    | Feedback Texts
    |--------------------------------------------------------------------------
    |
    | Must match the feedbacks array from the config file
    |
    */
    'feedbacks' => [
        'like' => [
            'title' => '我觉得很赞',
            'label' => '您喜欢的地方?',
        ],
        'dislike' => [
            'title' => '需要改进的地方',
            'label' => '很抱歉给您带来不便，要改进的是?',
        ],
        'suggestion' => [
            'title' => '我有个建议',
            'label' => '非常感谢您的提议，您的意见是？',
        ],
        // 'bug' => [
        //     'title' => 'I found a bug',
        //     'label' => 'Please explain what happened',
        // ],
    ],
];
