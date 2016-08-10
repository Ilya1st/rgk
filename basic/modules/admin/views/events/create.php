<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Event */
/* @var $baseEvents array */
/* @var $models array */

$this->title = 'Создать событие';
$this->params['breadcrumbs'][] = ['label' => 'Админка', 'url' => ['/admin']];
$this->params['breadcrumbs'][] = ['label' => 'События', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'models'=>$models,
        'baseEvents'=>$baseEvents,
    ]) ?>

</div>
