<?php

use yii\db\Migration;

/**
 * Handles the creation for table `providers`.
 */
class m160808_045000_create_providers_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $table = 'providers';
        $this->createTable($table, [
            'id' => $this->primaryKey(),
            'name'=>$this->string(36)->notNull(),
        ]);
        $this->insert($table,[
            'name'=>'email',
        ]);
        $this->insert($table,[
            'name'=>'browser',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('providers');
    }
}
