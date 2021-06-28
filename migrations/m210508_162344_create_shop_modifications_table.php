<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shop_modifications}}`.
 */
class m210508_162344_create_shop_modifications_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%shop_modifications}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'code' => $this->string()->notNull(),
            'name' => $this->string()->notNull(),
            'price' => $this->integer(),
            'quantity' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-shop_modifications-code}}', '{{%shop_modifications}}', 'code');
        $this->createIndex('{{%idx-shop_modifications-product_id-code}}', '{{%shop_modifications}}', ['product_id', 'code'], true);
        $this->createIndex('{{%idx-shop_modifications-product_id}}', '{{%shop_modifications}}', 'product_id');

        $this->addForeignKey('{{%fk-shop_modifications-product_id}}', '{{%shop_modifications}}', 'product_id', '{{%shop_products}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-shop_modifications-product_id}}', '{{%shop_modifications}}');

        $this->dropIndex('{{%idx-shop_modifications-product_id}}', '{{%shop_modifications}}');
        $this->dropIndex('{{%idx-shop_modifications-product_id-code}}', '{{%shop_modifications}}');
        $this->dropIndex('{{%idx-shop_modifications-code}}', '{{%shop_modifications}}');

        $this->dropTable('{{%shop_modifications}}');
    }
}
