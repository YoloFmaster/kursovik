<?php

namespace app\controllers;

use app\models\LoginForm;
use app\models\Ordering;
use app\models\User;
use Yii;
use app\controllers\FunctionController;
use app\models\Dish;
use app\models\ShoppingCart;
use yii\filters\auth\HttpBearerAuth;

class UserController extends FunctionController
{
    public $modelClass = 'app\models\User';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
            'only' => ['edit', 'add', 'view-shopping-cart', 'update', 'view-ordering']
        ];
        return $behaviors;
    }


    public function actionCreate()
    {
        $data = Yii::$app->request->post();
        $user = new User();
        $user->load($data, '');
        if (!$user->validate())
            return $this->validation($user);
        $token = Yii::$app->getSecurity()->generateRandomString();
        $user->token = $token;
        $user->password = Yii::$app->getSecurity()->generatePasswordHash($user->password);
        ;
        $user->save();

        return $this->successRegistration($token);
    }

    public function actionLogin()
    {
        $data = Yii::$app->request->post();
        $login_data = new LoginForm();
        $login_data->load($data, '');
        if (!$login_data->validate())
            return $this->validation($login_data);
        $user = User::find()->where(['email' => $login_data->email])->one();
        if (!is_null($user)) {
            if (Yii::$app->getSecurity()->validatePassword($login_data->password, $user->password)) {
                $token = Yii::$app->getSecurity()->generateRandomString();
                $user->token = $token;
                $user->save();
                $data = ['data' => ['token' => $token]];
                return $this->send(200, $data);
            }
        }
        return $this->send(401, [
            'error' => [
                'code' => 401,
                'message' => 'Unauthorized',
                'errors' => [
                    'incorrectEmailOrLogin' => 'Неверная почта телефона или пароль'
                ]
            ]
        ]);
    }

    public function actionCatalog()
    {
        $catalog = Dish::find()->all();
        if (!is_null($catalog)) {
            $data = ['data' => ['food' => $catalog]];
            return $this->send(200, $data);
        } else {
            return $this->validation($catalog);
        }
    }

    public function actionEdit()
    {
        $data = Yii::$app->request->getBodyParams();

        $user = Yii::$app->user->identity;
        $user->load($data, '');
        if (!$user->validate())
            return $this->validation($user);
        $user->save();
        return $this->send(200, null);
    }

    public function actionAdd()
    {
        $data = Yii::$app->request->post();
        $user = Yii::$app->user->identity;
        if (!is_null($user)) {

            $shoppingCart = new ShoppingCart();
            $shoppingCart->user_id = $user->id;
            $shoppingCart->load($data, '');

            $dish = Dish::findOne($shoppingCart->dish_id);
            if (is_null($dish))
                return $this->notFound();

            $shoppingCart->save();
            return $this->send(200, null);
        }
    }

    public function actionViewShoppingCart()
    {
        $user = Yii::$app->user->identity;
        if (!is_null($user)) {
            $dishes = (new \yii\db\Query())
                ->select("id_cart,user_id,dish_id,foodImage,name,count,price")
                ->from("ShoppingCart")
                ->innerJoin(["d" => "Dish"], "d.id_dish = ShoppingCart.dish_id")
                ->where(['user_id' => $user->id])
                ->all();
            return $this->send(200, ['data' => ['food' => $dishes]]);
        }
    }

    public function actionViewOrdering()
    {
        $user = Yii::$app->user->identity;

        if ($user->isAdmin()) {
            $orders = Ordering::find()->all();
            return $this->send(200, ['data' => ['orders' => $orders]]);
        }
        return $this->send(403, ['error' => ['code' => 403, 'messsage' => 'Access denied']]);
    }
}
