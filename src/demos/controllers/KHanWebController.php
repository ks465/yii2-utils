<?php
namespace khans\utils\demos\controllers;


use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\Response;


class KHanWebController extends \khans\utils\controllers\KHanWebController
{
    public $layout = 'demo';
    
    /**
     * {@inheritDoc}
     * @see KHanWebController::actionAudit()
     */
    public function actionAudit($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = $this->findModel($id);
        $dataProvider = new ActiveDataProvider(['query' => $model->getActionHistory()]);

        return [
            'title'   => "رکورد #" . $model->id . ' جدول Test Workflow Events with EAV',
            'content' => $this->renderAjax('@khan/demos/views/history-database/record', [
                'dataProvider' => $dataProvider,
            ]),
            'footer'  => Html::button('ببند', ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) .
            '<strong class="text-info pull-right">'. '* These are EAV Fields' . '</strong>',
        ];
    }
}

