<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 09.08.2016
 * Time: 14:01
 */
?>
<div class="alert <?= $model->readed_at ? 'alert-success' : 'alert-warning' ?>" data-message-id="<?= $model->id ?>">
    <h2><?= \yii\helpers\Html::encode($model->title) ?></h2>

    <?= $model->txt ?>
    <br>
    <?php if(!$model->readed_at): ?>
        <?= \yii\helpers\Html::a('Прочитано','javascript:void()',['class' => 'btn btn-danger btn-readed',]) ?>
    <?php endif; ?>
</div>
