<?php

namespace app\controllers;

use yii\rest\ActiveController;


class NoticiasController extends ActiveController
{
    public $modelClass = "\app\models\Noticias";

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'dados',
        'linksEnvelope' => 'links',
        'metaEnvelope' => 'meta'
    ];

}
