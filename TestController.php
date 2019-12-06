<?php

namespace backend\controllers;

use Yii;
use backend\models\Accountlinking;
use backend\controllers\Accountlinking;
use backend\models\Customers;
use yii\web\Controller;
use yii\web\NotFoundHttpException;



/**
 * AccountlinkingController implements the CRUD actions for Accountlinking model.
 */
class TestController extends Controller {

    /**
     * @inheritdoc
     */


    /**
     * Lists all Accountlinking models.
     * @return mixed
     */
    public function actionIndex() {
        $test = new AccountlinkingController;
         $test->actionGetbankdetails();
    }

// list all the accounts for approval.
   
}
