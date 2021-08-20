<?php

namespace app\models;
use app\components\behaviors\AuditoriaBehaviors;
use Yii;
use yii\helpers\ArrayHelper;


/**
 * This is the model class for table "medico".
 *
 * @property string $apellido
 * @property string $nombre
 * @property int $id
 * @property string $num_documento
* @property string $matricula
 * @property int $id_tipodoc
 * @property int $id_especialidad
 * @property int $id_usuario
* @property Usuario $usuario
 * @property Tipodoc $tipodoc
 * @property Especialidad $especialidad
 * * @property Cirugiaprogramada[] $cirugiaprogramadas
 * @property Usuario $usuario
 */
class Medico extends \yii\db\ActiveRecord
{
  public function behaviors()
  {

    return array(
           'AuditoriaBehaviors'=>array(
                  'class'=>AuditoriaBehaviors::className(),
                  ),
      );
 }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'medico';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['apellido', 'nombre', 'num_documento'], 'required'],
            [['matricula'], 'string'],
            [['id_tipodoc', 'id_especialidad', 'id_usuario'], 'integer'],
            [['apellido', 'nombre'], 'string', 'max' => 35],
            [['num_documento'], 'string', 'max' => 15],
            [['id_usuario'], 'unique'],
            [['id_tipodoc'], 'exist', 'skipOnError' => true, 'targetClass' => Tipodoc::className(), 'targetAttribute' => ['id_tipodoc' => 'id']],
            [['id_especialidad'], 'exist', 'skipOnError' => true, 'targetClass' => Especialidad::className(), 'targetAttribute' => ['id_especialidad' => 'id']],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['id_usuario' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'apellido' => 'Apellido',
            'nombre' => 'Nombre',
            'id' => 'ID',
            'num_documento' => 'N° doc.',
            'matricula' => 'Matricula',
            'id_tipodoc' => 'Tipo de documento',
            'id_especialidad' => 'Profesión',
            'id_usuario' => 'Id Usuario',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipodoc()
    {
        return $this->hasOne(Tipodoc::className(), ['id' => 'id_tipodoc']);
    }

    public function getTipodocs() {
            return ArrayHelper::map(Tipodoc::find()->all(), 'id','documento');

        }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEspecialidad()
    {
        return $this->hasOne(Especialidad::className(), ['id' => 'id_especialidad']);
    }

    public function getEspecialidades() {
            return ArrayHelper::map(Especialidad::find()->all(), 'id','profesion');

        }
     public function getUsuario()
    {
          return $this->hasOne(Usuario::className(), ['id' => 'id_usuario']);
     }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return ArrayHelper::map(Usuario::find()->all(), 'id','usuario');
    }
    public function beforeSave($insert){
    //DE FORMA INDIVIDUAL
     if ($insert) {
      $this->nombre = strtoupper($this->nombre);
      $this->apellido = strtoupper($this->apellido);
    }
      return parent::beforeSave($insert);
    }
    /**
	 * Gets query for [[Cirugiaprogramadas]].
	 *
	 * @return \yii\db\ActiveQuery
	*/
     public function getCirugiaprogramadas()
     {
        return $this->hasMany(Cirugiaprogramada::className(), ['id_medico' => 'id']);
   }
}
