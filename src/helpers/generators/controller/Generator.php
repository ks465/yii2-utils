<?php


namespace khans\utils\helpers\generators\controller;

/**
 * This generator will set defaults for the parent generator only.
 *
 * @package KHanS\Utils
 * @version 0.2.0-971020
 * @since   1.0
 */
class Generator extends \yii\gii\generators\controller\Generator
{
    /**
     * @var string the base class of the controller
     */
    public $baseClass = 'khans\utils\controllers\KHanWebController';
    /**
     * @var string list of action IDs separated by commas or spaces
     */
    public $actions = 'index';
    /**
     * @var bool whether to wrap the `GridView` or `ListView` widget with the `yii\widgets\Pjax` widget
     * @since 2.0.5
     */
    public $enablePjax = true;

    /**
     * @return string name of the code generator
     */
    public function getName()
    {
        return 'KHan Controller Generator';
    }

    /**
     * @return string the detailed description of the generator.
     */
    public function getDescription()
    {
        return '<div class=" alert alert-info">' .
            'This generator helps you to quickly generate a new controller class with
            one or several controller actions and their corresponding views based on KHanWebController.' .
            '</div>';
    }
}
