<?php

namespace tests\codeception\unit\components;

use app\components\Helper;
use app\components\MyActiveRecord;
use yii\codeception\TestCase;
use Codeception\Specify;


class HelperTest extends TestCase
{
    use Specify;
    public function testGetClassInheritance(){
        $result = Helper::getClassInheritance(MyActiveRecord::className());
        $this->specify('проверяем полученный результат', function() use ($result){
            expect('Результат не должен быть пустым', count($result)>0)->true();
            foreach($result as $r){
                expect('Элемент должен быть экземпляром требуемого класса',
                    is_subclass_of($r, MyActiveRecord::className()))->true();
            }
        });
    }

}
