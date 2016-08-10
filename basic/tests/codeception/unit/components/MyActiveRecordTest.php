<?php

namespace tests\codeception\unit\components;

use app\models\Event;
use app\models\User;
use app\tests\codeception\unit\fixtures\EventFixture;
use yii\codeception\TestCase;
use Codeception\Specify;


class MyActiveRecordTest extends TestCase
{
    use Specify;
    public function fixtures(){
        return [
            'events'=>EventFixture::className(),
        ];
    }

    public function testEventGeneration(){

        $events = Event::find()->all();
        $triggeredEvents = [];
        foreach($events as $e){
            \Yii::$app->on($e->name,function($event) use (&$triggeredEvents){
                array_push($triggeredEvents, $event->name);
            });
        }
        $user = new User();
        $this->specify('Проверка событий', function() use (&$triggeredEvents, $user){
            $user->name='test';
            $user->email='test@test.ru';
            $user->password='cbvcbv';
            $user->save();
            expect('Событие user_registered должно было произойти',
                in_array('user_registered',$triggeredEvents))->true();

            $user->is_active=false;
            $user->save();
            expect('Событие user_unactivated должно было произойти',
                in_array('user_unactivated',$triggeredEvents))->true();

            $user->delete();
            expect('Событие user_deleted должно было произойти',
                in_array('user_deleted',$triggeredEvents))->true();
        });

    }

}
