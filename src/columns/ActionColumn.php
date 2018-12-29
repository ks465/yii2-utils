<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 7/20/16
 * Time: 5:13 PM
 */


namespace khans\utils\columns;

use kartik\helpers\Html;
use khans\utils\components\Jalali;
use khans\utils\models\{KHanIdentity, KHanModel};
use Yii;
use yii\helpers\{ArrayHelper, Url};

/**
 * Show column in grid views for actions on the data.
 * It includes standard CRUD and custom methods.
 * See [ActionColumn Guide](guide:columns-action-column.md)
 *
 * @package common\widgets
 * @version 2.1.1-970904
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
    public $deleteAlert = 'از پاک نمودن این {item} اطمینان دارید؟';
    /**
     * @var bool set to true to use in non-AJAX action request
     */
    public $runAsAjax = false;
    /**
     * @var array List of other items to add to the ActionColumn
     * See [ActionColumn Guide](guide:columns-action-column.md) for details
     */
    public $extraItems = [];
    /**
     * @var string the header cell content. Note that it will not be HTML-encoded.
     */
    public $header = 'عملیات';

    /**
     * Build and configure the widget
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        if (property_exists(Yii::$app->user, 'isSuperAdmin') && Yii::$app->user->isSuperAdmin) {
            $this->audit = true;
        }

        $this->hiddenFromExport = true;
        $this->vAlign = 'middle';
        $this->hAlign = 'center';

        if (empty($this->urlCreator)) {
            $this->urlCreator = function($action, $model, $key, $index, $actionColumn) {
//if (!Helper::checkRoute($action)) {
//    return '';
//}
                if (is_array($key)) {
                    return Url::to([$action] + $key);
                }

                return Url::to([$action, 'id' => $key]);
            };
        }

        if (empty($this->viewOptions) || empty($this->viewOptions['runAsAjax'])) {
            $this->viewOptions = [
                'role'        => $this->runAsAjax ? 'modal-remote' : null,
                'title'       => 'تماشا',
                'data-toggle' => 'tooltip',
            ];
        } else {
            $this->viewOptions['role'] = $this->viewOptions['runAsAjax'] ? 'modal-remote' : null;
        }

        if (empty($this->updateOptions) || empty($this->updateOptions['runAsAjax'])) {
            $this->updateOptions = [
                'role'        => $this->runAsAjax ? 'modal-remote' : null,
                'title'       => 'ویرایش',
                'data-toggle' => 'tooltip',
            ];
        } else {
            $this->updateOptions['role'] = $this->updateOptions['runAsAjax'] ? 'modal-remote' : null;
        }

        $this->deleteOptions = [
            'role'                 => 'modal-remote',
            'title'                => 'پاک‌کن',
            'data-confirm'         => false, // for override default confirmation
            'data-method'          => false, // for override yii data api
            'data-request-method'  => 'post',
            'data-toggle'          => 'tooltip',
            'data-confirm-title'   => 'آیا اطمینان دارید؟',
            'data-confirm-message' => $this->deleteAlert,
        ];


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
        if (!empty($this->extraItems)) {
            $this->_extraItems();
        }

//        $this->template = Helper::filterActionColumn($this->template);

        parent::init();
    }

    /**
     * Show additional icon for downloading the relevant data for the model.
     * Given action is responsible for figuring how and what to be downloaded.
     */
    private function _download()
    {
//        if(!\Yii::$app->user->can('download')){
//            return;
//        }
        $this->template .= ' {download}';

        $this->buttons['download'] = function($url, $model, $key) {
            $config = [
                'target'    => '_blank',
                'style'     => 'cursor: pointer;',
                'title'     => 'دریافت',
                'role'      => 'modal-remote',
                'data-pjax' => '0',
            ];
            if ($this->dropdown) {
                $config['label'] = '<span class="glyphicon glyphicon-download-alt"></span> دریافت';

                return '<li>' .
                    Html::a($config['label'], $this->download, $config) .
                    '</li>';
            }

            return Html::a('<span class="glyphicon glyphicon-download-alt"></span>', $this->download, $config);
        };
    }

    /**
     * Show additional icon for monitoring the create/update time and person responsible
     */
    private function _audit()
    {
//        if(!\Yii::$app->user->can('audit')){
//            return;
//        }
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

    /**
     * If more keys and actions are required, Put them in [[extraItems]] property of the [[ActionColumn]]:
     * ```php
     * ...
     * 'extraItems' => [
     *     'name'=>[ //default action name and name in the template
     *     'title'=>'Test Me', //default menu title in dropdown or the tooltip of selection
     *     'icon'=>'edit', //glyphicon name default is link
     *     'action'=>'anAction', //action of the link
     *     'config'=>['class'=>'text-danger'], // configuring options of the link tag
     * ],
     * ```
     */
    private function _extraItems()
    {
        foreach ($this->extraItems as $title => $data) {
            if (is_integer($title) && empty($data)) {
                continue;
            }
//            if(!\Yii::$app->user->can($title)){
//                continue;
//            }
            $this->template .= ' {' . $title . '}';

            $this->buttons[$title] = function($url, $model, $key) use ($title, $data) {
                if (array_key_exists('icon', $data)) {
                    $icon = '<span class="glyphicon glyphicon-' . $data['icon'] . '"></span>';
                } else {
                    $icon = '<span class="glyphicon glyphicon-link"></span>';
                }
                if (array_key_exists('title', $data)) {
                    $data['config']['title'] = ucwords($data['title']);
                } else {
                    $data['config']['title'] = ucwords($title);
                }
                if (array_key_exists('action', $data)) {
                    $action = Url::to([$data['action']]);
                } else {
                    $action = $url; //Url::to([$title]);
                }

                if ($this->runAsAjax && ArrayHelper::getValue($data, 'runAsAjax') !== false) {
                    $data['config']['data-toggle'] = 'tooltip';
                    $data['config']['role'] = 'modal-remote';
                    $data['config']['data-pjax'] = '0';
                }
                if ($this->dropdown) {
                    $this->dropdownOptions = $data['config'];

                    return '<li>' . Html::a($icon . ' ' . ucwords($data['config']['title']), $action, $data['config']) . '</li>';
                }

                return Html::a($icon, $action, $data['config']);
            };
        }
    }
}

/**
 * Build simple text showing the times and persons committed inserting or editing
 *
 * @param KHanModel $model
 *
 * @return string
 * @throws \Exception
 */
function makePopoverContent($model)
{
    if ($model instanceof KHanModel) {
        try {
            $creator = $model->getCreator()->fullName;
        } catch (\Exception $e) {
            $creator = 'ناشناس';
        }
        try {
            $updater = $model->getUpdater()->fullName;
        } catch (\Exception $e) {
            $updater = 'ناشناس';
        }

        $createTime = $model->created_at;
        $updateTime = $model->updated_at;
    } elseif (is_array($model)) {
        $creator = ArrayHelper::getValue($model, 'created_by', 'ثبت نشده');
        $updater = ArrayHelper::getValue($model, 'updated_by', 'ثبت نشده');

        $createTime = ArrayHelper::getValue($model, 'created_at', 0);
        $updateTime = ArrayHelper::getValue($model, 'updated_at', 0);
    } else {
        throw new \Exception('Model for ActionColumn should inherit ' . KHanIdentity::className());
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
