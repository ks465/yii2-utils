<?php


namespace khans\utils\helpers\generators\crud;

use Yii;
use yii\db\Query;
use yii\gii\CodeFile;
use yii\helpers\Inflector;

/**
 * This generator will set defaults for the parent generator only.
 *
 * @package KHanS\Utils
 * @version 0.5.0-980202
 * @since   1.0
 */
class Generator extends \yii\gii\generators\crud\Generator
{
    /**
     * @var string FQN for the base controller which the generated controller extends
     */
    public $baseControllerClass = 'khans\utils\controllers\KHanWebController';
    /**
     * @var string Title of the pages, which presumably is the comment of the database table.
     */
    public $tableTitle;
    /**
     * @var string namespace for the data model classes in the unique case of creating authentication controller and
     *     actions.
     */
    public $authForms = '';
    /**
     * @var bool activate EAV pattern for the model and actions
     */
    public $enableEAV = false;

    /**
     * @var string View path of the children model in the Parent-Child Pattern
     */
    public $childControllerId = '';
    public $parentControllerId = '';
    public $childColumnsPath = '';
    public $childLinkFields='';
    public $childSearchModelClass='';
    /**
     * @return string name of the code generator
     */
    public function getName()
    {
        return 'KHan CRUD Generator';
    }

    /**
     * @return string the detailed description of the generator.
     */
    public function getDescription()
    {
        return '<div class=" alert alert-info">' .
            'This generator generates a controller and views that implement CRUD (Create, Read, Update, Delete)
            operations for the specified data model.' .
            'There is two general use templates and two special case templates:' .
            '<ul>' .
            '<li>' . '<code>default (giiCrudAjax)</code> ' .
            'Generates general-use controller and actions and enables PJAX modal views.' .
            '</li>' .
            '<li>' . '<code>giiCrudList</code> ' .
            'Generates general-use controller and actions and normal views.' .
            '</li>' .
            '<li>' . '<code>giiCrudRead</code> ' .
            'Generates read-only controller and views.' .
            '</li>' .
            '<li>' . '<code>giiCrudUser</code> ' .
            'Generates controller and actions for user management.' .
            '</li>' .
            '<li>' . '<code>giiCrudAuth</code> ' .
            'Generates authentication views and actions.' .
            '</li>' .
            '</ul>' .
            '</div>';
    }

    /**
     * Add rule for authForms attribute
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['authForms'], 'filter', 'filter' => function($value) { return trim($value, '\\'); }],
            [['enableEAV'], 'boolean'],
        ]);
    }

    /**
     * Add label for authForms attribute
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'authForms' => 'Namespace of the Authentication Forms',
            'enableEAV' => 'Enable EAV pattern',
        ]);
    }

    /**
     * Add hint for authForms attribute
     */
    public function hints()
    {
        return array_merge(parent::hints(), [
            'authForms' => 'If the template is <code>giiCrudAuth</code>, the generator can generate models for authentications forms
(LoginForm, PasswordResetRequestForm, ResetPasswordForm, SignupForm). If you have already these model leave this box empty. If you need
These authentication validation models to be created, set the namespace of the created models here.',
            'enableEAV' => 'If the given model is designed using EAV pattern, enabling this option adds <code>the attributes</code> to the CRUD pages.',
        ]);
    }

    /**
     * Generates the code based on the current user input and the specified code template files.
     *
     * @return CodeFile[] a list of code files to be created.
     */
    public function generate()
    {
        if (empty($this->tableTitle)) {
            if(!empty($this->modelClass::getTableComment())){
                $this->tableTitle = $this->modelClass::getTableComment();
            }else{
                $this->tableTitle = $this->getTableComment();
            }
        }

        $files = parent::generate();

        if (!empty($this->authForms)) {
            $modelsPath = Yii::getAlias('@' . str_replace('\\', '/', $this->authForms));
            $files[] = new CodeFile($modelsPath . '/LoginForm.php',
                $this->render('models/LoginForm.php')
            );
            $files[] = new CodeFile($modelsPath . '/PasswordResetRequestForm.php',
                $this->render('models/PasswordResetRequestForm.php')
            );
            $files[] = new CodeFile($modelsPath . '/ResetPasswordForm.php',
                $this->render('models/ResetPasswordForm.php')
            );
            $files[] = new CodeFile($modelsPath . '/SignupForm.php',
                $this->render('models/SignupForm.php')
            );
        }

        return $files;
    }

    /**
     * Generates customized code for active field when database column type is bit, which translates to PHP boolean
     * type. Otherwise pass control to parent class to generate codes.
     *
     * @param string $attribute name of attribute to process
     *
     * @return string form input element
     */
    public function generateActiveField($attribute)
    {
        $tableSchema = $this->getTableSchema();
        $column = $tableSchema->columns[$attribute];
        if ($column->phpType === 'boolean') {
            return "\$form->field(\$model, '$attribute', [
                'template'     => '{input} {label}{error}{hint}',
            ])->widget(CheckboxX::class, [
                'autoLabel' => false,
                'pluginOptions' => [
                    'threeState' => false,
                ],
            ]);";
        }
        if (defined($this->modelClass . '::THIS_TABLE_ROLE') and $this->modelClass::THIS_TABLE_ROLE == 'ROLE_CHILD' and in_array($attribute, $this->modelClass::getLinkFields())){
            return "\$form->field(\$model, '$attribute')->widget(\kartik\select2\Select2::class, [
            'initValueText' => \$model->getParentTitle(),
            'hideSearch'    => false,
            'pluginOptions' => [
                'dropdownParent' => new yii\web\JsExpression('$(\"#ajaxCrudModal .modal-body\")'), // make sure search element of Select2 is working in modal dialog
                'allowClear'         => false,
                'dir'                => 'rtl',
                'minimumInputLength' => 3,
                'ajax'               => [
                    'url'      => Url::to(['parents-list']),
                    'dataType' => 'json',
                    'data'     => new JsExpression('function(params) { return {q:params.term}; }'),
                ],
            ],
            ]);";
        }
        return parent::generateActiveField($attribute);
    }


    /**
     * Correct the conditions to include `$this->query` instead of `$query`
     *
     * @return array|void
     */
    public function generateSearchConditions()
    {
        $conditions = parent::generateSearchConditions();
        $conditions = str_replace('$query', '$this->query', $conditions);

        return $conditions;
    }

    /**
     * If title is not given in the config, produce it from comment of the table in database.
     * If comment is not available return Table Name
     *
     * @return string
     */
    private function getTableComment()
    {
        $tableName = $this->getTableSchema()->fullName;
        $query = new Query();

        if (Yii::$app->db->driverName === 'mysql') {
            $comment = $query->from('INFORMATION_SCHEMA.TABLES')
                ->select(['table_comment'])
                ->where(['table_name' => $tableName])
                ->scalar();
        } elseif (Yii::$app->db->driverName === 'pgsql') {
            $comment = $query->from('pg_description')
                ->select(['description'])
                ->innerJoin('pg_class', '{{pg_description}}.[[objoid]] = {{pg_class}}.[[relnamespace]]')
                ->where(['relname' => $tableName])
                ->scalar();
        } else {
            $comment = false;
        }

        return $comment ? : Inflector::humanize($tableName, true);
    }
}
