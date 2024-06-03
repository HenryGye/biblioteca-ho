<?php 
namespace app\models;

use Yii;
use yii\mongodb\ActiveRecord;

/**
 * Class Libro
 *
 * @package app\models
 *
 * Clase modelo Libro para manejar registros de libros en MongoDB.
 */
class Libro extends ActiveRecord 
{     
    /**
     * @inheritdoc
     */
    public static function collectionName() {         
        return 'libros';     
    }     

    /**
     * @inheritdoc
     */
    public function attributes() {         
        return [
            '_id',
            'titulo',
            'autores',
            'anio_publicacion',
            'generos',
            'descripcion',
            'isbn',
        ];  
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['titulo', 'autores', 'anio_publicacion', 'generos', 'descripcion', 'isbn'], 'required'],
            [['titulo', 'descripcion'], 'string'],
            [['anio_publicacion'], 'integer'],
            [['autores'], 'safe'],
            [['isbn'], 'unique'],
        ];
    }

    // public function getAutores() {
    //     return $this->hasMany(Autor::class, ['_id' => 'autores']);
    // }

    /**
     * Lista libros según los filtros especificados.
     *
     * @param string|null $genero Filtrar por genero
     * @param string|null $autor Filtrar por nombre autor
     * @param int|null $anio Filtrar por año de publicación
     * @return array Lista de libros que coinciden con los filtros, si no se especifica ningún filtro 
     * devuelve todo el listado de libros.
     */
    public static function listarLibros($genero = null, $autor = null, $anio = null) {
        $pipeline = [];

        if ($genero !== null) {
            $pipeline[] = ['$match' => ['generos' => $genero]];
        }

        if ($autor !== null) {
            $autorIds = Autor::find()->select(['_id'])->where(['like', 'LOWER(nombre_completo)', strtolower($autor)])->column();
            $pipeline[] = !empty($autorIds) ? ['$match' => ['autores' => ['$in' => $autorIds]]] : [];
        }

        if ($anio !== null) {
            $pipeline[] = ['$match' => ['anio_publicacion' => (int)$anio]];
        }

        $collection = Yii::$app->mongodb->getCollection(self::collectionName());

        $pipeline[] = [
            '$lookup' => [
                'from' => 'autores',
                'localField' => 'autores',
                'foreignField' => '_id',
                'as' => 'autores'
            ]
        ];

        $libros = $collection->aggregate($pipeline);
        return $libros;
    }

    /**
     * Lista un libro por su ID.
     *
     * @param string $id id del libro
     * @return array|null Devuelve el registro del libro o nulo si no se encuentra.
     */
    public static function buscarLibroPorId($id)
    {
        $collection = Yii::$app->mongodb->getCollection(self::collectionName());

        $pipeline = [
            ['$match' => ['_id' => $id]],
            [
                '$lookup' => [
                    'from' => 'autores',
                    'localField' => 'autores',
                    'foreignField' => '_id',
                    'as' => 'autores'
                ]
            ]
        ];

        $libro = $collection->aggregate($pipeline);
        return $libro;
    }

    /**
     * Registrar un nuevo libro
     *
     * @param array $request data del request
     * @return Libro El registro del libro guardado.
     * @throws \yii\web\BadRequestHttpException Devuelve una excepción si ocurre un error durante el proceso de registrar.
     */
    public static function registrarLibro($request) {
        $libro = new Libro();
        $libro->load($request, '');

        if (!$libro->save()) {
            throw new \yii\web\BadRequestHttpException('Error al registrar libro');
        }

        foreach ($request['autores'] as $value) {
            $autor = new Autor();
            $autor->load($value, '');

            if (!$autor->save()) {
                $libro->delete();
                throw new \yii\web\BadRequestHttpException('Error al registrar autor');
            }

            $autoresId[] = $autor->_id;
        }
        
        $libro->autores = $autoresId;
        $libro->save();

        return $libro;
    }

    /**
     * Actualiza un libro existente
     *
     * @param Libro $libro Registro del libro a actualizar
     * @return Libro Registro del libro actualizado
     * @throws \yii\web\BadRequestHttpException Devuelve una excepción si ocurre un error durante el proceso de actualizar.
     */
    public static function actualizarLibro($libro) {
        foreach ($libro->autores as $value) {
            $autor = Autor::findOne(['_id' => $value['id']]);

            $autorArray = (array) $value;
            unset($autorArray['id']);

            $autor->load($autorArray, '');

            if (!$autor->save()) {
                throw new \yii\web\BadRequestHttpException("Error al actualizar autor con id {$value['id']}");
            }

            $autoresId[] = $autor->_id;
            $libro->autores = $autoresId;

            if (!$libro->save()) {
                throw new \yii\web\BadRequestHttpException('Error al actualizar libro');
            }
        }
        
        return $libro;
    }

    /**
     * Elimina un libro existente
     *
     * @param Libro $libro Registro del libro a eliminar
     * @return Libro Registro del libro eliminado
     * @throws \yii\web\BadRequestHttpException Devuelve una excepción si ocurre un error durante el proceso de eliminar.
     */
    public static function eliminarLibro($libro) {
        foreach ($libro->autores as $value) {
            $autor = Autor::findOne(['_id' => $value]);

            if ($autor && !$autor->delete()) {
                throw new \yii\web\BadRequestHttpException("Error al eliminar autor con id {$value['id']}");
            }
        }

        if (!$libro->delete()) {
            throw new \yii\web\BadRequestHttpException('Error al eliminar libro');
        }
        
        return $libro;
    }
}