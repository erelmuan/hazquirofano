<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
//modelos
use app\models\Paciente;
use app\models\Medico;
use app\models\Procedencia;
use app\models\Provincia;
use app\models\Localidad;
use app\models\Usuario;
use app\models\Auditoria;
use app\models\Rol;
use app\models\Modulo;
use app\models\Accion;
use app\models\Equipo;
use app\models\Cirugiaprogramada;

use app\components\Seguridad\Seguridad;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout','administracion'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                    [
                        //El administrador tiene permisos sobre las siguientes acciones
                        'actions' => ['administracion'],
                        'allow' => true,
                        //Usuarios autenticados, el signo ? es para invitados
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            if (Yii::$app->user->identity->id_pantalla==1 ){
                                return false;
                              }
                              else {
                                return true;
                              }

                        }
                    ],

                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

 public function actionFlash () {
   $session = Yii::$app->session; // establece un mensaje flash llamado "greeting "
   $session->setFlash ( 'saludo ', 'Hola usuarioator! ');
   return $this->render ( 'flash');
 }
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {

       $cantidadMedicos = Medico::find()->count();
       $cantidadPacientes = Paciente::find()->count();
       $cantidadProcedencia =Procedencia::find()->count();
       $cantidadEquipos =Equipo::find()->count();
        return $this->render('index',[
        'cantidadPacientes'=>$cantidadPacientes,
        'cantidadMedicos'=>$cantidadMedicos,
        'cantidadProcedencia'=>$cantidadProcedencia,
        'cantidadEquipos'=>$cantidadEquipos

        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
      $this->layout = 'main2';

        if (!Yii::$app->user->isGuest) {
          /* Al entrar al sistema aparecera la pagina de login (return $this->render('login'),puesto
            que no entra a este if y tampoco al siguiente ( porque no esta logueado
            y por lo tanto  es invitado ni valida el post)*/
          /* Si se loguea entonces, pasa de largo la primera vez el isGuest
            entra al segundo if, se valida return goback hace volver al loguin
            de esa forma ahi si entra al primer if, y se dirige al pagina de inicio home() */
          /*Si vuelve para atras una vez logueado se redigira al primer if */
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
          if (!Yii::$app->user->identity->activo ){
              Yii::$app->user->logout();
            }
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }


    public function actionLocalizacion()
    {
      $cantidadProcedencia = Procedencia::find()->count();
      $cantidadProvincia =Provincia::find()->count();
      $cantidadLocalidad = Localidad::find()->count();
     return $this->render('localizacion',[
       'cantidadProcedencia'=>$cantidadProcedencia,
       'cantidadProvincia'=>$cantidadProvincia,
       'cantidadLocalidad'=>$cantidadLocalidad,
          ]);
    }


    public function actionAdministracion()
    {
      $cantidadUsuarios = Usuario::find()->count();
      $cantidadAuditorias =Auditoria::find()->count();

        return $this->render('administracion',[
          'cantidadUsuarios'=>$cantidadUsuarios,
          'cantidadAuditorias'=>$cantidadAuditorias
         ]);
    }
    public function actionPermisos()
    {
        $cantidadRoles= Rol::find()->count();
        $cantidadModulos = Modulo::find()->count();
        $cantidadAcciones = Accion::find()->count();

          return $this->render('permisos',[
            'cantidadRoles'=>$cantidadRoles,
            'cantidadModulos'=>$cantidadModulos,
            'cantidadAcciones'=>$cantidadAcciones
           ]);
    }

    public function actionConstruccion()
    {
        return $this->render('construccion');
    }
}
