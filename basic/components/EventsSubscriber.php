<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 09.08.2016
 * Time: 8:43
 */

namespace app\components;


use app\components\senders\Sender;
use app\models\Notification;
use yii\base\Component;

class EventsSubscriber extends Component
{
    public function init()
    {
        $notifications = Notification::find()->with('event')->all();
        foreach($notifications as $notification){
            \Yii::$app->on($notification->event->name,function($event){
                foreach($event->data->providers as $provider){
                    $sender = Sender::getForProvider($provider->name);
                    $sender->send(['notification'=>$event->data, 'model'=>$event->sender]);
                }
            },$notification);
        }
        parent::init();
    }
}