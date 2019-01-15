<?php
/**
 * This is the template for generating a CRUD controller class file.
 *
 * @package khans\utils\generatedControllers
 * @version 0.1.3-971016
 * @since   1.0
 */

use yii\helpers\Inflector;
use yii\helpers\StringHelper;
use yii\db\ActiveRecordInterface;


/* @var $this yii\web\View */
/* @var $generator khans\utils\helpers\generators\crud\Generator */

$controllerClass = StringHelper::basename($generator->controllerClass);
$modelClass = StringHelper::basename($generator->modelClass);
$searchModelClass = StringHelper::basename($generator->searchModelClass);
if ($modelClass === $searchModelClass) {
    $searchModelAlias = $searchModelClass . 'Search';
}

/* @var $class ActiveRecordInterface */
$class = $generator->modelClass;
$pks = $class::primaryKey();
$urlParams = $generator->generateUrlParams();
$actionParams = $generator->generateActionParams();
$actionParamComments = $generator->generateActionParamComments();

echo "<?php\n";
?>

namespace <?= StringHelper::dirname(ltrim($generator->controllerClass, '\\')) ?>;

use Yii;
use <?= ltrim($generator->modelClass, '\\') ?>;
<?php if (!empty($generator->searchModelClass)): ?>
use <?= ltrim($generator->searchModelClass, '\\') . (isset($searchModelAlias) ? " as $searchModelAlias" : "") ?>;
<?php else: ?>
use yii\data\ActiveDataProvider;
<?php endif; ?>
use <?= ltrim($generator->baseControllerClass, '\\') ?>;
use yii\web\NotFoundHttpException;
use \yii\web\Response;
use yii\helpers\Html;

/**
 * <?= $controllerClass ?> implements the CRUD actions for <?= $modelClass ?> model.
 *
 * @package khans\utils\generatedControllers
 * @version 0.1.3-971016
 * @since   1.0
 */
class <?= $controllerClass ?> extends <?= StringHelper::basename($generator->baseControllerClass) . "\n" ?>
{
    /**
     * Lists all <?= $modelClass ?> models.
     * @return mixed
     */
    public function actionIndex()
    {
       <?php if (!empty($generator->searchModelClass)): ?>
 $searchModel = new <?= isset($searchModelAlias) ? $searchModelAlias : $searchModelClass ?>();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
<?php else: ?>
        $dataProvider = new ActiveDataProvider([
            'query' => <?= $modelClass ?>::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
<?php endif; ?>
    }

    /**
     * Displays a single <?= $modelClass ?> model.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return mixed
     */
    public function actionView(<?= $actionParams ?>)
    {
        $request = Yii::$app->request;
        $model = $this->findModel(<?= $actionParams ?>);

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'   => "<?= $generator->tableTitle ?> #" . $model-><?= $generator->getNameAttribute() ?>,
                    'content' => $this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'  => Html::button('ببند', ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']).
                            Html::a('ویرایش', ['update','<?= substr($actionParams,1) ?>'=><?= $actionParams ?>],
                                ['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];
        }else{
            return $this->render('view', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Creates a new <?= $modelClass ?> model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new <?= $modelClass ?>();

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'   => "افزودن به <?= $generator->tableTitle ?> تازه",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'  => Html::button('ببند', ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']).
                            Html::button('بنویس', ['class' => 'btn btn-primary', 'type' => 'submit'])

                ];
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload' => '#<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-datatable-pjax',
                    'title'       => "افزودن <?= $generator->tableTitle ?> تازه",
                    'content'     => '<span class="text-success">افزودن <?= $modelClass ?> موفق</span>',
                    'footer'      => Html::button('ببند', ['class' => 'btn btn-default pull-left','data-dismiss' => 'modal']).
                            Html::a('افزودن بیشتر', ['create'], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                ];
            }else{
                return [
                    'title'   => "افزودن <?= $generator->tableTitle ?> تازه",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'  => Html::button('ببند', ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']).
                            Html::button('بنویس', ['class' => 'btn btn-primary', 'type' => 'submit'])
                ];
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', <?= $urlParams ?>]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Updates an existing <?= $modelClass ?> model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return mixed
     */
    public function actionUpdate(<?= $actionParams ?>)
    {
        $request = Yii::$app->request;
        $model = $this->findModel(<?= $actionParams ?>);

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'   => "ویرایش <?= $generator->tableTitle ?> #" . $model-><?= $generator->getNameAttribute() ?>,
                    'content' =>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'  => Html::button('ببند', ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']).
                                Html::button('بنویس', ['class' => 'btn btn-primary', 'type' => 'submit'])
                ];
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload' => '#<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-datatable-pjax',
                    'title'       => "<?= $generator->tableTitle ?> #".<?= $actionParams ?>,
                    'content'     => $this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'      => Html::button('ببند', ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']).
                        Html::a('ویرایش', ['update', '<?= substr($actionParams,1) ?>' => <?= $actionParams ?>],
                            ['class' => 'btn btn-primary', 'role'=>'modal-remote']
                        )
                ];
            }else{
                 return [
                    'title'   => "ویرایش <?= $generator->tableTitle ?> #".<?= $actionParams ?>,
                    'content' =>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'  => Html::button('ببند',['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']).
                        Html::button('بنویس',['class' => 'btn btn-primary', 'type' => 'submit'])
                ];
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', <?= $urlParams ?>]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing <?= $generator->tableTitle ?> model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return mixed
     */
    public function actionDelete(<?= $actionParams ?>)
    {
        $request = Yii::$app->request;
        $this->findModel(<?= $actionParams ?>)->delete();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose' => true, 'forceReload' => '#<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
    }

     /**
     * Delete multiple existing <?= $modelClass ?> model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     *
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     *
     * @return mixed
     */
    public function actionBulkDelete()
    {
        $request = Yii::$app->request;
        $pks = explode(',', $request->post( 'pks' )); // Array or selected records primary keys
        foreach ( $pks as $pk ) {
            $model = $this->findModel($pk);
            $model->delete();
        }

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the <?= $modelClass ?> model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     *
     * @return <?=                   $modelClass ?> the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(<?= $actionParams ?>)
    {
<?php
if (count($pks) === 1) {
    $condition = '$id';
} else {
    $condition = [];
    foreach ($pks as $pk) {
        $condition[] = "'$pk' => \$$pk";
    }
    $condition = '[' . implode(', ', $condition) . ']';
}
?>
        if (($model = <?= $modelClass ?>::findOne(<?= $condition ?>)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('صفحه درخواست شده پیدا نشد.');
        }
    }
}
