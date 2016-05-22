<?php

use yii\db\Migration;

/**
 * Handles the creation for table `event_handler`.
 */
class m160522_155252_create_event_handler_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('event_handler', [
            'id' => $this->primaryKey(),
            'title' => $this->string(100)->notNull(),
            'event_model' => $this->string(30)->notNull(),
            'event_name' => $this->string(30)->notNull(),
            'recipient' => $this->string(45)->notNull(),
            'params' => $this->text()->notNull(),
            'template' => $this->text()->notNull()
        ]);

        $this->createIndex('event_model', 'event_handler', 'event_model');
        $this->createIndex('event_name', 'event_handler', 'event_name');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('event_handler_table');
    }
}
