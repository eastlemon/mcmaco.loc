<?php

namespace shop\forms\manage\Shop;

use Yii;
use elisdn\compositeForm\CompositeForm;
use shop\entities\Shop\Brand;
use shop\forms\manage\MetaForm;
use shop\validators\SlugValidator;

class BrandForm extends CompositeForm
{
    public $name;
    public $slug;

    private $_brand;

    public function __construct(Brand $brand = null, $config = [])
    {
        if ($brand) {
            $this->name = $brand->name;
            $this->slug = $brand->slug;
            $this->meta = new MetaForm($brand->meta);
            $this->_brand = $brand;
        } else {
            $this->meta = new MetaForm();
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['name', 'slug'], 'required'],
            [['name', 'slug'], 'string', 'max' => 255],
            ['slug', SlugValidator::class],
            [['name', 'slug'], 'unique', 'targetClass' => Brand::class, 'filter' => $this->_brand ? ['<>', 'id', $this->_brand->id] : null]
        ];
    }

    public function internalForms(): array
    {
        return ['meta'];
    }

    public function attributeLabels(): array
    {
        return [
            'name' => Yii::t('shop', 'Name'),
            'slug' => Yii::t('shop', 'Slug'),
        ];
    }
}