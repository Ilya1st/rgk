<?php

namespace tests\codeception\unit\components;

use app\components\EventsSubscriber;
use app\models\Notification;
use app\tests\codeception\unit\fixtures\NotificationFixture;
use yii\codeception\TestCase;
use Codeception\Specify;


class EventSubscriberTest extends TestCase
{
    use Specify;
    public function fixtures(){
        return [
            'notifications'=>NotificationFixture::className(),
        ];
    }

    public function testInit(){
        $subscriber = new EventsSubscriber();
        $this->specify('Проверяем, что подписка на события прошла успешно', function() use ($subscriber){
            $notifications = Notification::find()->with('event')->all();
            foreach($notifications as $notification){
                expect('Должна быть успешной отписка от событиев', \Yii::$app->off($notification->event->name))->true();
            }
        });
    }

}
