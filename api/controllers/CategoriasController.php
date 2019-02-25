<?php

namespace app\controllers;

use yii\rest\ActiveController;


class CategoriasController extends ActiveController
{
    public $modelClass = "\app\models\Categorias";

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'dados',
        'linksEnvelope' => 'links',
        'metaEnvelope' => 'meta'
    ];
