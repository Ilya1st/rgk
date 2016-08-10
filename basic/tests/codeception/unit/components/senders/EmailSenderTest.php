<?php

namespace tests\codeception\unit\components\senders;

use app\components\senders\Sender;
use app\models\Article;
use app\models\Notification;
use app\models\User;
use app\tests\codeception\unit\fixtures\NotificationFixture;
use app\tests\codeception\unit\fixtures\NotificationProviderFixture;
use app\tests\codeception\unit\fixtures\UserFixture;
use yii\codeception\TestCase;
use Codeception\Specify;


class EmailSenderTest extends TestCase
{
    use Specify;

    public function fixtures(){
        return [
            'users'=>UserFixture::className(),
            'notifications'=>NotificationFixture::className(),
            'notificationsProviders'=>NotificationProviderFixture::className(),
        ];
    }

    public function testSend(){
        $sender = Sender::getForProvider('email');
        $this->specify('Проверка корректности отправки сообщения', function() use ($sender){
            //очищаем выходную папку сообщений
            $emailPath = \Yii::$app->basePath . '\runtime\mail\*';
            array_map('unlink', glob($emailPath));

            $article = new Article();
            $article->author_id=1;
            $article->created_at=time();
            $article->title="test article";
            $article->txt='ljslj lj ls jl jls jljljj';
            $notification = Notification::find()->where(['id'=>2])->one();
            $sender->send([
                'model'=>$article,
                'notification'=>$notification
            ]);
            $activeUsers = User::find()->where(['is_active'=>1])->count();
            expect('В папке сообщений должно появиться столько сообщений, сколько активных пользователей',
                count(glob($emailPath)))->equals($activeUsers);
        });
    }

}
