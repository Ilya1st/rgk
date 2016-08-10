<?php

use yii\db\Migration;

/**
 * Handles the creation for table `articles`.
 */
class m160809_061743_create_articles_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $table = 'articles';
        $this->createTable($table, [
            'id' => $this->primaryKey(),
            'author_id'=>$this->integer()->notNull(),
            'created_at'=>$this->integer()->notNull(),
            'title'=>$this->string(256)->notNull(),
            'txt'=>$this->text()->notNull()
        ]);
        $this->createIndex(
            'ix_articles_author_id',
            $table,
            'author_id'
        );
        $this->addForeignKey(
            'fk_articles_author_id',
            $table,
            'author_id',
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
        $table = 'articles';
        $this->dropForeignKey('fk_articles_author_id',$table);
        $this->dropIndex('ix_articles_author_id',$table);
        $this->dropTable($table);
    }
}
