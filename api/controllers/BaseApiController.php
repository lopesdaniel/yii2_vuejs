<?php

namespace app\controllers;

use Firebase\JWT\JWT;
use yii\base\Module;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;


class BaseApiController extends ActiveController
{

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'dados',
        'linksEnvelope' => 'links',
        'metaEnvelope' => 'meta'
    ];

    public function __construct($id, Module $module, array $config = [])
    {
        parent::__construct($id, $module, $config);

        $token = [
            'exp' => time() + (60 * 60 * 10),
            'dados' => [
                'nome' => "Daniel Lopes",
                'cidade' => "Fortaleza"
            ]
        ];

        $jwt = JWT::encode($token, \Yii::$app->params['token_key']);


    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className()
        ];

        $auth = $behaviors['authenticator'];
        unset($behaviors['authenticator']);

        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className()
        ];

        $behaviors['authenticator'] = $auth;
        $behaviors['authenticator']['except'] = ['options'];

        
        return $behaviors;
    }

}