<?php

namespace app\controllers;

use app\components\Transport\Transport;
use app\models\User;
use app\components\AccessRule;
use yii\filters\AccessControl;
use Yii;
use app\models\EventHandler;
use app\components\Eventable\EventableInterface;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EventHandlerController implements the CRUD actions for EventHandler model.
 */
class EventHandlerController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                // We will override the default rule config with the new AccessRule class
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [
                            User::ROLE_ADMIN,
                        ],
                    ],
                ],
            ]
        ];
    }

    /**
     * Получить события для модели
     * @return json array
     */
    public function actionGetEvents() {
        $model_name = Yii::$app->request->get('model');
        $namespace = 'app\models\\';
        $class = $namespace . $model_name;
        $events = $class::getEvents();
        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->data = array_keys($events);
        return $response;
    }

    /**
     * Получить получателей для модели
     * @return json array
     */
    public function actionGetRecipients() {
        $model_name = Yii::$app->request->get('model');
        $namespace = 'app\models\\';
        $class = $namespace . $model_name;
        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->data = $class::getRecipientList();
        return $response;
    }

    /**
     * Получить список всех пользователей
     * @return json array
     */
    public function actionGetUsers() {
        $users = User::find()->all();
        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->data = ArrayHelper::map($users, 'id', 'name');
        return $response;

    }

    /**
     * Получить аттрибуты модели
     * @return json array
     */
    public function actionGetModelAttributes() {
        $model_name = Yii::$app->request->get('model');
        $namespace = 'app\models\\';
        $class = $namespace . $model_name;
        $model = new $class;
        $attr = $model->attributes();
        Yii::info($attr);
        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->data = $model->attributes();
        return $response;
    }

    /**
     * Lists all EventHandler models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => EventHandler::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EventHandler model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new EventHandler model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $events = array();

        $models_dir = dirname(__DIR__).'/models/';
        $files = scandir($models_dir);

        $model_namespace = 'app\models\\';
        foreach($files as $file) { //Поиск всех моделей, имплементирующих EventableInterface
            if ($file == '.' || $file == '..' || !preg_match('/\.php/', $file)) continue;
            $check_model = preg_replace('/\.php$/', '', $file);
            $impl = class_implements($model_namespace . $check_model);
            if (in_array("app\\components\\Eventable\\EventableInterface", $impl)) {
                $events[$check_model] = $check_model;
            }
        }

        $model = new EventHandler();
        $transport = Transport::getTransports();
        $transport_a = [];
        foreach($transport as $t) $transport_a[$t] = $t;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'events' => $events,
                'transport' => $transport_a,
            ]);
        }
    }

    /**
     * Updates an existing EventHandler model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing EventHandler model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the EventHandler model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EventHandler the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EventHandler::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
