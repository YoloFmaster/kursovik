<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "Dish".
 *
 * @property int $id_dish
 * @property string $foodImage
 * @property string $name
 * @property int $category_id
 * @property string $mainProduct
 * @property int $price
 *
 * @property Category $category
 * @property ShoppingCart[] $shoppingCarts
 */
class Dish extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Dish';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'category_id', 'mainProduct', 'price'], 'required'],
            [['category_id', 'price'], 'integer'],
            [['mainProduct'], 'string'],
            ['foodImage', 'file', 'skipOnEmpty' => false, 'extensions' => ['png', 'jpg', 'gif'],'maxSize' => 1024*1024],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id_category']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_dish' => 'Id Dish',
            'foodImage' => 'Food Image',
            'name' => 'Name',
            'category_id' => 'Category ID',
            'mainProduct' => 'Main Product',
            'price' => 'Price',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id_category' => 'category_id']);
    }

    public function beforeValidate()
    {
        $this->foodImage = UploadedFile::getInstanceByName('foodImage');
        return parent::beforeValidate();
    }

    /**
     * Gets query for [[ShoppingCarts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getShoppingCarts()
    {
        return $this->hasMany(ShoppingCart::class, ['dish_id' => 'id_dish']);
    }
}
