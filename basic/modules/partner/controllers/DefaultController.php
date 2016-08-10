<?php

namespace app\modules\partner\controllers;

use app\models\BrowserMessage;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

/**
 * Default controller for the `partner` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => BrowserMessage::find()->where(['to_user_id'=>\Yii::$app->user->id]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $this->render('index',['dataProvider'=>$dataProvider]);
    }

    public function actionReaded($id){
        $m = BrowserMessage::find()->where(['id'=>$id])->one();
        if($m->to_user_id != \Yii::$app->user->id)
            throw new ForbiddenHttpException();
        $m->readed_at=time();
        $m->save();
    }
}
