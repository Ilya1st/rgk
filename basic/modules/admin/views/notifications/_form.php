<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Notification */
/* @var $form yii\widgets\ActiveForm */
\app\modules\admin\assets\NotificationFormAsset::register($this);
?>

<div class="notification-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'event_id')
        ->dropDownList(\yii\helpers\ArrayHelper::map(\app\models\Event::find()->all(),'id','name'),
            ['prompt'=>'--Выберите событие--']) ?>

    <?= $form->field($model, 'from_user_id')
        ->dropDownList(\yii\helpers\ArrayHelper::map(\app\models\User::find()->all(),'id','name'),
            ['prompt'=>'--Выберите отправителя--']) ?>

    <?= $form->field($model, 'toType')->dropDownList([
        'all'=>'Все пользователи',
        'user'=>'Конкретный пользователь',
        'field'=>'Определить по полю модели'
    ]) ?>

    <?= $form->field($model, 'to')->dropDownList($model->getToListArray(),['class'=>'form-control'])->label(false) ?>

    <div class="form-group">
        <div class="panel panel-default">
            <div class="panel-heading"><h3>Варианты шаблонов вставки для "Заголовка" и "Сообщения"<h3></h3></div>
            <div class="panel-body">
                <div>
                    <h4>Глобальные шаблоны</h4>
                    <p>{sitename}</p>
                </div>
                <div>
                    <h4>Шаблоны получателя</h4>
                    <p>
                        {userid}, {username}, {useremail}
                    </p>
                </div>
                <div>
                    <h4>Шаблоны отправителя (автор)</h4>
                    <p>
                        {authorid}, {authorname}, {authoremail}
                    </p>
                </div>
                <div id="modeltemplates" class="hidden">
                    <h4>Шаблоны события <span id="currentevent"></span></h4>
                    <p id="eventtemplates"></p>
                </div>
            </div>
        </div>
    </div>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'message')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'selectedProviders')
        ->checkboxList(\yii\helpers\ArrayHelper::map(\app\models\Provider::find()->all(),'id','name')); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
