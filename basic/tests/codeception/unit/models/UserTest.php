<?php

namespace tests\codeception\unit\models;

use app\models\User;
use app\tests\codeception\unit\fixtures\UserFixture;
use yii\codeception\TestCase;
use Codeception\Specify;


class UserTest extends TestCase
{
    use Specify;
    protected function setUp()
    {
        parent::setUp();
        // uncomment the following to load fixtures for user table
        //$this->loadFixtures(['user']);
    }

    public function fixtures(){
        return [
            'users'=>UserFixture::className(),
        ];
    }

    public function testFindIdentity(){
        $user = User::findIdentity(1);
        $this->specify('Получин конктреный пользователь', function() use ($user){
            expect('Класс объект app\models\User', $user)->isInstanceOf(User::class);
            expect('Идентификатор должен быть равен 1', $user->id)->equals(1);
        });
    }

    public function testGetId(){
        $user = User::find()->where(['id'=>1])->one();
        $this->specify('Метод возвращает идентификатор пользователя', function() use ($user){
            expect('Идентификатор пользователя равен 1', $user->getId())->equals(1);
        });
    }

    public function testGetAuthKey(){
        $user = User::find()->where(['id'=>1])->one();
        $this->specify('Метод возвращает корректный ключ аутентификации', function() use ($user){
            expect('Ключ аутентификации соответстует ожидаемому', $user->getAuthKey())
                ->equals('17cd89b5e3e4df78e150241001dbbddd1bb693ee');
        });
    }
    public function testValidateAuthKey(){
        $user = User::find()->where(['id'=>1])->one();
        $this->specify('Метод проверяет корректность ключа валидации', function() use ($user){
            expect('Верный ключ аутентификации', $user->validateAuthKey('17cd89b5e3e4df78e150241001dbbddd1bb693ee'))
                ->true();
            expect('Не верный ключ аутентификации', $user->validateAuthKey('17cd80b5e3e4df78e150241001dbbddd1bb693ee'))
                ->false();
        });
    }

    public function testValidatePassword(){
        $user = User::find()->where(['id'=>1])->one();
        $this->specify('Метод проверяет правильность пароля', function() use ($user){
            expect('Пароль верный', $user->validatePassword('123456'))
                ->true();
            expect('Пароль не верный', $user->validatePassword('симсим'))
                ->false();
        });
    }

    public function testFindByEmail(){
        $email = 'tulov.alex@gmail.com';
        $user = User::findByEmail($email);
        $this->specify('Получен конктреный пользователь', function() use ($user,$email){
            expect('Класс объект app\models\User', $user)->isInstanceOf(User::class);
            expect('Емайл должен соответствовать искомому', $user->email)->equals($email);
        });
    }

    public function testPassword(){
        $user = new User();
        $this->specify('Проверка правильности работы свойства', function() use ($user){
            expect('После инициализации пароль не задан', $user->password)
                ->null();
            expect('После инициализации хэш пароля пуст', $user->hash_password)
                ->null();
            $user->password='cbvcbv';
            expect('После смены пароля меняется и хэш пароля', $user->hash_password)
                ->notNull();
        });
    }


}
