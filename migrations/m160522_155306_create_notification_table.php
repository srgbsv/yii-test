<?php

use yii\db\Migration;

/**
 * Handles the creation for table `notification_table`.
 */
class m160522_155306_create_notification_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('notification', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'title' => $this->string(100),
            'content' => $this->text(),
            'date' => $this->integer()->notNull(),
            'status' => $this->integer()->notNull()
        ]);

        $this->createIndex('user_id', 'notification', 'user_id');
        $this->addForeignKey('fk_notification_1', 'notification', 'user_id', 'user', 'id', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('notification_table');
    }
}
