<?php
namespace operator\components;

use Yii;
use yii\web\User;

class WebUser extends User
{
    protected function afterLogin($identity, $cookieBased, $duration)
    {
        parent::afterLogin($identity, $cookieBased, $duration);

        if (Yii::$app->authManager->checkAccess($identity->id, 'operator_returned')) {
            Yii::$app->response->redirect(['returned/index'])->send();
            exit;
        }
        
        if (Yii::$app->authManager->checkAccess($identity->id, 'operator')) {
            Yii::$app->response->redirect(['operator/index'])->send();
            exit;
        }
    }
}

?>