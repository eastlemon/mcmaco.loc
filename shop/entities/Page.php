<?php
namespace shop\entities;

use Yii;
use paulzi\nestedsets\NestedSetsBehavior;
use shop\entities\behaviors\MetaBehavior;
use yii\db\ActiveRecord;

class Page extends ActiveRecord
{
    public $meta;

    public static function create($title, $slug, $content, Meta $meta): self
    {
        $page = new static();
        $page->title = $title;
        $page->slug = $slug;
        $page->title = $title;
        $page->content = $content;
        $page->meta = $meta;
        return $page;
    }

    public function edit($title, $slug, $content, Meta $meta): void
    {
        $this->title = $title;
        $this->slug = $slug;
        $this->content = $content;
        $this->meta = $meta;
    }

    public function getSeoTitle(): string
    {
        return $this->meta->title ?: $this->title;
    }

    public static function tableName(): string
    {
        return '{{%pages}}';
    }

    public function behaviors(): array
    {
        return [
            MetaBehavior::className(),
            NestedSetsBehavior::className(),
        ];
    }

    public function transactions(): array
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('shop', 'ID'),
            'title' => Yii::t('shop', 'Title'),
            'slug' => Yii::t('shop', 'Slug'),
            'content' => Yii::t('shop', 'Content'),
            'meta_json' => Yii::t('shop', 'Meta Json'),
            'lft' => Yii::t('shop', 'Lft'),
            'rgt' => Yii::t('shop', 'Rgt'),
            'depth' => Yii::t('shop', 'Depth'),
        ];
    }
}