<?php


namespace app\controllers;


use app\models\LoginForm;
use Firebase\JWT\JWT;
use Yii;
use yii\web\Controller;

class UsuariosController extends Controller
{

    /**
     *  É apenas para fazer o login e devolver o token.
     */
    public function actionLogin()
    {
        Yii::$app->response->format = Yii::$app->response::FORMAT_JSON;

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            $user = $model->getUser();

            $token = [
                'exp' => time() + (60 * 60 * 10),
                'dados' => [
                    'nome' => $user->nome,
                    'email' => $user->email,
                    'access_token' => $user->access_token,
                ]
            ];

            $jwt = JWT::encode($token, \Yii::$app->params['token_key']);

            return  [
                '_token' => $jwt,
            ];

        } else {
            Yii::$app->response->statusCode = 401;
            return [
                'error' => "Credenciais Inválidas !"
            ];
        }

    }

}