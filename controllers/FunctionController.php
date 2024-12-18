<?php

namespace app\controllers;

use yii\rest\Controller;
use yii\widgets\ActiveForm;
use yii\web\Response;

class FunctionController extends Controller
{

    public function send($code, $data)
    {
        $response = $this->response;
        $response->format = Response::FORMAT_JSON;
        $response->data = $data;
        $response->statusCode = $code;
        return $response;
    }
    public function validation($model)
    {
        $error = ['error' => ['code' => 422, 'message' => 'Validation error', 'errors' => ActiveForm::validate($model)]];
        return $this->send(422, $error);
    }

    public function successRegistration($token)
    {
        $code = 201;
        $token = ['data' => ['token' => $token]];

        return $this->send($code,$token);
    }

    public function notFound(){
        return $this->send(404, ['error' => ['code' => 404, 'message' => 'Not found', 'description' => 'Блюдо не найдено']]);
    }
}
