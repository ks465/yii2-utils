<?php


namespace khans\utils\demos\controllers;

use khans\utils\controllers\KHanWebController;
use khans\utils\demos\data\MultiFormatData;
use khans\utils\demos\data\MultiFormatDataSearch;
use Yii;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * EntitiesRController implements the CRUD actions for TestEntities model.
 *
 * @package khans\utils\generatedControllers
 * @version 0.1.0-980119
 * @since   1.0
 */
class EntitiesRController extends KHanWebController
{
    /**
     * Lists all TestEntities models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MultiFormatDataSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TestEntities model.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            return [
                'title'   => "Read Only #" . $model->pk_column,
                'content' => $this->renderAjax('view', [
                    'model' => $model,
                ]),
                'footer'  => Html::button('ببند', ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']),
            ];
        } else {
            return $this->render('view', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Finds the TestEntities model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return MultiFormatData the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MultiFormatData::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('صفحه درخواست شده پیدا نشد.');
        }
    }
}
