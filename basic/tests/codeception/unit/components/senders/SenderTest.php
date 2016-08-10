<?php

namespace tests\codeception\unit\components\senders;

use app\components\senders\BrowserSender;
use app\components\senders\EmailSender;
use app\components\senders\Sender;
use yii\codeception\TestCase;
use Codeception\Specify;


class SenderTest extends TestCase
{
    use Specify;
    public function testFindIdentity(){
        $this->specify('Проверка работы фабричной функции', function(){
            $sender = Sender::getForProvider('email');
            expect('Класс должен быть app\components\senders\EmailSender', $sender)
                ->isInstanceOf(EmailSender::class);
            $sender = Sender::getForProvider('browser');
            expect('Класс должен быть app\components\senders\BrowserSender', $sender)
                ->isInstanceOf(BrowserSender::class);
        });
    }

}
