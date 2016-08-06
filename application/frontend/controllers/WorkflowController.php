<?php
namespace frontend\controllers;

use common\models\Workflow;
use HttpInvalidParamException;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;

class WorkflowController extends ActiveController
{
    public $modelClass = 'common\models\Workflow';

//    public function actionNewWorkflow() {
////        $service = \Yii::$app->request-getBodyParam('service', null);
////        if ($service != 8) {
////            throw new HttpInvalidParamException("Invalid service $service");
////        }
//
//        $workflow = new Workflow();
//        return $workflow;
//    }
    
    public function actionViewWorkflow($id) {
        $workflow = Workflow::findById($id);
        if (!$workflow) {
            return [];
            //throw new NotFoundHttpException();
        }

        return $workflow;
    }
}