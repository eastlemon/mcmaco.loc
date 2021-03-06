<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%blog_posts}}`.
 */
class m210525_081826_create_blog_posts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%blog_posts}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'title' => $this->string()->notNull(),
            'description' => $this->text(),
            'content' => 'MEDIUMTEXT',
            'photo' => $this->string(),
            'status' => $this->integer()->notNull(),
            'meta_json' => 'JSON NOT NULL',
            'comments_count' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-blog_posts-category_id}}', '{{%blog_posts}}', 'category_id');

        $this->addForeignKey('{{%fk-blog_posts-category_id}}', '{{%blog_posts}}', 'category_id', '{{%blog_categories}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-blog_posts-category_id}}', '{{%blog_posts}}');

        $this->dropIndex('{{%idx-blog_posts-category_id}}', '{{%blog_posts}}');

        $this->dropTable('{{%blog_posts}}');
    }
}
