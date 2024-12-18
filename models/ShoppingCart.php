<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ShoppingCart".
 *
 * @property int $id_cart
 * @property int $user_id
 * @property int $dish_id
 * @property int $count
 *
 * @property Dish $dish
 * @property User $user
 */
class ShoppingCart extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ShoppingCart';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'dish_id', 'count'], 'required'],
            [['user_id', 'dish_id', 'count'], 'integer'],
            [['count'], 'compare', 'compareValue' => 0, 'operator' => '>=', 'type' => 'number'],
            [['dish_id'], 'exist', 'skipOnError' => true, 'targetClass' => Dish::class, 'targetAttribute' => ['dish_id' => 'id_dish']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_cart' => 'Id Cart',
            'user_id' => 'User ID',
            'dish_id' => 'Dish ID',
            'count' => 'Count',
        ];
    }

    /**
     * Gets query for [[Dish]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDish()
    {
        return $this->hasOne(Dish::class, ['id_dish' => 'dish_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
