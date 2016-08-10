<?php

use yii\db\Migration;

/**
 * Handles the creation for table `browser_messages`.
 */
class m160809_034701_create_browser_messages_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $table = 'browser_messages';
        $this->createTable($table, [
            'id' => $this->primaryKey(),
            'title'=>$this->string(256)->notNull(),
            'txt'=>$this->text()->notNull(),
            'from_user_id'=>$this->integer()->notNull(),
            'to_user_id'=>$this->integer()->notNull(),
            'created_at'=>$this->integer()->notNull(),
            'readed_at'=>$this->integer()
        ]);
        $this->createIndex(
            'ix_browser_messages_from_user_id',
            $table,
            'from_user_id'
        );
        $this->addForeignKey(
            'fk_browser_messages_from_user_id',
            $table,
            'from_user_id',
            'users',
            'id',
            'CASCADE'
        );
        $this->createIndex(
            'ix_browser_messages_to_user_id',
            $table,
            'to_user_id'
        );
        $this->addForeignKey(
            'fk_browser_messages_to_user_id',
            $table,
            'to_user_id',
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
        $table = 'browser_messages';
        $this->dropForeignKey('fk_browser_messages_to_user_id',$table);
        $this->dropIndex('ix_browser_messages_to_user_id',$table);
        $this->dropForeignKey('fk_browser_messages_from_user_id',$table);
        $this->dropIndex('ix_browser_messages_from_user_id',$table);
        $this->dropTable($table);
    }
}
