<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 07.08.2016
 * Time: 15:02
 */

namespace app\components;


use yii\base\Event;
use yii\base\Exception;
use yii\db\ActiveRecord;

abstract class MyActiveRecord extends ActiveRecord
{
    /**
     * Приводит выражение к требуемому виду для передачи в функцию eval
     * @param $expression - выражение
     * @return string - выражение с добавленными квантификаторами $this и ключевым словом return.
     */
    private static function addThis($expression){
        if(!$expression) return '';
        $exp = 'return ' . $expression . ';';
        $result='';
        $pattern = '/[a-zA-Z_]+/';
        $cnt=0;
        $cnt2=0;
        $previous=null;
        for($i=strlen($exp)-1;$i>-1;$i--){
            $char = $exp[$i];
            if(preg_match($pattern,$char)===0 && preg_match($pattern, $previous)===1 && ($cnt % 2 === 0) && ($cnt2 % 2 === 0))
                $result = $char . '$this->' . $result;
            else
                $result = $char . $result;

            if($char==="'") $cnt++;
            elseif($char==='"') $cnt2++;

            $previous=$char;
        }
        return $result;
    }

    /**
     * Определяет, были ли изменения в атрибутах, которые участвуют в варажении
     * @param $changedAttributes - измененные атрибуты
     * @param $expression - приведенное к требуемому виду методом addThis выражение
     * @return bool - истина, если изменения были, иначе ложь
     */
    private static function isChangedAttributes($changedAttributes, $expression){
        $pattern = '/this\-\>([a-zA-Z_]+)/';
        $matches = [];
        preg_match_all($pattern,$expression,$matches);
        $fields = $matches[1];
        if(!$fields) return false;
        foreach($fields as $f){
            if($changedAttributes[$f]) return true;
        }
        return false;
    }

    public function afterSave($insert, $changedAttributes)
    {
        $events = \app\models\Event::find()->where(['model'=>get_class($this),'base_event'=>$insert ? 'insert':'update'])->all();
        foreach($events as $event){
            $thisExpression = self::addThis($event->expression);
            if(!$event->expression
                || ($insert && eval($thisExpression))
                || (!$insert && self::isChangedAttributes($changedAttributes,$thisExpression) && eval($thisExpression))){
                $e = new Event();
                $e->sender=$this;
                \Yii::$app->trigger($event->name,$e);
            }
        }

        parent::afterSave($insert, $changedAttributes);
    }

    public function afterDelete()
    {
        $events = \app\models\Event::find()->where(['model'=>get_class($this),'base_event'=>'delete'])->all();
        foreach($events as $event){
            $e = new Event();
            $e->sender=$this;
            \Yii::$app->trigger($event->name,$e);
        }
        parent::afterDelete();
    }
}