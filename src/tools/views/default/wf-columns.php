<?php

use \khans\utils\{
    components\ArrayHelper,
    widgets\GridView
};
use \raoul2000\workflow\base\Status;
use khans\utils\components\workflow\KHanWorkflowHelper;

$columns = [
    'id'             => [
        'class'          => '\khans\utils\columns\DataColumn',
        'attribute'      => 'id',
        'label'          => 'کلید',
        'width'          => '100px',
        'hAlign'         => GridView::ALIGN_LEFT,
        'vAlign'         => GridView::ALIGN_MIDDLE,
        'contentOptions' => ['class' => 'ltr'],
        'headerOptions'  => ['style' => 'text-align: center;'],
    ],
    'label'          => [
        'class'         => '\khans\utils\columns\DataColumn',
        'attribute'     => 'label',
        'label'         => 'عنوان کوتاه',
        'width'         => '200px',
        'hAlign'        => GridView::ALIGN_RIGHT,
        'vAlign'        => GridView::ALIGN_MIDDLE,
        'headerOptions' => ['style' => 'text-align: center;'],
    ],
    [
        'attribute'      => 'metadata.description',
        'label'          => 'عنوان بلند',
        'width'          => '300px',
        'hAlign'         => GridView::ALIGN_RIGHT,
        'vAlign'         => GridView::ALIGN_MIDDLE,
        'headerOptions'  => ['style' => 'text-align: center;'],
        'contentOptions' => ['class' => 'pars-wrap'],
    ],
    'transition'     => [
        'class'     => '\khans\utils\columns\DataColumn',
        'attribute' => 'transition',
        'label'     => 'مرحله‌های مجاز',
        'value'     => function(Status $model) {
            return implode(', ', array_keys($model->transitions));
        },
        'width'          => '200px',
        'hAlign'         => GridView::ALIGN_LEFT,
        'vAlign'         => GridView::ALIGN_MIDDLE,
        'contentOptions' => ['class' => 'ltr'],
        'headerOptions'  => ['style' => 'text-align: center;'],
    ],
    'email'  => [
        'class'     => '\khans\utils\columns\DataColumn',
        'attribute' => 'metadata.email',
        'label'     => 'ایمیل شود',
        'value'     => function(Status $model) {
            return KHanWorkflowHelper::getEmailTemplate($model) ?? 'هیچ ایمیلی فرستاده نمی‌شود';
//             $email = ArrayHelper::getValue($model, 'metadata.email', false);
//             if (is_bool($email)) {
//                 return $email ? 'متن پیش‌فرض فرستاده می‌شود' . '<strong class="text-danger">*</strong>' : 'هیچ ایمیلی فرستاده نمی‌شود';
//             }
//             return $email;
        },
        'width'         => '250px',
        'format'        => 'html',
        'hAlign'        => GridView::ALIGN_RIGHT,
        'vAlign'        => GridView::ALIGN_MIDDLE,
        'headerOptions' => ['style' => 'text-align: center;'],
    ],
    'actor' => [
        'class'         => '\khans\utils\columns\DataColumn',
        'attribute'     => 'metadata.actor',
        'width'         => '100px',
        'label'         => 'مسئول',
        'hAlign'        => GridView::ALIGN_LEFT,
        'vAlign'        => GridView::ALIGN_MIDDLE,
        'headerOptions' => ['style' => 'text-align: center;'],
    ],
];

return $columns;
