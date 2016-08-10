<?php
namespace app\components\senders;
use app\models\User;
use yii\base\InvalidParamException;

/**
 * Created by PhpStorm.
 * User: lex
 * Date: 04.08.2016
 * Time: 16:31
 */
abstract class Sender
{
    public abstract function send($params);
    public static function getForProvider($type){
        switch($type){
            case 'email':
                return new EmailSender();
            case 'browser':
                return new BrowserSender();
        }
        throw new InvalidParamException('Invalid type: "' . $type . '"');
    }

    /**
     * Возвращает всех пользователей, которым нужно разослать сообщение
     * @param $params - массив, с ключами notification и model
     * @return array|\app\models\User[] - массив пользователей для отправки сообщения
     */
    protected static function getToUsers($params){
        $model = $params['model'];
        $notification=$params['notification'];
        $result=[];
        if(!$notification->to) {
            //все пользователи
            return User::find()->where(['is_active'=>1])->all();
        }
        elseif(preg_match('/\D+/',$notification->to)) {
            //определяем исходя из поля модели
            $user = User::find()->where(['id'=>$model[$notification->to]])->one();
            if($user) $result[]=$user;
        }
        else {
            //находим по переданному идентификатору пользователя
            $user = User::find()->where(['id'=>$notification->to])->one();
            if($user) $result[]=$user;
        }
        return $result;
    }

    /**
     * Возвращает автора сообщения
     * @param $fromUserId - идентификатор автора сообщения
     * @return null|\app\models\User - автор сообщения
     */
    protected static function getAuthor($fromUserId){
        return User::find()->where(['id'=>$fromUserId])->one();
    }

    /**
     * Определяет тип шаблона
     * @param $template - шаблон, без { }.
     * @return string - тип шаблона author, model, user или global
     */
    private static function getTemplateType($template){
        $str = substr($template,0,6);
        if($str==='author') return $str;
        $str = substr($str,0,5);
        if($str==='model') return $str;
        $str = substr($str,0,4);
        return $str==='user' ? $str : 'global';
    }

    /**
     * Заменяет шаблонные строки на конкретные значения
     * @param $str - входная строка с шаблонами замены
     * @param $model - модель,
     * @param $author - автор,
     * @param $user - адресат,
     * @return string- обработанная строка
     */
    protected static function replaceTemplates($str, $model, $author, $user){
        $templatePattern = '/{([^}]+)}/';
        $matches = [];
        preg_match_all($templatePattern,$str,$matches);
        $templates = array_unique($matches[1]);
        foreach($templates as $template){
            $type = self::getTemplateType($template);
            switch($type){
                case 'user':
                    $field=substr($template,4);
                    $str = str_replace('{'.$template.'}',$user[$field],$str);
                    break;
                case 'model':
                    $field=substr($template,5);
                    $str = str_replace('{'.$template.'}',$model[$field],$str);
                    break;
                case 'author':
                    $field=substr($template,6);
                    $str = str_replace('{'.$template.'}',$author[$field],$str);
                    break;
                default:
                    $field=null;
                    $str = str_replace('{'.$template.'}',\Yii::$app->params[$template],$str);
                    break;
            }
        }
        return $str;
    }
}