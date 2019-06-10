<?php

namespace khans\utils\demos\controllers;

use Yii;
use khans\utils\demos\data\SysHistoryEmails;
use khans\utils\demos\data\SysHistoryEmailsSearch;
use yii\data\ActiveDataProvider;
use khans\utils\controllers\KHanWebController;
use yii\web\NotFoundHttpException;
use \yii\web\Response;
use yii\helpers\Html;

/**
 * HistoryEmailsController implements the CRUD actions for SysHistoryEmails model.
 *
 * @package khans\utils\generatedControllers
 * @version 0.2.0-980119
 * @since   1.0
 */
class HistoryEmailsController extends KHanWebController
{
    /**
     * Lists all SysHistoryEmails models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SysHistoryEmailsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SysHistoryEmails model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'   => "تاریخچه ارسال ایمیل خودکار گردش کار #" . $model->id,
                    'content' => $this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'  => Html::button('ببند', ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal'])
                ];
        }else{
            return $this->render('view', [
                'model' => $model,
            ]);
        }
    }


    /**
     * Finds the SysHistoryEmails model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return SysHistoryEmails the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SysHistoryEmails::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('صفحه درخواست شده پیدا نشد.');
        }
    }
}
