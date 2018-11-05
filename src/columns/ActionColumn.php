<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 7/20/16
 * Time: 5:13 PM
 */


namespace KHanS\Utils\columns;


use kartik\helpers\Html;
use KHanS\Utils\components\Jalali;
use KHanS\Utils\models\KHanModel;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * Show column in grid views for actions on the data
 * Example:
 * ```php
 * ...
 *[
 * 'class' => '\common\widgets\columns\ActionColumn',
 * 'dropdown' => true, //optional defaults to false
 * 'audit' => true, //optional defaults to false
 *],
 * ...
 * ```
 * //disable pjax in ajaxview:
 * 'updateOptions' => [ //or viewOptions
 *      'title' => 'ویرایش',
 *      'data-toggle' => 'tooltip',
 * ],
 *
 * @package common\widgets
 * @version 1.0
 * @since   1.0
 */
class ActionColumn extends \kartik\grid\ActionColumn
{
    /**
     * @var boolean show helper for time and user responsible for creating and updating
     */
    public $audit = false;
    /**
     * @var string link to download action for the model
     */
    public $download = '';
    /**
     * @var string message to show as alert for deletion
     */
    public $deleteAlert = 'رکورد انتخاب شده پاک خواهد شد.';
    /**
     * @var bool set to true to use in non-AJAX delete request
     */
    public $disableDataMethod = false;

    public function init()
    {
        if (property_exists(Yii::$app->user, 'isSuperAdmin') && Yii::$app->user->isSuperAdmin) {
            $this->audit = true;
        }

        $this->hiddenFromExport = true;
        $this->vAlign = 'middle';

        if (empty($this->urlCreator)) {
            $this->urlCreator = function($action, $model, $key, $index) {
                if (is_array($key)) {
                    return Url::to([$action] + $key);
                }

                return Url::to([$action, 'id' => $key]);
            };
        }

        if (empty($this->viewOptions)) {
            $this->viewOptions = [
                'role'        => 'modal-remote',
                'title'       => 'تماشا',
                'data-toggle' => 'tooltip',
            ];
        }

        if (empty($this->updateOptions)) {
            $this->updateOptions = [
                'role'        => 'modal-remote',
                'title'       => 'ویرایش',
                'data-toggle' => 'tooltip',
            ];
        }

        $this->deleteOptions = [
            'role'         => 'modal-remote',
            'title'        => 'پاک‌کن',
            'data-confirm' => false,

            'data-request-method'  => 'post',
            'data-toggle'          => 'tooltip',
            'data-confirm-title'   => 'آیا اطمینان دارید؟',
            'data-confirm-message' => $this->deleteAlert,
        ];
        if (!$this->disableDataMethod) {
            $this->deleteOptions['data-method'] = false;
        }

        if ($this->dropdown) {
            $this->dropdownMenu = ['class' => 'text-right'];
            $this->viewOptions  ['label'] = '<span class="glyphicon glyphicon-eye-open"></span> تماشا';
            $this->updateOptions  ['label'] = '<span class="glyphicon glyphicon-pencil"></span> ویرایش';
            $this->deleteOptions  ['label'] = '<span class="glyphicon glyphicon-trash"></span> پاک‌کن';
        }
        if (!empty($this->download)) {
            $this->_download();
        }
        if ($this->audit) {
            $this->_audit();
        }

        parent::init();
    }

    /**
     * Show additional icon for downloading the relevant dat for the model
     * Given action is responsible for figuring how and what to download
     */
    private function _download()
    {
        $this->template .= ' {download}';

        $this->buttons['download'] = function($url, $model, $key) {
            $config = [
                'target'    => '_blank',
                'style'     => 'cursor: pointer;',
                'title'     => 'دریافت',
                'data-pjax' => '0',
            ];
            if ($this->dropdown) {
                $config['label'] = '<span class="glyphicon glyphicon-download-alt"></span> دریافت';

                return '<li>' .
                    Html::a($config['label'], $url, $config) .
                    '</li>';
            }

            return Html::a('<span class="glyphicon glyphicon-download-alt"></span>', $url, $config);
        };
    }

    /**
     * Show additional icon for monitoring the create/update time and person responsible
     */
    private function _audit()
    {
        $this->template .= ' {audit}';

        $this->buttons['audit'] = function($url, $model, $key) {
            $config = [
                'style'     => 'cursor: help;',
                'title'     => makePopoverContent($model),
                'data-pjax' => '0',
            ];
            if ($this->dropdown) {
                $config['label'] = '<span class="glyphicon glyphicon-time"></span> زمانها';

                return '<li>' .
                    Html::a($config['label'], false, $config) .
                    '</li>';
            }

            return Html::a('<span class="glyphicon glyphicon-time"></span>', false, $config);
        };
    }
}

/**
 * Build simple text showing the times and persons
 *
 * @param KHanModel $model
 *
 * @return string
 * @throws \Exception
 */
function makePopoverContent($model)
{
    if ($model instanceof KHanModel) {
        $creator = $model->getCreator($model)->fullName;
        $updater = $model->getUpdater($model)->fullName;

        $createTime = $model->created_at;
        $updateTime = $model->updated_at;
    } elseif (is_array($model)) {
        $creator = ArrayHelper::getValue($model, 'created_by', 'ثبت نشده');
        $updater = ArrayHelper::getValue($model, 'updated_by', 'ثبت نشده');

        $createTime = ArrayHelper::getValue($model, 'created_at', 0);
        $updateTime = ArrayHelper::getValue($model, 'updated_at', 0);
    } else {
        throw new \Exception('Model for ActionColumn should inherit ' . KHanModel::className());
    }


    $template = '{type}: {user} {time}';
    $out1 = str_replace('{type}', 'ساخت', $template);
    $out1 = str_replace('{user}', $creator, $out1);
    $out1 = str_replace('{time}',
        ($createTime == 0) ? 'زمان نامعین' : Jalali::date('Y/m/d H:i', $createTime), $out1);
    $out2 = str_replace('{type}', 'ویرایش', $template);
    $out2 = str_replace('{user}', $updater, $out2);
    $out2 = str_replace('{time}',
        ($updateTime == 0) ? 'زمان نامعین' : Jalali::date('Y/m/d H:i', $updateTime), $out2);

    return $out1 . "\n" . $out2;
}
