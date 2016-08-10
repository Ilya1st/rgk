<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 16.07.2015
 * Time: 11:16
 */

namespace app\tests\codeception\unit\fixtures;
use app\tests\codeception\fixtures\NotificationProviderFixture as fx;

class NotificationProviderFixture extends fx
{
    public $depends = ['app\tests\codeception\unit\fixtures\NotificationFixture'];
}