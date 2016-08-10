<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1><?= \yii\bootstrap\Html::encode($model->title) ?></h1>

    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-12">
                <?= $model->txt ?>
            </div>
         </div>

    </div>
</div>
