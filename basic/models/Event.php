<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "events".
 *
 * @property integer $id
 * @property string $name
 * @property string $model
 * @property string $base_event
 * @property string $expression
 */
class Event extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'events';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'model', 'base_event'], 'required'],
            [['name', 'model', 'expression'], 'string', 'max' => 256],
            [['base_event'], 'in', 'range' => ['insert','update','delete']],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Событие',
            'model' => 'Модель',
            'base_event' => 'Базовое событие',
            'expression' => 'Выражение',
        ];
    }
}
