<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shop_products}}`.
 */
class m210508_114006_create_shop_products_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%shop_products}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'brand_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'code' => $this->string()->notNull(),
            'name' => $this->string()->notNull(),
            'description' => $this->text(),
            'price_old' => $this->integer(),
            'price_new' => $this->integer(),
            'rating' => $this->decimal(3, 2),
            'meta_json' => $this->text(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'weight' => $this->integer()->notNull(),
            'quantity' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-shop_products-code}}', '{{%shop_products}}', 'code', true);
        $this->createIndex('{{%idx-shop_products-category_id}}', '{{%shop_products}}', 'category_id');
        $this->createIndex('{{%idx-shop_products-brand_id}}', '{{%shop_products}}', 'brand_id');

        $this->addForeignKey('{{%fk-shop_products-category_id}}', '{{%shop_products}}', 'category_id', '{{%shop_categories}}', 'id');
        $this->addForeignKey('{{%fk-shop_products-brand_id}}', '{{%shop_products}}', 'brand_id', '{{%shop_brands}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-shop_products-brand_id}}', '{{%shop_products}}');
        $this->dropForeignKey('{{%fk-shop_products-category_id}}', '{{%shop_products}}');

        $this->dropIndex('{{%idx-shop_products-brand_id}}', '{{%shop_products}}');
        $this->dropIndex('{{%idx-shop_products-category_id}}', '{{%shop_products}}');
        $this->dropIndex('{{%idx-shop_products-code}}', '{{%shop_products}}');

        $this->dropTable('{{%shop_products}}');
    }
}
