<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%blog_tags}}`.
 */
class m210609_145953_create_blog_tags_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%blog_tags}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-blog_tags-slug}}', '{{%blog_tags}}', 'slug', true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('{{%idx-blog_tags-slug}}', '{{%blog_tags}}');

        $this->dropTable('{{%blog_tags}}');
    }
}
