<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 04.08.2016
 * Time: 16:34
 */

namespace app\components\senders;


use app\models\BrowserMessage;

class BrowserSender extends Sender
{

    /**
     * Отправляет браузерное сообщение
     * @param $params - массив, с ключами model и notification
     */
    public function send($params)
    {
        $users = self::getToUsers($params);
        $model=$params['model'];
        $notification=$params['notification'];
        $author = self::getAuthor($notification->from_user_id);
        foreach($users as $user){
            $message = new BrowserMessage();
            $message->title=self::replaceTemplates($notification->title,$model,$author,$user);
            $message->txt=self::replaceTemplates($notification->message,$model,$author,$user);
            $message->from_user_id=$notification->from_user_id;
            $message->to_user_id=$user->id;
            $message->created_at=time();
            $message->save();
        }
    }
}