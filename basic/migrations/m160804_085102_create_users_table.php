<?php

use yii\db\Migration;

/**
 * Handles the creation for table `users`.
 */
class m160804_085102_create_users_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull(),
            'email' => $this->string(256)->notNull()->unique(),
            'hash_password' => $this->string(40)->notNull(),
            'is_active' => $this->boolean()->defaultValue(true),
        ]);
        $this->insert('users',[
            'id'=>1,
            'name'=>'Admin',
            'email'=>'tulov.alex@gmail.com',
            'hash_password'=>'9cb4fc9551b1315a96405fdf6f36b882c04af546',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('users');
    }
}
