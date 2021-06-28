<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shop_tag_assignments}}`.
 */
class m210508_144428_create_shop_tag_assignments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        
        $this->createTable('{{%shop_tag_assignments}}', [
            'product_id' => $this->integer()->notNull(),
            'tag_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('{{%pk-shop_tag_assignments}}', '{{%shop_tag_assignments}}', ['product_id', 'tag_id']);

        $this->createIndex('{{%idx-shop_tag_assignments-product_id}}', '{{%shop_tag_assignments}}', 'product_id');
        $this->createIndex('{{%idx-shop_tag_assignments-tag_id}}', '{{%shop_tag_assignments}}', 'tag_id');

        $this->addForeignKey('{{%fk-shop_tag_assignments-product_id}}', '{{%shop_tag_assignments}}', 'product_id', '{{%shop_products}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-shop_tag_assignments-tag_id}}', '{{%shop_tag_assignments}}', 'tag_id', '{{%shop_tags}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-shop_tag_assignments-tag_id}}', '{{%shop_tag_assignments}}');
        $this->dropForeignKey('{{%fk-shop_tag_assignments-product_id}}', '{{%shop_tag_assignments}}');

        $this->dropIndex('{{%idx-shop_tag_assignments-tag_id}}', '{{%shop_tag_assignments}}');
        $this->dropIndex('{{%idx-shop_tag_assignments-product_id}}', '{{%shop_tag_assignments}}');

        $this->dropTable('{{%shop_tag_assignments}}');
    }
}
