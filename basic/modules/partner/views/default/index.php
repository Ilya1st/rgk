<?php

use yii\helpers\Html;
/* @var $dataProvider yii\data\ActiveDataProvider */
\app\modules\partner\assets\PartnerAsset::register($this);
$this->title = 'Партнерка';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="partner-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= \yii\widgets\ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_view',
    ]); ?>
</div>