<?php

namespace app\components;

class ErrorHandler extends \yii\web\ErrorHandler
{
    /**
     * Manejador de errores comunes.
     *
     * @param Exception $exception el tipo de excepcion
     * @return string retorna el resultado especificado
     */
    protected function renderException($exception)
    {
        $message = !empty($exception->getMessage()) ? $exception->getMessage() : null;
        
        if ($exception instanceof \yii\web\NotFoundHttpException) {
            return $this->renderErrorPage($message ?? 'Registro no encontrado', 404);
        } elseif ($exception instanceof \yii\web\BadRequestHttpException) {
            return $this->renderErrorPage($message ?? 'Solicitud incorrecta', 400);
        } elseif ($exception instanceof \yii\web\ForbiddenHttpException) {
            return $this->renderErrorPage($message ?? 'Acceso denegado', 403);
        } else {
            return $this->renderErrorPage($message ?? 'Ha ocurrido un error', 500);
        }
    }

    /**
     * Retorna el error personalizado
     *
     * @param string $message el mensaje de error
     * @param int $statusCode el código de estado HTTP
     * @return string el resultado del error
     */
    protected function renderErrorPage($message, $statusCode)
    {
         \Yii::createObject([
            'class' => 'yii\web\Response',
            'format' => \yii\web\Response::FORMAT_JSON,
            'data' => [
                'message' => $message,
                'statusCode' => $statusCode,
            ],
        ])->send();
    }
}
