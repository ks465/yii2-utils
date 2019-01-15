<?php
/**
 * This is the template for generating a User CRUD controller class file.
 *
 * @package khans\utils\generatedControllers
 * @version 0.1.2-971012
 * @since   1.0
 */

use yii\helpers\StringHelper;
use yii\db\ActiveRecordInterface;
use yii\helpers\Inflector;


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
use <?= StringHelper::dirname(ltrim($generator->modelClass, '\\')) ?>\PasswordResetRequestForm;
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
 * <?= $controllerClass ?> implements the CRUD actions for <?= $modelClass ?> User model.
 *
 * @package khans\utils\generatedControllers
 * @version 0.1.2-971012
 * @since   1.0
 */
class <?= $controllerClass ?> extends <?= StringHelper::basename($generator->baseControllerClass) . "\n" ?>
{
    /**
     * Lists all <?= $modelClass ?> User models.
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
     * Displays a single <?= $modelClass ?> User model.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     *
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView(<?= $actionParams ?>)
    {
        $request = Yii::$app->request;
        $model = $this->findModel(<?= $actionParams ?>);

        if(!$request->isAjax){
            throw new NotFoundHttpException('صفحه درخواست شده پیدا نشد.');
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'title'=> "<?= $generator->tableTitle ?> #" . $model->fullName,
                'content' => $this->renderAjax('view', [
                'model'   => $model,
            ]),
            'footer' => Html::button('ببند', ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) .
                Html::a('ویرایش', ['update', '<?= substr($actionParams,1) ?>' => <?= $actionParams ?>],
                    ['class' => 'btn btn-primary', 'role' => 'modal-remote']
            )
        ];
    }

    /**
     * Creates a new <?= $modelClass ?> User model.
     * Only accepts AJAX requests.
     *
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \yii\base\Exception
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;

        if(!$request->isAjax){
            throw new NotFoundHttpException('صفحه درخواست شده پیدا نشد.');
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = new <?= $modelClass ?>();
        $model->setScenario('profile');

        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $model->save(false);
                return [
                    'forceReload' => '#<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-pjax',
                    'title'       => "افزودن کاربر تازه به <?= $generator->tableTitle ?>",
                    'content'     => '<span class="text-success"> افزودن کاربر تازه به <?= $generator->tableTitle ?> انجام شد.</span>',
                    'footer'      => Html::button('ببند', ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) .
                        Html::a('افزودن بیشتر', ['create'], ['class' => 'btn btn-primary','role' => 'modal-remote'])
                ];
            }
        }

        return [
            'title'   => "افزودن کاربر تازه به <?= $generator->tableTitle ?>",
            'content' => $this->renderAjax('create', [
                'model' => $model,
            ]),
            'footer' => Html::button('ببند', ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) .
                Html::button('بنویس', ['class' => 'btn btn-primary', 'type' => 'submit'])
        ];
    }

    /**
     * Updates an existing <?= $modelClass ?> User model.
     * Only accepts AJAX requests.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     *
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \yii\base\Exception
     */
    public function actionUpdate(<?= $actionParams ?>)
    {
        $request = Yii::$app->request;

        if(!$request->isAjax){
            throw new NotFoundHttpException('صفحه درخواست شده پیدا نشد.');
        }

        if(0 == <?= $actionParams ?>){
            throw new NotFoundHttpException('صفحه درخواست شده پیدا نشد.');
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = $this->findModel(<?= $actionParams ?>);
        $model->setScenario('profile');

        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $model->save(false);
                return [
                    'forceReload' => '#<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-pjax',
                    'title'       => "<?= $generator->tableTitle ?> #" . $model->fullName,
                    'content'     => $this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'      => Html::button('ببند', ['class'=>'btn btn-default pull-left', 'data-dismiss' => 'modal']) .
                        Html::a('ویرایش', ['update', '<?= substr($actionParams,1) ?>' => <?= $actionParams ?>],
                            ['class' => 'btn btn-primary', 'role' => 'modal-remote']
                    ),
                ];
            }
        }

        return [
            'title'   => "ویرایش <?= $generator->tableTitle ?> #" . $model->fullName,
            'content' => $this->renderAjax('update', [
                'model' => $model,
            ]),
            'footer'  => Html::button('ببند', ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']).
                Html::button('بنویس', ['class' => 'btn btn-primary', 'type' => 'submit'])
        ];
    }

    /**
     * Edits an existing <?= $modelClass ?> User model and changes security attributes ['password_hash', 'access_token', 'password_reset_token'].
     * Only accepts AJAX requests.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     *
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \yii\base\Exception
     */
    public function actionResetPass($id)
    {
        $request = Yii::$app->request;

        if(!$request->isAjax){
            throw new NotFoundHttpException('صفحه درخواست شده پیدا نشد.');
        }

        if(0 == $id){
            throw new NotFoundHttpException('صفحه درخواست شده پیدا نشد.');
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = $this->findModel($id);
        $model->setScenario('resetPassword');
        $model->password_hash = '';

        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                if(empty($model->access_token)) {
                    $model->access_token = null;
                }else{
                    $model->generateAccessToken();
                }
                if(empty($model->password_hash)){
                    $model->password_hash = $model->oldAttributes['password_hash'];
                }else{
                    $model->setPassword($model->password_hash);
                }
                $model->save(false);
                return [
                    'forceReload' => '#sys-users-staff-pjax',
                    'title'=> "کارشناسان و مدیران ستادی #" . $model->fullName,
                    'content'     => $this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'      => Html::button('ببند', ['class'=>'btn btn-default pull-left', 'data-dismiss' => 'modal']) .
                        Html::a('ویرایش', ['reset-pass', 'id' => $id],
                            ['class'=>'btn btn-primary','role'=>'modal-remote']
                    ),
                ];
            }
        }

        return [
            'title'   => "ویرایش کارشناسان و مدیران ستادی #" . $model->fullName,
            'content' => $this->renderAjax('reset', [
                'model' => $model,
            ]),
            'footer'  => Html::button('ببند',['class'=>'btn btn-default pull-left','data-dismiss'=>'modal']).
                Html::button('بنویس',['class'=>'btn btn-primary','type'=>'submit'])
        ];
    }

    /**
     * Delete an existing <?= $modelClass ?> User model.
     * Only accepts AJAX requests.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     *
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionDelete(<?= $actionParams ?>)
    {
        $request = Yii::$app->request;

        if(!$request->isAjax){
            throw new NotFoundHttpException('صفحه درخواست شده پیدا نشد.');
        }

        $this->findModel(<?= $actionParams ?>)->delete();
        Yii::$app->response->format = Response::FORMAT_JSON;

        return ['forceClose' => true, 'forceReload' => '#<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-pjax'];
    }

    /**
     * Send a password reset token to the selected user.
     * Only accepts AJAX requests.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     *
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \yii\base\Exception
     */
    public function actionRequestReset(<?= $actionParams ?>)
    {
        $request = Yii::$app->request;

        if (!$request->isAjax) {
            throw new NotFoundHttpException('صفحه درخواست شده پیدا نشد.');
        }

        $model = $this->findModel(<?= $actionParams ?>);
        $pass = new PasswordResetRequestForm();
        $pass->email = $model->email;

        Yii::$app->response->format = Response::FORMAT_JSON;

        if ($pass->sendEmail()) {
            $result = '<div class="h4 text-success">' .
                '<p>' . '<i class="glyphicon glyphicon-ok"> </i> ' . 'ایمیل توکن بازیابی گذرواژه به نشانی ' . '</p>' .
                '<p class="ltr">' . '<strong class="ltr">' . $model->email . '</strong>' . '</p>' .
                '<p>' . ' فرستاده شد:' . '</p>' .
                '<p>' . $model->password_reset_token . '</p>' .
                '<p>' . 'زمان اعتبار: ' . intdiv(Yii::$app->params['user.passwordResetTokenExpire'],  3600) . ' ساعت.' . '</p>' .
                '</div>';
        } else {
            $result = '<div class="h4 text-danger">' .
                '<p>' . '<i class="glyphicon glyphicon-remove"> </i> ' . 'در زمان فرستادن ایمیل توکن بازیابی گذرواژه به نشانی ' . '</p>' .
                '<p class="ltr">' . '<strong class="ltr">' . $model->email . '</strong>' . '</p>' .
                '<p>' . ' مشکلی پیش آمد.' . '</p>' .
                '</div>';
        }

        return [
            'forceReload' => '#sys-users-staff-pjax',
            'title'       => "کارشناسان و مدیران ستادی #" . $model->fullName,
            'content'     => $result,
            'footer'      => Html::button('ببند', ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']),
        ];
    }

     /**
     * Delete multiple existing <?= $modelClass ?> User model.
     * Only accepts AJAX requests.
     *
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionBulkDelete()
    {
        $request = Yii::$app->request;

        if(!$request->isAjax){
            throw new NotFoundHttpException('صفحه درخواست شده پیدا نشد.');
        }
        Yii::$app->response->format = Response::FORMAT_JSON;

        $pks = explode(',', $request->post('pks')); // Array or selected records primary keys
        $counter = 0;
        foreach ($pks as $pk) {
            $model = $this->findModel($pk);
            if($model->delete() !== false){
                $counter++;
            }
        }

        return [
            'forceReload' => '#sys-users-applicant-pjax',
            'title'       => "افزودن کاربر تازه به داوطلبان ورود به دانشگاه",
            'content'     => '<span class="text-success">' .$counter . ' رکورد از ' . count($pks). ' انتخاب شده پاک شد.' . '</span>',
            'footer'      => Html::button('ببند', ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal'])
        ];
    }

    /**
     * Finds the <?= $modelClass ?> User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
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
