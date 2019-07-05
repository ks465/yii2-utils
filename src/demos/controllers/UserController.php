<?php

namespace khans\utils\demos\controllers;

use Yii;
use khans\utils\demos\data\{SysUsers, SysUsersSearch};
use yii\data\ActiveDataProvider;
use yii\web\{NotFoundHttpException, Response};
use yii\helpers\Html;
use app\models\system\PasswordResetRequestForm;

/**
 * UserController implements the CRUD actions for SysUsers model.
 *
 * @package khans\utils\generatedControllers
 * @version 0.2.0-971111
 * @since   1.0
 */
class UserController extends KHanWebController
{
    /**
     * Lists all SysUsers models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SysUsersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SysUsers model.
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);

       if(!$request->isAjax){
            throw new NotFoundHttpException('دسترسی مستقیم به این برگه مجاز نیست.');
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'title'=> "کاربران سامانه #" . $model->fullName,
                'content' => $this->renderAjax('view', [
                'model'   => $model,
            ]),
            'footer' => Html::button('ببند', ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) .
                Html::a('ویرایش', ['update', 'id' => $id],
                    ['class' => 'btn btn-primary', 'role' => 'modal-remote']
            )
        ];
    }

    /**
     * Creates a new SysUsers model.
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
            throw new NotFoundHttpException('دسترسی مستقیم به این برگه مجاز نیست.');
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = new SysUsers();
        $model->setScenario('profile');

        if($request->isPost){
            $model->load($request->post());
            $model->generateAuthKey();
            if($model->validate()){
                $model->save(false);
                return [
                    'forceReload' => '#sys-users-pjax',
                    'title'       => "افزودن کاربر تازه به سامانه",
                    'content'     => '<span class="text-success"> افزودن کاربر تازه به سامانه انجام شد.</span>',
                    'footer'      => Html::button('ببند', ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) .
                        Html::a('افزودن بیشتر', ['create'], ['class' => 'btn btn-primary','role' => 'modal-remote'])
                ];
            }
        }

        return [
            'title'   => "افزودن کاربر تازه به سامانه",
            'content' => '<pre>' . print_r($model->attributes , true) . '</pre>' . $this->renderAjax('create', [
                'model' => $model,
            ]),
            'footer' => Html::button('ببند', ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']) .
                Html::button('بنویس', ['class' => 'btn btn-primary', 'type' => 'submit'])
        ];
    }

    /**
     * Updates an existing SysUsers model.
     * Only accepts AJAX requests.
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \yii\base\Exception
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;

       if(!$request->isAjax){
            throw new NotFoundHttpException('دسترسی مستقیم به این برگه مجاز نیست.');
        }

        if(0 == $id){
            throw new NotFoundHttpException('صفحه درخواست شده پیدا نشد.');
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = $this->findModel($id);
        $model->setScenario('profile');

        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $model->save(false);
                return [
                    'forceReload' => '#sys-users-pjax',
                    'title'       => "ویرایش کاربر سامانه #" . $model->fullName,
                    'content'     => $this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'      => Html::button('ببند', ['class'=>'btn btn-default pull-left', 'data-dismiss' => 'modal']) .
                        Html::a('ویرایش', ['update', 'id' => $id],
                            ['class' => 'btn btn-primary', 'role' => 'modal-remote']
                    ),
                ];
            }
        }

        return [
            'title'   => "ویرایش کاربر سامانه #" . $model->fullName,
            'content' => $this->renderAjax('update', [
                'model' => $model,
            ]),
            'footer'  => Html::button('ببند', ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']).
                Html::button('بنویس', ['class' => 'btn btn-primary', 'type' => 'submit'])
        ];
    }

    /**
     * Edits an existing SysUsers model and changes security attributes ['password_hash', 'access_token', 'password_reset_token'].
     * Only accepts AJAX requests.
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \yii\base\Exception
     */
    public function actionResetPass($id)
    {
        $request = Yii::$app->request;

        if(!$request->isAjax){
            throw new NotFoundHttpException('دسترسی مستقیم به این برگه مجاز نیست.');
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
            }
        }

        return [
            'forceReload' => '#sys-users-pjax',
            'title'   => "ویرایش گذرواژه کاربر سامانه #" . $model->fullName,
            'content' => $this->renderAjax('reset', [
                'model' => $model,
            ]),
            'footer'  => Html::button('ببند',['class'=>'btn btn-default pull-left','data-dismiss'=>'modal']).
                Html::button('بنویس',['class'=>'btn btn-primary','type'=>'submit'])
        ];
    }

    /**
     * Delete an existing SysUsers model.
     * Only accepts AJAX requests.
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;

       if(!$request->isAjax){
            throw new NotFoundHttpException('دسترسی مستقیم به این برگه مجاز نیست.');
        }

        $this->findModel($id)->delete();
        Yii::$app->response->format = Response::FORMAT_JSON;

        return ['forceClose' => true, 'forceReload' => '#sys-users-pjax'];
    }

    /**
     * Send a password reset token to the selected user.
     * Only accepts AJAX requests.
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \yii\base\Exception
     */
    public function actionRequestReset($id)
    {
        $request = Yii::$app->request;

        if (!$request->isAjax) {
            throw new NotFoundHttpException('صفحه درخواست شده پیدا نشد.');
        }

        $model = $this->findModel($id);
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
            'forceReload' => '#sys-users-pjax',
            'title'       => "فرستادن ایمیل توکن بازیابی کاربر سامانه #" . $model->fullName,
            'content'     => $result,
            'footer'      => Html::button('ببند', ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal']),
        ];
    }

     /**
     * Delete multiple existing SysUsers model.
     * Only accepts AJAX requests.
     *
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionBulkDelete()
    {
        $request = Yii::$app->request;

       if(!$request->isAjax){
            throw new NotFoundHttpException('دسترسی مستقیم به این برگه مجاز نیست.');
        }
        Yii::$app->response->format = Response::FORMAT_JSON;

        $pks = explode(',', $request->post('pks')); // Array or selected records primary keys
        $counter = 0;
        foreach ($pks as $pk) {
            if($pk <= 1){ // Do not change system user and admin user in bulk mode
                continue;
            }
            $model = $this->findModel($pk);
            if($model->delete() !== false){
                $counter++;
            }
        }

        return [
            'forceReload' => '#sys-users-pjax',
            'title'       => 'پاک کردن شناسه کاربران',
            'content'     => '<span class="text-success">' . 'شناسه ' .$counter . ' نفر از ' . count($pks). ' کاربر انتخاب شده پاک شد.' . '</span>',
            'footer'      => Html::button('ببند', ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal'])
        ];
    }

    /**
     * Show history of login attempts for the given user
     *
     * @param integer $id
     *
     * @return array AJAX grid view of login history
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionAudit($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = $this->findModel($id);
        $dataProvider = new ActiveDataProvider(['query' => $model->getLoginHistory()]);

        return [
            'title'   => " #" . $model->id,
            'content' => $this->renderAjax('@khan/tools/views/history-users/record', [
                'dataProvider' => $dataProvider,
            ]),
            'footer'  => Html::button('ببند', ['class' => 'btn btn-default pull-left', 'data-dismiss' => 'modal'])
        ];
    }

    /**
     * Finds the SysUsers model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SysUsers the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SysUsers::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('صفحه درخواست شده پیدا نشد.');
        }
    }
}
