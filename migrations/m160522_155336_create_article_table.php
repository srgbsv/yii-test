<?php

use yii\db\Migration;

/**
 * Handles the creation for table `article_table`.
 */
class m160522_155336_create_article_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('article', [
            'id' => $this->primaryKey(),
            'author' => $this->integer()->notNull(),
            'title' => $this->string(255),
            'content' => $this->text()
        ]);

        $this->createIndex('author', 'article', 'author');
        $this->addForeignKey('fk_article_1', 'article', 'author', 'user', 'id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('article_table');
    }
}
