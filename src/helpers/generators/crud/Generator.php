<?php


namespace khans\utils\helpers\generators\crud;

use Yii;
use yii\gii\CodeFile;

/**
 * This generator will set defaults for the parent generator only.
 *
 * @package KHanS\Utils
 * @version 0.2.1-971020
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
     * @var string namespace for the data model classes in the unique case of creating authentication controller and actions.
     */
    public $authForms = '';

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

        ]);
    }

    /**
     * Add label for authForms attribute
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'authForms' => 'Namespace of the Authentication Forms',
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
}
