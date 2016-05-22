<?php

use yii\db\Migration;

/**
 * Handles the creation for table `chunk_table`.
 */
class m160522_155326_create_chunk_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('chunk', [
            'name' => $this->string(45)->unique(),
            'value' => $this->text()
        ]);

        $this->createIndex('name', 'chunk', 'name', true);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('chunk_table');
    }
}
