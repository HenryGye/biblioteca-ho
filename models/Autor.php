<?php 
namespace app\models;

use Yii;
use yii\mongodb\ActiveRecord;

/**
 * Class Autor
 *
 * @package app\models
 *
 * Clase modelo Autor para manejar registros de autores en MongoDB.
 */
class Autor extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function collectionName() {
        return 'autores';
    }

    /**
     * @inheritdoc
     */
    public function attributes() {
        return [
            '_id',
            'nombre_completo',
            'fecha_nacimiento',
            'nacionalidad',
            'biografia',
            'libros_publicados',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['nombre_completo', 'fecha_nacimiento', 'nacionalidad', 'biografia', 'libros_publicados'], 'required'],
            [['nombre_completo', 'nacionalidad', 'biografia'], 'string'],
            [['nombre_completo'], 'unique'],
            [['fecha_nacimiento'], 'date', 'format' => 'php:Y-m-d'],
            [['libros_publicados'], 'safe'],
        ];
    }

    // public function getLibros()
    // {
    //     return $this->hasMany(Libro::class, ['_id' => 'libros_publicados']);
    // }

    /**
     * Lista autores según los filtros especificados.
     *
     * @param string|null $nombre Filtrar por nombre de autor
     * @param string|null $nacionalidad Filtrar por nacionalidad del autor
     * @return array Lista de autores que coinciden con los filtros, si no se especifica ningún filtro 
     * devuelve todo el listado de autores.
     */
    public static function listarAutores($nombre = null, $nacionalidad = null) {
        $pipeline = [];

        if ($nombre !== null) {
            $autorIds = Autor::find()->select(['_id'])->where(['like', 'LOWER(nombre_completo)', strtolower($nombre)])->column();

            if (!empty($autorIds)) {
                $pipeline[] = ['$match' => ['autores' => ['$in' => $autorIds]]];
            }
        }

        if ($nacionalidad !== null) {
            $pipeline[] = ['$match' => ['nacionalidad' => ['$regex' => $nacionalidad, '$options' => 'i']]];
        }

        $collection = Yii::$app->mongodb->getCollection(self::collectionName());

        $autores = $collection->aggregate($pipeline);
        return $autores;
    }

    /**
     * Lista un autor por su ID.
     *
     * @param string $id id del autor
     * @return array|null Devuelve el registro del autor o nulo si no se encuentra.
     */
    public static function buscarAutorPorId($id)
    {
        $autor = Autor::findOne(['_id' => $id]);
        return $autor;
    }

    /**
     * Registrar/Actualizar un autor
     *
     * @param array $request data del request a registrar/actualizar
     * @return Libro El registro del autor guardado.
     * @throws \yii\web\BadRequestHttpException Devuelve una excepción si ocurre un error durante el proceso de registrar.
     */
    public static function guardarAutor($autor) {
        $message = $autor->_id ? 'Error al actualizar autor' : 'Error al registrar autor';

        if (!$autor->save()) {
            throw new \yii\web\BadRequestHttpException($message);
        }

        return $autor;
    }

    /**
     * Elimina un autor existente
     *
     * @param Libro $libro Registro del autor a eliminar
     * @return Libro Registro del autor eliminado
     * @throws \yii\web\BadRequestHttpException Devuelve una excepción si ocurre un error durante el proceso de eliminar.
     */
    public static function eliminarAutor($autor) {
        if (!$autor->delete()) {
            throw new \yii\web\BadRequestHttpException('Error al eliminar autor');
        }
        
        return $autor;
    }
}
