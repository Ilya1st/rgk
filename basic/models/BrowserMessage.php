<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "browser_messages".
 *
 * @property integer $id
 * @property string $title
 * @property string $txt
 * @property integer $from_user_id
 * @property integer $to_user_id
 * @property integer $created_at
 * @property integer $readed_at
 *
 * @property User $fromUser
 * @property User $toUser
 */
class BrowserMessage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'browser_messages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'txt', 'from_user_id', 'to_user_id', 'created_at'], 'required'],
            [['txt'], 'string'],
            [['from_user_id', 'to_user_id', 'created_at', 'readed_at'], 'integer'],
            [['title'], 'string', 'max' => 256],
            [['from_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['from_user_id' => 'id']],
            [['to_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['to_user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'txt' => 'Текст',
            'from_user_id' => 'Отправитель',
            'to_user_id' => 'Получатель',
            'created_at' => 'Отправлено',
            'readed_at' => 'Прочитано',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFromUser()
    {
        return $this->hasOne(User::className(), ['id' => 'from_user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getToUser()
    {
        return $this->hasOne(User::className(), ['id' => 'to_user_id']);
    }
}
