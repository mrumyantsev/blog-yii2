<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%comments}}`.
 */
class m251123_233459_create_comments_table extends Migration
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

        $this->createTable('{{%comments}}', [
            'id' => $this->primaryKey(),
            'text' => $this->string(),
            'user_id' => $this->integer(),
            'article_id' => $this->integer(),
            'status' => $this->integer(),
            'date' => $this->date(),
        ], $tableOptions);

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk_comments_user_id',
            '{{%comments}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );

        // add foreign key for table `article`
        $this->addForeignKey(
            'fk_comments_article_id',
            '{{%comments}}',
            'article_id',
            '{{%articles}}',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            'idx_comments_user_id',
            '{{%comments}}',
            'user_id'
        );

        // creates index for column `article_id`
        $this->createIndex(
            'idx_comments_article_id',
            '{{%comments}}',
            'article_id'
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('{{%comments}}');
    }
}
