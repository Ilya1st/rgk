<?php

namespace tests\codeception\unit\components\senders;

use app\components\senders\Sender;
use app\models\BrowserMessage;
use app\models\Notification;
use app\models\User;
use app\tests\codeception\unit\fixtures\BrowserMessageFixture;
use app\tests\codeception\unit\fixtures\NotificationFixture;
use app\tests\codeception\unit\fixtures\NotificationProviderFixture;
use app\tests\codeception\unit\fixtures\UserFixture;
use yii\codeception\TestCase;
use Codeception\Specify;


class BrowserSenderTest extends TestCase
{
    use Specify;

    public function fixtures(){
        return [
            'users'=>UserFixture::className(),
            'notifications'=>NotificationFixture::className(),
            'notificationsProviders'=>NotificationProviderFixture::className(),
            'browserMessages'=>BrowserMessageFixture::className(),
        ];
    }

    public function testSend(){
        $sender = Sender::getForProvider('browser');
        $this->specify('Проверка отправки сообщения', function() use ($sender){
            expect('В таблице сообщений пусто', count(BrowserMessage::find()->all()))->equals(0);
            $user=User::find()->where(['id'=>3])->one();
            $notification = Notification::find()->where(['id'=>1])->one();
            $sender->send([
                'model'=>$user,
                'notification'=>$notification
            ]);
            $messages = BrowserMessage::find()->all();
            expect('В сообщениях должна быть одна запись', count($messages))->equals(1);
            $message=$messages[0];
            expect('Проверка заголовка сообщения', $message->title)
                ->equals('Добро пожаловать на ' . \Yii::$app->params['sitename']);
            $author = User::find()->where(['id'=>$notification->from_user_id])->one();
            expect('Проверка текста сообщения', $message->txt)
                ->equals($user->name . '! ' . $user->id . ' С уважением, '.$author->name.'.');
            expect('Проверка отправителя', $message->from_user_id)
                ->equals($notification->from_user_id);
            expect('Проверка адресата', $message->to_user_id)
                ->equals($user[$notification->to]);
            expect('Сообщение не должно быть прочитаным', $message->readed_at)
                ->null();
        });
    }

}
