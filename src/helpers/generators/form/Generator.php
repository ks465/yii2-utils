<?php


namespace khans\utils\helpers\generators\form;

use Yii;
use yii\gii\CodeFile;

/**
 * This generator will set defaults for the parent generator only.
 *
 * @package KHanS\Utils
 * @version 0.2.1-971020
 * @since   1.0
 */
class Generator extends \yii\gii\generators\form\Generator
{
    /**
     * @return string name of the code generator
     */
    public function getName()
    {
        return 'KHan Form Generator';
    }

    /**
     * @return string the detailed description of the generator.
     */
    public function getDescription()
    {
        return '<div class=" alert alert-info">' .
            'This generator generates a view script file that displays a form to collect input for the specified model class.' .
            '</div>';
    }

    /**
     * Parent method does not create the action file
     */
    public function generate()
    {
        $files = [];
        $files[] = new CodeFile(
            Yii::getAlias($this->viewPath) . '/' . $this->viewName . '.php',
            $this->render('form.php')
        );
        $files[] = new CodeFile(
            Yii::getAlias($this->viewPath) . '/' . $this->viewName . '-action.php',
            $this->render('action.php')
        );

        return $files;
    }
}
