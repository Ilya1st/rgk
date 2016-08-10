<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "notifications".
 *
 * @property integer $id
 * @property integer $event_id
 * @property integer $from_user_id
 * @property string $to
 * @property string $message
 * @property string $title
 * @property string $toType
 * @property array $selectedProviders
 *
 * @property Event $event
 * @property User $fromUser
 * @property Provider[] $providers
 */
class Notification extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notifications';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['event_id', 'from_user_id', 'message', 'title'], 'required'],
            [['event_id', 'from_user_id'], 'integer'],
            [['message'], 'string'],
            [['to', 'title'], 'string', 'max' => 256],
            [['toType'],'string'],
            [['toType'],'in','range'=>['all','user','field']],
            [['selectedProviders'],'required'],
            [['event_id'], 'exist', 'skipOnError' => true, 'targetClass' => Event::className(), 'targetAttribute' => ['event_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'event_id' => 'Событие',
            'from_user_id' => 'Отправитель',
            'to' => 'Адресат',
            'message' => 'Сообщение',
            'title' => 'Заголовок',
            'toType' => 'Адресат',
            'selectedProviders' => 'Провайдеры'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvent()
    {
        return $this->hasOne(Event::className(), ['id' => 'event_id']);
    }
    public function getFromUser()
    {
        return $this->hasOne(User::className(), ['id' => 'from_user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProviders()
    {
        return $this->hasMany(Provider::className(), ['id' => 'provider_id'])->viaTable('notifications_providers', ['notification_id' => 'id']);
    }

    private $_toType;

    /**
     * @return mixed
     */
    public function getToType()
    {
        if(!$this->_toType){
            if(!$this->to) $this->setToType('all');
            elseif(preg_match('/\D+/',$this->to)) $this->setToType('field');
            else $this->setToType('user');
        }

        return $this->_toType;
    }

    /**
     * @param mixed $toType
     */
    public function setToType($toType)
    {
        $this->_toType = $toType;
    }

    private $_selectedProviders=[];
    public function getSelectedProviders(){
        if(!$this->_selectedProviders)
            $this->setSelectedProviders(array_map(function($item){
                return $item->id;
            },$this->getProviders()->all()));
        return $this->_selectedProviders;
    }
    public function setSelectedProviders($value){
        $this->_selectedProviders=$value;
    }

    public function getToListArray(){
        $type = $this->getToType();
        $result = [];
        switch($type){
            case 'user':
                $result=ArrayHelper::map(User::find()->all(),'id','name');
                break;
            case 'field':
                $model=Event::find()->where(['id'=>$this->event_id])->one()->model;
                $obj = new $model;
                $keys = array_keys($obj->attributeLabels());
                foreach($keys as $key){
                    $result[$key]=$key;
                }
                break;
        }
        return $result;
    }

    public function getToText(){
        if(!$this->to) return 'Все пользователи';
        return preg_match('/\D+/',$this->to)
            ? 'Определяется значением поля "'.$this->to . '" в модели.'
            : User::find()->where(['id'=>$this->to])->one()->name;
    }
    public function getProvidersText(){
        $names=array_map(function($item){
            return $item->name;
        },$this->getProviders()->all());
        return join(', ',$names);
    }
}
