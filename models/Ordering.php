<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Ordering".
 *
 * @property int $id_ordering
 * @property int $user_id
 * @property int $dish_id
 * @property int $count
 * @property string $address
 * @property string $date_making_ordering
 *
 * @property User $user
 */
class Ordering extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Ordering';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'dish_id', 'count', 'address', 'date_making_ordering'], 'required'],
            [['user_id', 'dish_id', 'count'], 'integer'],
            [['address'], 'string'],
            [['date_making_ordering'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_ordering' => 'Id Ordering',
            'user_id' => 'User ID',
            'dish_id' => 'Dish ID',
            'count' => 'Count',
            'address' => 'Address',
            'date_making_ordering' => 'Date Making Ordering',
        ];
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
