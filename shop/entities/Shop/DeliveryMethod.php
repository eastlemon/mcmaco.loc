<?php

namespace shop\entities\Shop;

use Yii;
use shop\entities\Shop\queries\DeliveryMethodQuery;
use yii\db\ActiveRecord;

class DeliveryMethod extends ActiveRecord
{
    public static function create($name, $cost, $minWeight, $maxWeight, $sort): self
    {
        $method = new static();
        $method->name = $name;
        $method->cost = $cost;
        $method->min_weight = $minWeight;
        $method->max_weight = $maxWeight;
        $method->sort = $sort;
        return $method;
    }

    public function edit($name, $cost, $minWeight, $maxWeight, $sort): void
    {
        $this->name = $name;
        $this->cost = $cost;
        $this->min_weight = $minWeight;
        $this->max_weight = $maxWeight;
        $this->sort = $sort;
    }

    public function isAvailableForWeight($weight): bool
    {
        return (!$this->min_weight || $this->min_weight <= $weight) && (!$this->max_weight || $weight <= $this->max_weight);
    }

    public static function tableName(): string
    {
        return '{{%shop_delivery_methods}}';
    }

    public static function find(): DeliveryMethodQuery
    {
        return new DeliveryMethodQuery(static::class);
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('shop', 'ID'),
            'name' => Yii::t('shop', 'Name'),
            'cost' => Yii::t('shop', 'Cost'),
            'min_weight' => Yii::t('shop', 'Min Weight'),
            'max_weight' => Yii::t('shop', 'Max Weight'),
            'sort' => Yii::t('shop', 'Sort'),
        ];
    }
}