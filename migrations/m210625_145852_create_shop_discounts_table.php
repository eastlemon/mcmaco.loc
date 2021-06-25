<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shop_discounts}}`.
 */
class m210625_145852_create_shop_discounts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%shop_discounts}}', [
            'id' => $this->primaryKey(),
            'percent' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'from_date' => $this->date(),
            'to_date' => $this->date(),
            'active' => $this->boolean()->notNull(),
            'sort' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%shop_discounts}}');
    }
}
