#RelatedColumn
Documentation Edition: 1.1-971126
Class Version: 0.1.2-971126

RelatedColumn adds a column with Select2 filter and sort  a column in foreign key reference.
Required configurations are:
+ `class => '\khans\utils\columns\RelatedColumn',` 
+ `attribute` name of the field in child table referring the parent PK
+ `targetTable` model presenting the parent table
+ `titleField` name of field in parent table which should be used as the title of the parent records, and are shown in the child grid view and search is based on this parent column.
+ `value` a callback for showing the title in the child's grid as a link to parent grid view method
+ `group => true,` 
+ `searcherUrl` array to the action responsible for filtering the field. Defaults to `parents`

**_Example:_**
The suggested updates to various files are based on this partial table definition:

```mysql
CREATE TABLE `parent_table` (
  `id` SMALLINT(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) COLLATE UTF8_PERSIAN_CI NOT NULL
);
CREATE TABLE `child_table` (
  `id` SMALLINT(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id` SMALLINT(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  KEY `fk_parent_child` (`parent_id`),
   CONSTRAINT `fk_parent_child` FOREIGN KEY (`parent_id`) REFERENCES `parent_table` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);
```

child/_columns:
----------------
Define a RelatedColumn. But if the grid view is in the parent view page, drop the referencing column.
In order to ensure correct working of the ActionColumn links in both stand alone and view page, add the `controller` config to it.

`value` in the `RelatedColumn` column definition defaults to:
```php
function($model) {
    if(isset($model->parent)){
        return $model->parent->{$this->titleField};
    }
    return $model->{$this->attribute};
}
```
For the above default value to work properly, the child model should implement a relationship as:
```php
public function getParent(){
    return $this->hasOne(ParentModel::class, ['id' => 'parent_id']);
}
```
The following config, on the other hand, renders a link anchor to the parent view page.
 
```php
#19: //field showing the field referencing the parent
'parent' => [
    'class'          => '\khans\utils\columns\RelatedColumn',
    'attribute'      => 'parent_id', // in the child table
    'targetModel'    => '\namespace\ParentModel',
    'titleField'     => 'title', // in the parent table
    'value'          => function($model) {
        return \yii\helpers\Html::a($model->parent->title . '<i class="fa fa-external-link"></i>',
            ['/module/parent/view', 'id' => $model->parent_id],
            ['data-pjax' => 0, 'role' => '']
        );
    },
    'group'          => true,
    'hAlign'         => GridView::ALIGN_RIGHT,
    'vAlign'         => GridView::ALIGN_MIDDLE,
    'headerOptions'  => ['style' => 'text-align: center;'],
    'contentOptions' => ['class' => 'pars-wrap'],
],

#99: // add this to `ActionColumn` to ensure grid view works correctly in parent view and stand alone
'controller' => 'child/controller',

#102: // setting `$parent = true;` in the parent view drops the referencing column
if(isset($parent) and $parent){
    \khans\utils\components\ArrayHelper::remove($column, 'parent');
}
```

child/_form:
-------------
Instead of text input for the `parent_id` column, use `Select2` widget and read data from parent table. Please note that if the parent table has large number of records this approach is not recommended. Instead use AJAX data loader for the Select2 widget.

```php
#4:
use kartik\select2\Select2;

#21:
<?= $form->field($model, 'parent_id')->widget(Select2::class, [
    'theme' => Select2::THEME_BOOTSTRAP,
    'initValueText' => ArrayHelper::getValue(ParentModel::findOne($model->parent_id), 'parent_title'),
    'pluginOptions' => [
        'allowClear'         => true,
        'dir'                => 'rtl',
        'minimumInputLength' => 3,
        'ajax'               => [
            'url'      => Url::to(['parents']),
            'dataType' => 'json',
            'data'     => new JsExpression('function(params) { return {q:params.term}; }'),
        ],
    ],
]) ?>
```

parent/view:
------------
First build search model and data provider for the child grid view.
For best results set the sort of data to a static type.
Set `$parent = true;` to signal the child grid view to drop the referencing column to the parent.

```php
#14:
/* @var $model ParntModel */
$searchModel = new namespace\ChildModelSearch([ 
    'query'=> $model->getChildren()->orderBy(['title'=>SORT_ASC, 'id'=>SORT_ASC]),
]);
$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
$dataProvider->setSort(false);

$parent = true;

#55:
<div id="ajaxCrudDatatable">
    <?= khans\utils\widgets\GridView::widget([
        'id'                 => 'child-datatable-pjax',
        'dataProvider'       => $dataProvider,
        'filterModel'        => $searchModel,
        'columns'            => require(__DIR__.'/../child/_columns.php'),
        'export'             => true,
        'showRefreshButtons' => true,
        'bulkAction'         => [
            'action'  => 'bulk-delete',
            'label'   => 'پاک‌کن',
            'icon'    => 'trash',
            'class'   => 'btn btn-danger btn-xs',
            'message' => 'آیا اطمینان دارید همه را پا کنید؟',
        ],
        'createAction'       => [
            'ajax'    => true,
            'action'  => 'child/controller/create'
        ],
    ]) ?>
</div>
``` 
    
ChildController:
-----------------
The following action is target of the AJAX data loader in `RelatedColumn` filter.
Any child grid view containing `RelatedColumn` should have this method enabled in the child controller.
In the KHanS/Utils version 1.* these actions where centralized in a unique controller.
This approach eliminates requirement for adjusting the target of data loader, and at the same time all the related actions are gathered together.

```php
#259:
/**
 * Action for AJAX data loader of a Select2 filter in [[RelatedColumn]]
 *
 * @param string $q part of title/name field of the parent referee table
 *
 * @return array record found matching the requested parameter
 */
public function actionParents($q)
{
    \Yii::$app->response->format = Response::FORMAT_JSON;
    $out = ['results' => ['id' => '', 'text' => '']];
    $query = ParentModel::find()
        ->select(['id', 'text'=>''])
        ->where(['like', 'title', $q])
        ->orderBy(['title' => SORT_ASC,])
        ->asArray()
    ;
    $out['results'] = $query->all();

    return $out;
}
```
