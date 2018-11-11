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
use KHanS\Utils\models\KHanUser;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * Show column in grid views for actions on the data.
 * It includes standard CRUD and custom methods.
 * See [ActionColumn Guide](guide:columns-action-column.md)
 *
 * @package common\widgets
 * @version 0.1.0-950430
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
    /**
     * @var array List of other items to add to the ActionColumn
     *
     * See [ActionColumn Guide](guide:columns-action-column.md) for details
     */
    public $extraItems = [];

    /**
     * Build and configure the widget
     */
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
        if (!empty($this->extraItems)) {
            $this->_extraItems();
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
     * If more keys and actions are required, Put them in [[extraItems]] property of the [[actionColumn]]:
     *
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
                    $action = Url::to([$title]);
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
 * @param KHanUser $model
 *
 * @return string
 * @throws \Exception
 */
function makePopoverContent($model)
{
    if ($model instanceof KHanUser) {
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
        throw new \Exception('Model for ActionColumn should inherit ' . KHanUser::className());
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
