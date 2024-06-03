<?php

namespace app\controllers;

use Yii;
use yii\rest\ActiveController;
use app\models\Autor;
use app\components\JwtAuthFilter;

/**
 * AutorController implementa las acciones CRUD para el modelo Autor.
 */
class AutorController extends ActiveController
{
    /**
     * @var string el nombre de la clase del modelo Autor
     */
    public $modelClass = 'app\models\Autor';

    /**
     * Define el comportamiento para el controlador, aplica el filtro para la autenticación 
     * y autorización por medio de JWT Token antes de ejecutar algún método
     * @return array
     */
    public function behaviors() {
        return [
            'jwtAuth' => [
                'class' => JwtAuthFilter::class,
            ],
        ];
    }

    /**
     * Lista los autores según el nombre y la nacionalidad proporcionados.
     *
     * @return \yii\web\Response Respuesta JSON que contiene la lista de autores.
     * @throws \yii\web\NotFoundHttpException Devuelve una excepción si no se encuentran autores.
     */
    public function actionListar() {
        $request = Yii::$app->request;
        $nombre = $request->get('nombre');
        $nacionalidad = $request->get('nacionalidad');

        $autores = Autor::listarAutores($nombre, $nacionalidad);

        if (!$autores) {
            throw new \yii\web\NotFoundHttpException;
        }

        return $this->asJson($autores);
    }

    /**
     * LIsta un único autor según el ID proporcionado.
     *
     * @return \yii\web\Response Respuesta JSON que contiene los detalles del autor.
     * @throws \yii\web\NotFoundHttpException Devuelve una excepción si no se encuentra el autor.
     */
    public function actionListarPorId() {
        $request = Yii::$app->request;
        $id = $request->get('id');
        $autor = Autor::buscarAutorPorId($id);

        if (!$autor) {
            throw new \yii\web\NotFoundHttpException;
        }

        return $this->asJson($autor);
    }

    /**
     * Registra un nuevo autor.
     *
     * @return array|mixed Respuesta JSON que contiene los detalles del autor registrado o errores de validación.
     */
    public function actionRegistrar() {
        $autor = new Autor();

        $request = Yii::$app->request->post();

        $autor->load($request, '');

        if (!$autor->validate()) {
            return ['errors' => $autor->errors];
        }

        return $autor::guardarAutor($autor);
    }

    /**
     * Actualiza un autor existente.
     *
     * @return array|mixed Respuesta JSON que contiene los detalles actualizados del autor o errores de validación.
     * @throws \yii\web\NotFoundHttpException Devuelve una excepción si no se encuentra el autor a actualizar.
     */
    public function actionActualizar() {
        $request = Yii::$app->request;

        $autor = Autor::findOne(['_id' => $request->get('id')]);

        if (!$autor) {
            throw new \yii\web\NotFoundHttpException;
        }

        $autor->load($request->post(), '');

        if (!$autor->validate()) {
            return ['errors' => $autor->errors];
        }
        
        return $autor::guardarAutor($autor);
    }

    /**
     * Elimina un autor existente.
     *
     * @return mixed Respuesta JSON que contiene el detalle del autor eliminado.
     * @throws \yii\web\NotFoundHttpException Devuelve una excepción si no se encuentra el autor a eliminar.
     */
    public function actionEliminar() {
        $request = Yii::$app->request;

        $autor = Autor::findOne(['_id' => $request->get('id')]);

        if (!$autor) {
            throw new \yii\web\NotFoundHttpException;
        }
        
        return $autor::eliminarAutor($autor);
    }
}
