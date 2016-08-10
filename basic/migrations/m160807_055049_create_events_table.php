<?php

use yii\db\Migration;

/**
 * Handles the creation for table `events`.
 */
class m160807_055049_create_events_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('events', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(256)->notNull()->unique()->comment('Название события'),
            'model'=>$this->string(256)->notNull()->comment('Полностью квалифицированное имя модели'),
            'base_event'=>$this->string(20)->notNull()->comment('Базовое событие, при котором будем возбуждать наше событие. Значения: insert, update, delete'),
            'expression'=>$this->string(256)->comment('Выражение. Если его значение возвращает ложь, событие не генериться. $model - ссылка но модель, сгенерировшую событие'),
        ]);

        //здесь можно было бы создать индекс по полям model, base_event, но не предполагается большое количество записей в этой таблице,
        //поэтому это не целесообразно
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('events');
    }
}
