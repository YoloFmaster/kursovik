<?php

namespace app\controllers;

use app\models\Ordering;
use Yii;
use app\controllers\FunctionController;
use app\models\Dish;
use app\models\ShoppingCart;
use yii\filters\auth\HttpBearerAuth;

class CartController extends FunctionController
{
    public $modelClass = 'app\models\User';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
            'only' => ['update', 'order']
        ];
        return $behaviors;
    }

    public function actionUpdate($id)
    {

        $dish = Dish::find()->where(['id_cart' => $id]);
        if (is_null($dish))
            return $this->notFound();

        $count = Yii::$app->request->getBodyParam('count');
        $user = Yii::$app->user->identity;

        $editCart = ShoppingCart::find()->where(['user_id' => $user->id])->andWhere(['id_cart' => $id])->one();
        $editCart->count = $count;
        if (!$editCart->validate())
            return $this->validation($editCart);
        $editCart->save();

        $deleteCart = ShoppingCart::find()
            ->where(['user_id' => $user->id])
            ->andwhere(['count' => 0])
            ->one();

        if ($deleteCart) {
            $deleteCart->delete();
            return $this->send(200, ['message' => 'Товар успешно удалён']);
        }
        return $this->send(200, ['message' => 'Количество товара изменено']);
    }

    public function actionOrder()
    {
        $user = Yii::$app->user->identity;
        $shoppingCart = ShoppingCart::find()->where(['user_id' => $user->id])->all();
        $date = date("Y-m-d H:i:s");
        $address = Yii::$app->request->getBodyParam('address');

        if (is_null($shoppingCart))
            return $this->send(404, ['message' => 'Корзина пуста']);
        
        foreach ($shoppingCart as $cart) {
            $order = new Ordering();

            $order->user_id = $user->id;
            $order->dish_id = $cart->dish_id;
            $order->count = $cart->count;
            $order->address = $address;
            $order->date_making_ordering = $date;

            if (!$order->validate())
                return $this->validation($order);
            $order->save();

            $cart->delete();
        }
        return $this->send(200, ['message' =>'Заказ успешно оформлен']);
    }
}
