<?php

namespace app\components;

use Yii;
use yii\base\Component;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

/**
 * Class JwtAuth
 * Este componente maneja la generación, validación y obtiene el token JWT del encabezado de la solicitud.
 */
class JwtAuth extends Component {

    /**
     * Genera un JWT token.
     *
     * @param array $payload Los datos que se incluirán en el token.
     * @return string El JWT token generado.
     */
    public static function generateToken($payload) {
        $key = Yii::$app->params['jwtKey'];
        $token = JWT::encode($payload, $key, 'HS256');
        return $token;
    }

    /**
     * Valida el JWT token.
     *
     * @param string $token El JWT token a validar.
     * @return object|null El token decodificado si es válido o nulo si no es válido.
     */
    public static function validateToken($token) {
        $key = Yii::$app->params['jwtKey'];
        try {
            $decoded = JWT::decode($token, new Key($key, 'HS256'));
            return $decoded;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Extrae el JWT token del encabezado de la solicitud.
     *
     * @return string|null El JWT token extraído, o nulo si no se encuentra.
     */
    public static function getTokenFromHeader() {
        $headers = Yii::$app->request->headers;
        $authHeader = $headers->get('Authorization');
        if ($authHeader !== null && preg_match("/^Bearer\\s+(.*?)$/", $authHeader, $matches)) {
            return $matches[1];
        }
        return null;
    }
}
