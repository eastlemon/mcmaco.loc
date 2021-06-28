<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shop_related_assignments}}`.
 */
class m210508_144457_create_shop_related_assignments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        
        $this->createTable('{{%shop_related_assignments}}', [
            'product_id' => $this->integer()->notNull(),
            'related_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('{{%pk-shop_related_assignments}}', '{{%shop_related_assignments}}', ['product_id', 'related_id']);

        $this->createIndex('{{%idx-shop_related_assignments-product_id}}', '{{%shop_related_assignments}}', 'product_id');
        $this->createIndex('{{%idx-shop_related_assignments-related_id}}', '{{%shop_related_assignments}}', 'related_id');

        $this->addForeignKey('{{%fk-shop_related_assignments-product_id}}', '{{%shop_related_assignments}}', 'product_id', '{{%shop_products}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-shop_related_assignments-related_id}}', '{{%shop_related_assignments}}', 'related_id', '{{%shop_products}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-shop_related_assignments-related_id}}', '{{%shop_related_assignments}}');
        $this->dropForeignKey('{{%fk-shop_related_assignments-product_id}}', '{{%shop_related_assignments}}');

        $this->dropIndex('{{%idx-shop_related_assignments-related_id}}', '{{%shop_related_assignments}}');
        $this->dropIndex('{{%idx-shop_related_assignments-product_id}}', '{{%shop_related_assignments}}');

        $this->dropTable('{{%shop_related_assignments}}');
    }
}
