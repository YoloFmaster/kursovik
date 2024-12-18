<?php

namespace app\controllers;


use Yii;
use app\controllers\FunctionController;
use app\models\Dish;
use yii\filters\auth\HttpBearerAuth;
use yii\web\UploadedFile;

class DishController extends FunctionController
{
    public $modelClass = 'app\models\User';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
            'only' => ['update', 'create']
        ];
        return $behaviors;
    }


    public function actionCreate()
    {
        $user = Yii::$app->user->identity;
        if(!$user->isAdmin())
            return $this->send(403, ['message' => 'Доступ запрещён']);
        $post_data = Yii::$app->request->post();
        $dish = new Dish();
        $dish->load($post_data, '');
        if (!$dish->validate())
            return $this->validation($dish);
        $dish->foodImage = UploadedFile::getInstanceByName('foodImage');
        $hash = hash('sha256', $dish->foodImage->baseName) . '.' . $dish->foodImage->extension;
        $dish->foodImage->saveAs(Yii::$app->basePath . '/api/imageDish/' . $hash);
        $dish->foodImage = $hash;
        $dish->save(false);
        return $this->send(204, null);
    }

    public function actionUpdate($id)
    {
        $user = Yii::$app->user->identity;
        if(!$user->isAdmin())
            return $this->send(403, ['message' => 'Доступ запрещён']);

        $post_data = Yii::$app->request->post();

        
        
        $dish = Dish::find()->where(['id_dish' => $id])->one();
        if(is_null($dish))
            return $this->notFound();
        $dish->load($post_data, '');
       
        if((UploadedFile::getInstanceByName('foodImage'))){
            $dish->foodImage = UploadedFile::getInstanceByName('foodImage');
            $hash = hash('sha256', $dish->foodImage->baseName) . '.' . $dish->foodImage->extension;
            $dish->foodImage->saveAs(Yii::$app->basePath . '/api/imageDish/' . $hash);
            $dish->foodImage = $hash;
        }

        $dish->save(false);
        return $this->send(204, null);
    }




}

