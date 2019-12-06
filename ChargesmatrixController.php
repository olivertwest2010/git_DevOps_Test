<?php

namespace backend\controllers;

use Yii;
use backend\models\Chargesmatrix;
use backend\models\ChargesmatrixSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * ChargesmatrixController implements the CRUD actions for Chargesmatrix model.
 */
class ChargesmatrixController extends Controller {

    const STATUS_ACTIVE = 3;
    const STATUS_PENDING = 4;
    const STATUS_DECLINED = 5;
    const STATUS_UNPROCESSED = 0;
    const MIN_PIN = 1000;
    const MAX_PIN = 9999;
    const MIN_REF = 10000000;
    const MAX_REF = 99999999;

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                // ...
                ],
            ],
            'ghost-access' => [
                'class' => 'webvimark\modules\UserManagement\components\GhostAccessControl',
            ],
        ];
    }

    /**
     * Lists all Chargesmatrix models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new ChargesmatrixSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

// public function actionApprove() {
//        $searchModel = new ChargesmatrixSearch();
//        $dataProvider = $searchModel->searchapprove(Yii::$app->request->queryParams);
//
//        return $this->render('approve', [
//                    'searchModel' => $searchModel,
//                    'dataProvider' => $dataProvider,
//        ]);
//    }
    /**
     * Displays a single Chargesmatrix model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Chargesmatrix model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Chargesmatrix();
        $searchModel = new ChargesmatrixSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', \Yii::t('app', 'Matrix created successfully'));
            return $this->redirect(['create']);
        } else {
            return $this->render('create', [
                        'model' => $model,
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
            ]);
        }
    }

    /**
     * Updates an existing Chargesmatrix model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
                     Yii::$app->session->setFlash('success', 'Charge matrix updated successfully');
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Chargesmatrix model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['create']);
    }

    /**
     * Finds the Chargesmatrix model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Chargesmatrix the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Chargesmatrix::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
