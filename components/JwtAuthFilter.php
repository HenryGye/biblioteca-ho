<?php

namespace app\components;

use Yii;
use yii\base\ActionFilter;
use app\components\JwtAuth;

/**
 * Class JwtAuthFilter
 * Filtro que verifica la presencia y validez de un token JWT antes de permitir el acceso a las acciones.
 */
class JwtAuthFilter extends ActionFilter {
    
    /**
     * Este método se invoca justo antes de ejecutar una acción.
     * Comprueba si hay un JWT token válido en los encabezados de la solicitud.
     *
     * @param \yii\base\Action $action La acción a ejecutar.
     * @return boolean Devuelve true/false Si la acción debe continuar ejecutándose.
     * @throws \yii\web\ForbiddenHttpException Devuelve una excepción de acceso denegado si el token es inválido o caducado
     */
    public function beforeAction($action)
    {
        $token = JwtAuth::getTokenFromHeader();
        if ($token === null) {
            // Acceso denegado
            Yii::$app->response->setStatusCode(401);
            throw new \yii\web\ForbiddenHttpException;
        }

        $decodedToken = JwtAuth::validateToken($token);
        if ($decodedToken === null) {
            // El token es inválido o ha caducado
            Yii::$app->response->setStatusCode(403);
            throw new \yii\web\ForbiddenHttpException('El token ha caducado');
        }

        return parent::beforeAction($action);
    }
}
