<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%articles_tags}}`.
 */
class m251123_233536_create_articles_tags_table extends Migration
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

        $this->createTable('{{%articles_tags}}', [
            'id' => $this->primaryKey(),
            'article_id' => $this->integer(),
            'tag_id' => $this->integer(),
        ], $tableOptions);

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk_articles_tags_article_id',
            '{{%articles_tags}}',
            'article_id',
            '{{%articles}}',
            'id',
            'CASCADE'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk_articles_tags_tag_id',
            '{{%articles_tags}}',
            'tag_id',
            '{{%tags}}',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            'idx_articles_tags_article_id',
            '{{%articles_tags}}',
            'article_id'
        );

        // creates index for column `user_id`
        $this->createIndex(
            'idx_articles_tags_tag_id',
            '{{%articles_tags}}',
            'tag_id'
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('{{%articles_tags}}');
    }
}
