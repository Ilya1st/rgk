<?php
return [
    'user_registered_to_author' => [
        'id' => 1,
        'event_id'=>1,
        'from_user_id' => 1,
        'to' => 'id',
        'message'=>'{username}! {modelid} С уважением, {authorname}.',
        'title'=>'Добро пожаловать на {sitename}',
    ],
    'article_created_to_all' => [
        'id' => 2,
        'event_id'=>4,
        'from_user_id' => 1,
        'message'=>'Уважаемый {username}!
На сайте {sitename} появилась новая статья "{modeltitle}".

{modelshortText}

С уважением, {authorname}.',
        'title'=>'Новая статья на {sitename}',
    ],

];