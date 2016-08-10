<?php

use yii\db\Migration;

/**
 * Handles the creation for table `notification_providers`.
 */
class m160808_046000_create_notifications_providers_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $table = 'notifications_providers';
        $this->createTable($table, [
            'notification_id'=>$this->integer()->notNull(),
            'provider_id' => $this->integer()->notNull(),
            'PRIMARY KEY(notification_id, provider_id)'
        ]);
        $this->addForeignKey(
            'fk_notification_id',
            $table,
            'notification_id',
            'notifications',
            'id',
            'CASCADE'
        );
        $this->createIndex(
            'ix_provider_id',
            $table,
            'provider_id'
        );
        $this->addForeignKey(
            'fk_provider_id',
            $table,
            'provider_id',
            'providers',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $table = 'notifications_providers';
        $this->dropForeignKey('fk_notification_id',$table);
        $this->dropForeignKey('fk_provider_id',$table);
        $this->dropIndex('ix_provider_id',$table);
        $this->dropTable($table);
    }
}
