<?php

namespace app\controllers;

use yii\rest\ActiveController;


class BaseApiController extends ActiveController
{

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'dados',
        'linksEnvelope' => 'links',
        'metaEnvelope' => 'meta'
    ];

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $auth = $behaviors['authenticatior'];
        unset($behaviors['authenticatior']);

        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className()
        ];

        $behaviors['authenticatior'] = $auth;
        $behaviors['authenticatior']['except'] = ['options'];

        
        return $behaviors;
    }

}