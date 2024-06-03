<?php

namespace app\controllers;

use Yii;
use yii\rest\ActiveController;
use app\models\Libro;
use app\models\Autor;
use app\components\JwtAuthFilter;

/**
 * LibroController implementa las acciones CRUD para el modelo Libro.
 */
class LibroController extends ActiveController
{
    /**
     * @var string el nombre de la clase del modelo Libro
     */
    public $modelClass = 'app\models\Libro';

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
     * Lista los libros según el nombre y la nacionalidad proporcionados.
     *
     * @return \yii\web\Response Respuesta JSON que contiene la lista de libros.
     * @throws \yii\web\NotFoundHttpException Devuelve una excepción si no se encuentran libros.
     */
    public function actionListar() {
        $request = Yii::$app->request;
        $genero = $request->get('genero');
        $autor = $request->get('autor');
        $anio = $request->get('anio');

        $libros = Libro::listarLibros($genero, $autor, $anio);

        if (!$libros) {
            throw new \yii\web\NotFoundHttpException;
        }

        return $this->asJson($libros);
    }

    /**
     * LIsta un único libro según el ID proporcionado.
     *
     * @return \yii\web\Response Respuesta JSON que contiene los detalles del libro.
     * @throws \yii\web\NotFoundHttpException Devuelve una excepción si no se encuentra el libro.
     */
    public function actionListarPorId() {
        $request = Yii::$app->request;
        $id = $request->get('id');
        $libro = Libro::buscarLibroPorId($id);

        if (!$libro) {
            throw new \yii\web\NotFoundHttpException;
        }

        return $this->asJson($libro);
    }

    /**
     * Registra un nuevo libro.
     *
     * @return array|mixed Respuesta JSON que contiene los detalles del libro registrado o errores de validación.
     */
    public function actionRegistrar() {
        $libro = new Libro();

        $requestLibro = Yii::$app->request->post();
        $requestAutor = $requestLibro['autores'] ?? [];

        $libro->load($requestLibro, '');

        if (!$libro->validate()) {
            return ['errors' => $libro->errors];
        }

        foreach ($requestAutor as $value) {
            $autor = new Autor();
            $autor->load($value, '');
            
            if (!$autor->validate()) {
                return ['errors' => $autor->errors];
            }
        }

        return $libro::registrarLibro($requestLibro);
    }

    /**
     * Actualiza un libro existente.
     *
     * @return array|mixed Respuesta JSON que contiene los detalles actualizados del libro o errores de validación.
     * @throws \yii\web\NotFoundHttpException Devuelve una excepción si no se encuentra el libro a actualizar.
     */
    public function actionActualizar() {
        $request = Yii::$app->request;
        $requestLibro = $request->post();
        $requestAutor = $requestLibro['autores'];

        $libro = Libro::findOne(['_id' => $request->get('id')]);

        if (!$libro) {
            throw new \yii\web\NotFoundHttpException;
        }

        $libro->load($requestLibro, '');

        if (!$libro->validate()) {
            return ['errors' => $libro->errors];
        }

        foreach ($requestAutor as $value) {
            $idAutor = $value['id'] ?? null;
            $autor = Autor::findOne(['_id' => $idAutor]);

            if (!$autor) {
                throw new \yii\web\NotFoundHttpException("Autor con id {$idAutor} no encontrado");
            }

            $autor->load($value, '');
            
            if (!$autor->validate()) {
                return ['errors' => $autor->errors];
            }
        }
        
        return $libro::actualizarLibro($libro);
    }

    /**
     * Elimina un libro existente.
     *
     * @return mixed Respuesta JSON que contiene el detalle del libro eliminado.
     * @throws \yii\web\NotFoundHttpException Devuelve una excepción si no se encuentra el libro a eliminar.
     */
    public function actionEliminar() {
        $request = Yii::$app->request;

        $libro = Libro::findOne(['_id' => $request->get('id')]);

        if (!$libro) {
            throw new \yii\web\NotFoundHttpException;
        }
        
        return $libro::eliminarLibro($libro);
    }
}
