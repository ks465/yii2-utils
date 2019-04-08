#Generators
Documentation Edition: 1.3-980119
Class Version: 0.5.0-980119

`Yii2` comes with a handful of good generators for agile development. In addition to that, `johnitvn/yii2-ajaxcrud` has a very beautiful AJAX modal CRUD system.
So these generators are mostly useful for setting some defaults.

##Form Generator
Yii2 Form Generator only creates a view file for the given model. This version generates a very basic action file and a view containing a `kartik\form\ActiveForm`.

##Model Generators
+ `Default`: This generator is basically the same as the Yii version, except for the model base class and content of the query. The base class for the model is `khans\utils\models\KHanModel`. The query contains an empty body. 
+ `Eav`: This generator adds [EavBehavior] to model and [EavQueryTrait] to the accompanied query for EAV pattern.

##Controller Generator
This generator is basically the same as the Yii version, except for the controller base class. The base class for the model is `\khans\utils\controllers\KHanWebController`.

##CRUD Generators
By setting `Enable EAV Pattern` the generated pages have extra required codes to manipulate EAV values flawlessly as genuine attributes of the model itself. At this time, sorting by EAV attributes is not implemented.
This generator has four templates:
+ `Default (giiCrudAjax)`: Generates an AJAX CRUD similar to `johnitvn/yii2-ajaxcrud`.
  - `controller` in this template has very little changes. Persian content, plus PJAX container ID depending the controller name.
  - `_columns` has `\khans\utils\columns\ActionColumn` for ActionColumn, and `status`, `created_at`, and `updated_at` have their tuned columns.
  - `_form` has specific form field for `status`, `created_at`, and `updated_at` attributes and `kartik\form\ActiveForm` as `form` element.
  - `index` has `khans\utils\widgets\GridView` and PJAX id based on the controller.
  - `_view` has specific form fields for `status`, `created_at`, and `updated_at` attributes.
  
+ `giiCrudList`: Generates a typical CRUD similar to `yii\gii\generators\crud\Generator`.
+ `giiCrudRead`: Generates a read-only index with modal view page. There is not any actions for create, update, or delete records.
+ `giiCrudUser`: Generates an AJAX CRUD based on `giiCrudAjax` specially designed to manger user tables.
+ `giiCrudAuth`: Generates a normal CRUD based on `giiCrudList` for authentication tasks. This template has the option to generate form models (LoginForm, PasswordResetRequestForm, ResetPasswordForm, SignupForm) for authentication.
 
 
The `search` model in the above templates (giiCurdAuth has not any search model, of course) has a class attribute for `$query` so the query can be set in the instantiating time to a desired filtered one, or let it be set to the old model by default.
```php
$searchModel = new namespace\ModelSearch(); //behaves as the original search model.
```

Now imagine two related tables `Users` and `BooksRead`. In the parent table `Users` view you can add the following:
```php
$searchBooksRead = new namespace\BooksReadSearch(['query'=> $UsersModel->getBooksRead()]);
$dataProvider = $searchBooksRead->search(Yii::$app->request->queryParams);
khans\utils\widgets\GridView::widget([
    'id'                 => 'books-read-datatable-pjax',
    'dataProvider'       => $dataProvider,
    'filterModel'        => $searchBooksRead,
    ...
]);
```
The result is a list for a given record in `Users` table and below it a grid view containing all the records in `BooksRead` for the user.

**_enableEAV_** in the CRUD generator lets the created `_columns`, `view`, and `_form` utilize EAV pattern for a model which is already designed for this pattern.
