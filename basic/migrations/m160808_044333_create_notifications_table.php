<?php

use yii\db\Migration;

/**
 * Handles the creation for table `notifications`.
 */
class m160808_044333_create_notifications_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $table = 'notifications';
        $this->createTable($table, [
            'id' => $this->primaryKey(),
            'event_id' => $this->integer()->notNull(),
            'from_user_id' => $this->integer()->notNull(),
            'to'=> $this->string(256)->comment('Если задана строка, тогда это ссылка на свойство модели, если число - идентификатор пользователя, если пусто - значит всем пользователям'),
            'message'=>$this->text()->notNull(),
            'title'=>$this->string(256)->notNull()
        ]);
        $this->createIndex(
            'ix_event_id',
            $table,
            'event_id'
        );
        $this->addForeignKey(
            'fk_event_id',
            $table,
            'event_id',
            'events',
            'id',
            'CASCADE'
        );
        $this->createIndex(
            'ix_from_user_id',
            $table,
            'from_user_id'
        );
        $this->addForeignKey(
            'fk_from_user_id',
            $table,
            'from_user_id',
            'users',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $table = 'notifications';
        $this->dropForeignKey('fk_from_user_id',$table);
        $this->dropIndex('ix_from_user_id',$table);
        $this->dropForeignKey('fk_event_id',$table);
        $this->dropIndex('ix_event_id',$table);
        $this->dropTable($table);
    }
}
