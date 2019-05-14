<?php


namespace khans\utils\tools\controllers;

use khans\utils\components\workflow\KHanWorkflowHelper;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;

/**
 * Default controller for the `khan` module
 *
 * @package khans\utils\generatedControllers
 * @version 0.2.0-980208
 * @since   1.0 */
class DefaultController extends \khans\utils\controllers\KHanWebController
{
    /**
     * Renders the index view for the module
     *
     * @return string
     */
    public function actionIndex() {
        return $this->render('index');
    }

    /**
     * Renders a page containing definition of a selected workflow along with 
     * visual representation of workflow
     * 
     * @return string
     */
    public function actionWorkflow() {
        $selectedWF = $email = '';
        $allModels = $model = null;
        $showVisual = false;
        if (Yii::$app->request->isPost) {
            $selectedWF = Yii::$app->request->post('workflow_select');

            $model = new \khans\utils\tools\models\WorkflowEvents();
            $model->enterWorkflow($selectedWF);

            $check = KHanWorkflowHelper::checkWorkflowStructure($model->getWorkflow());
            if ($check['result'] === false) {
                foreach ($check['messages'] as $key => $message) {
                    \Yii::$app->session->addFlash('error', $key . ': ' . implode(', ', $message));
                }
            }

            $allModels = $model->getWorkflow()->getAllStatuses();
            $email = KHanWorkflowHelper::getDefaultMailTemplate($model->getWorkflow());
            $showVisual = true;
        }

        return $this->render('workflow', [
                    'selectedWF'   => $selectedWF,
                    'files'        => KHanWorkflowHelper::getSourcesTitles(),
                    'defaultEmail' => $email,
                    'testModel'    => $model,
                    'showVisual'   => $showVisual,
                    'dataProvider' => new \yii\data\ArrayDataProvider([
                        'allModels'  => $allModels,
                        'pagination' => false,
                            ]),
        ]);
    }
}