<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 04.08.2016
 * Time: 16:34
 */

namespace app\components\senders;


class EmailSender extends Sender
{

    public function send($params)
    {
        $users = self::getToUsers($params);
        $model=$params['model'];
        $notification=$params['notification'];
        $author = self::getAuthor($notification->from_user_id);
        foreach($users as $user){
            $htmlBody = self::replaceTemplates($notification->message,$model,$author,$user);
            \Yii::$app->mailer->compose()
                ->setFrom($author->email)
                ->setTo($user->email)
                ->setSubject(self::replaceTemplates($notification->title,$model,$author,$user))
                ->setTextBody(preg_replace('/<[^>]+>/','',$htmlBody))
                ->setHtmlBody($htmlBody)
                ->send();
        }
    }
}