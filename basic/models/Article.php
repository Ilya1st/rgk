<?php

namespace app\models;

use app\components\MyActiveRecord;
use Yii;
use yii\bootstrap\Html;
use yii\helpers\Url;

/**
 * This is the model class for table "articles".
 *
 * @property integer $id
 * @property integer $author_id
 * @property integer $created_at
 * @property string $title
 * @property string $txt
 *
 * @property User $author
 */
class Article extends MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'articles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'txt'], 'required'],
            [['author_id', 'created_at'], 'integer'],
            [['txt'], 'string'],
            [['title'], 'string', 'max' => 256],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['author_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author_id' => 'Автор',
            'created_at' => 'Дата создания',
            'title' => 'Заголовок',
            'txt' => 'Текст',
            'shortText'=>'Короткий текст',
            'authorName'=>'Имя автора',
            'formattedCreatedAt'=>'Дата создания',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }

    public function getShortText(){

        return strlen($this->txt) > 256 ?
            substr($this->txt,0,256) . '...' .
               Html::a('читать далее', Url::to(['site/articles', 'id'=>$this->id],true))
            : $this->txt;
    }

    public function beforeSave($insert)
    {
        if($insert){
            $this->created_at=time();
            $this->author_id=Yii::$app->user->getId();
        }
        return parent::beforeSave($insert);
    }

    public function getAuthorName(){
        return $this->author->name;
    }

    public function getFormattedCreatedAt(){
        return date('d.m.Y H:i:s',$this->created_at);
    }
}
