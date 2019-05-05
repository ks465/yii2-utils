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
use khans\utils\models\{KHanModel};
use Yii;
use yii\helpers\{ArrayHelper, Url};

/**
 * Show column in grid views for actions on the data.
 * It includes standard CRUD and custom methods.
 * See [ActionColumn Guide](guide:columns-action-column.md)
 *
 * @package common\widgets
 * @version 2.5.1-980215
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
        if (isset(Yii::$app->user->isSuperAdmin) and Yii::$app->user->isSuperAdmin) {
            $this->audit = true;
        }

        $this->hiddenFromExport = true;
        $this->vAlign = 'middle';
        $this->hAlign = 'center';

        if (empty($this->viewOptions)) {
            $this->viewOptions = [
                'role'        => $this->runAsAjax ? 'modal-remote' : null,
                'title'       => 'تماشا',
                'data-toggle' => 'tooltip',
            ];
        }
        if (isset($this->viewOptions['runAsAjax'])) {
            $this->viewOptions['role'] = $this->viewOptions['runAsAjax'] ? 'modal-remote' : null;
        }

        if (empty($this->updateOptions)) {
            $this->updateOptions = [
                'role'        => $this->runAsAjax ? 'modal-remote' : null,
                'title'       => 'ویرایش',
                'data-toggle' => 'tooltip',
            ];
        }
        if (isset($this->updateOptions['runAsAjax'])) {
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

        if (!empty($this->download)) {
            $this->_download();
        }
        if ($this->audit) {
            $this->_audit();
        }

        if (!empty($this->extraItems)) {
            $this->_extraItems();
        }

        if ($this->dropdown) {
            $this->dropdownMenu = ['class' => 'text-right']; // instead of dropdown-menu-right use this to avoid horizontal scrolling
            $this->viewOptions  ['label'] = '<span class="text-primary">' . '<i class="glyphicon glyphicon-eye-open"></i> تماشا' . '</span>';
            $this->updateOptions  ['label'] = '<span class="text-primary">' . '<i class="glyphicon glyphicon-pencil"></i> ' . 'ویرایش' . '</span>';
            $this->deleteOptions  ['label'] = '<span class="text-primary">' . '<i class="glyphicon glyphicon-trash"></i> ' . 'پاک‌کن' . '</span>';
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

        if (strpos($this->template, '{download}') === false) {
            $this->template .= ' {download}';
        }

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
                    Html::a($config['label'], $url, $config) .
                    '</li>';
            }

            return Html::a('<span class="glyphicon glyphicon-download-alt"></span>', $url, $config);
        };
    }

    /**
     * Show additional icon for monitoring the history of changes in the record
     */
    private function _audit()
    {
//        if(!\Yii::$app->user->can('audit')){
//            return;
//        }
        if (strpos($this->template, '{audit}') === false) {
            $this->template .= ' {audit}';
        }

        $this->buttons['audit'] = function($url, $model, $key) {
            $config = [
                'data-toggle' => 'tooltip',
                'style'       => 'cursor: pointer;',
                'title'       => makePopoverContent($model),
                'role'        => 'modal-remote',
                'data-pjax'   => '0',
            ];
            if ($this->dropdown) {
                $config['label'] = '<span class="glyphicon glyphicon-film"></span> تاریخچه';
                $this->dropdownOptions = $config;

                return '<li>' .
                    Html::a($config['label'], $url, $config) .
                    '</li>';
            }

            return Html::a('<span class="glyphicon glyphicon-film"></span>', $url, $config);
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

            if (strpos($this->template, '{' . $title . '}') === false) {
                $this->template .= ' {' . $title . '}';
            }

            $this->buttons[$title] = function($url, $model, $key) use ($title, $data) {
                if (array_key_exists('disabled', $data)) {
                    if (is_bool($data['disabled']) and $data['disabled'] === true) {
                        $_action = false;
                        $data['icon'] = 'ban-circle text-muted';
                    } elseif ($data['disabled'] instanceof \Closure) {
                        $_action = !call_user_func($data['disabled'], $model, $key, $this);
                        $data['icon'] = $_action ? $data['icon'] : 'ban-circle text-muted';
                    }
                } else {
                    $_action = true;
                }
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
                    $action = $data['action'];
                } else {
                    $action = $title;
                }

                $params = is_array($key) ? $key : ['id' => (string)$key];
                $params[0] = $this->controller ? $this->controller . '/' . $action : $action;

                if (isset($data['method'])) {
                    $data['config']['data-request-method'] = $data['method'];
                } else {
                    $data['config']['data-request-method'] = 'post';
                }

                $data['config']['data-confirm'] = false; // for override default confirmation
                $data['config']['data-method'] = false; // for override yii data api

                if ($this->runAsAjax or ArrayHelper::getValue($data, 'runAsAjax') !== false) {
                    $data['config']['data-toggle'] = 'tooltip';
                    $data['config']['role'] = 'modal-remote';
                    $data['config']['data-pjax'] = '0';

                    if (isset($data['confirm'])) {
                        if ($data['confirm'] === true) {
                            $data['config']['data-confirm-title'] = 'آیا اطمینان دارید؟';
                            $data['config']['data-confirm-message'] = 'از انجام این گزینه اطمینان دارید؟';
                        } else {
                            $data['config']['data-confirm-title'] = $data['confirm']['title'];
                            $data['config']['data-confirm-message'] = $data['confirm']['message'];
                        }
                    }
                }
                if ($_action === false) {
                    $data['config']['title'] .= ' -- ' . (isset($data['disabledComment']) ? $data['disabledComment'] : 'Disabled');
                    if ($this->dropdown) {
                        $this->dropdownOptions = $data['config'];

                        return '<li>' . Html::tag('a', $icon . ' ' . ucwords($data['config']['title'])) . '</li>';
                    }

                    return Html::tag('span', $icon);
                }
                if ($this->dropdown) {
                    $this->dropdownOptions = $data['config'];

                    return '<li>' . Html::a(
                            '<span class="text-primary">' . $icon . ' ' . ucwords($data['config']['title']) . '</span>',
                            Url::toRoute($params), $data['config']) . '</li>';
                }

                return Html::a($icon, Url::toRoute($params), $data['config']);
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
            if (is_null($model->created_by)) {
                $creator = 'ناشناس';
            } else {
                $creator = $model->getCreator()->fullName;
            }
        } catch (\Exception $e) {
            $creator = 'ناشناس';
        }
        try {
            if (is_null($model->updated_by)) {
                $updater = 'ناشناس';
            } else {
                $updater = $model->getUpdater()->fullName;
            }
        } catch (\Exception $e) {
            $updater = 'ناشناس';
        }

        try {
            $createTime = $model->created_at;
        } catch (\Exception $e) {
            $createTime = 0;
        }
        try {
            $updateTime = $model->updated_at;
        } catch (\Exception $e) {
            $updateTime = 0;
        }

    } elseif (is_array($model)) {
        $creator = ArrayHelper::getValue($model, 'created_by', 'ثبت نشده');
        $updater = ArrayHelper::getValue($model, 'updated_by', 'ثبت نشده');

        $createTime = ArrayHelper::getValue($model, 'created_at', 0);
        $updateTime = ArrayHelper::getValue($model, 'updated_at', 0);
    } else {
        throw new \Exception('Model for ActionColumn should inherit ' . KHanModel::class);
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
