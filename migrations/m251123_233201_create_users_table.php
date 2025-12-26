<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m251123_233201_create_users_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $tableOptions = null;
        
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'email' => $this->string()->defaultValue(null),
            'password' => $this->string(),
            'photo' => $this->string()->defaultValue(null),
            'is_admin' => $this->integer()->defaultValue(0),
        ], $tableOptions);

        $this->batchInsert('{{%users}}', [
            'id',
            'name',
            'email',
            'password',
            'is_admin',
        ], [
            [1, 'Admin', 'admin@blog-yii2.com', '1234', true],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('{{%users}}');
    }
}
