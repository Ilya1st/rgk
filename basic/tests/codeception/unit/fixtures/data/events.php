<?php
return [
    'user_registered' => [
        'id' => 1,
        'name'=>'user_registered',
        'model' => 'app\models\User',
        'base_event' => 'insert',
    ],
    'user_unactivated' => [
        'id' => 2,
        'name'=>'user_unactivated',
        'model' => 'app\models\User',
        'base_event' => 'update',
        'expression'=>'!is_active',
    ],
    'user_deleted' => [
        'id' => 3,
        'name'=>'user_deleted',
        'model' => 'app\models\User',
        'base_event' => 'delete',
    ],
    'article_created' => [
        'id' => 4,
        'name'=>'article_created',
        'model' => 'app\models\Article',
        'base_event' => 'insert',
    ],
];