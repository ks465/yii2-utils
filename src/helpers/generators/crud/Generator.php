<?php


namespace khans\utils\helpers\generators\crud;

use khans\utils\components\StringHelper;
use khans\utils\tools\models\SysEavAttributes;
use Yii;
use yii\db\Query;
use yii\gii\CodeFile;
use yii\helpers\Inflector;

/**
 * This generator will set defaults for the parent generator only.
 *
 * @package KHanS\Utils
 * @version 0.4.0-971122
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
     * @throws \yii\base\InvalidConfigException
     */
    public function generate()
    {
        if (empty($this->tableTitle)) {
            $this->tableTitle = $this->getTableComment();
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

        return parent::generateActiveField($attribute);
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

        $comment = $query->from('INFORMATION_SCHEMA.TABLES')
            ->select(['table_comment'])
            ->where(['table_name' => $tableName])
            ->scalar();

        return $comment ? : Inflector::humanize($tableName, true);
    }
}
