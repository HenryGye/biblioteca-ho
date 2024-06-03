<?php

namespace app\controllers;

use Yii;
use yii\rest\Controller;

/**
 * TokenController maneja la generación de JSON Web Tokens (JWT).
 */
class TokenController extends Controller {

    /**
     * Genera un JWT con una carga útil que contiene el tiempo de vencimiento.
     *
     * @return \yii\web\Response Respuesta JSON que contiene el token generado.
     */
    public function actionGenerateToken() {
        $payload = [
            'exp' => time() + Yii::$app->params['tokenTime'],
        ];
        
        $token = Yii::$app->jwtAuth->generateToken($payload);
        return $this->asJson(['token' => $token]);
    }
}
