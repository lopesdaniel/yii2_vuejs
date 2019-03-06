<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "noticias".
 *
 * @property int $id
 * @property string $titulo
 * @property string $conteudo
 * @property int $categoria_id
 */
class Noticias extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'noticias';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['titulo', 'conteudo', 'categoria_id'], 'required'],
            [['id', 'categoria_id'], 'integer'],
            [['titulo'], 'string', 'max' => 45],
            [['conteudo'], 'string', 'max' => 255],
            [['id'], 'unique']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'titulo' => 'Titulo',
            'conteudo' => 'Conteudo',
            'categoria_id' => 'Categoria ID',
        ];
    }

    //Realizando a relação com a tabela Categoria
    public function getCategoria()
    {
        return $this->hasOne(Categorias::className(), ['id' => 'categoria_id']);
    }
    //Ao adicionar expands na URL consigo recuperar os dados do relacionamento
    public function extraFields()
    {
        return ['categoria'];
    }

}
