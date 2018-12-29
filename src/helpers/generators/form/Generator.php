<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */


namespace khans\utils\helpers\generators\form;

use Yii;
use yii\base\Model;
use yii\gii\CodeFile;

/**
 * This generator will generate an action view file based on the specified model class.
 *
 * @property array $modelAttributes List of safe attributes of [[modelClass]]. This property is read-only.
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Generator extends \yii\gii\Generator
{
    /**
     * @var string FQN for the model which this controller acts upon
     */
    public $modelClass;
    /**
     * @var string path to generated view files
     */
    public $viewPath = '@app/views';
    /**
     * @var string filename for the generated view
     */
    public $viewName;
    /**
     * @var string scenario of the model in the form
     */
    public $scenarioName;


    /**
     * @return string name of the code generator
     */
    public function getName()
    {
        return 'Form Generator';
    }

    /**
     * @return string the detailed description of the generator.
     */
    public function getDescription()
    {
        return 'This generator generates a view script file that displays a form to collect input for the specified model class.';
    }

    /**
     * Generates the code based on the current user input and the specified code template files.
     *
     * @return CodeFile[] a list of code files to be created.
     */
    public function generate()
    {
        $files = [];
        $files[] = new CodeFile(
            Yii::getAlias($this->viewPath) . '/' . $this->viewName . '.php',
            $this->render('form.php')
        );

        return $files;
    }

    /**
     * Returns the validation rules for attributes
     *
     * @return array validation rules
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['modelClass', 'viewName', 'scenarioName', 'viewPath'], 'filter', 'filter' => 'trim'],
            [['modelClass', 'viewName', 'viewPath'], 'required'],
            [
                ['modelClass'], 'match', 'pattern' => '/^[\w\\\\]*$/',
                                         'message' => 'Only word characters and backslashes are allowed.',
            ],
            [['modelClass'], 'validateClass', 'params' => ['extends' => Model::class]],
            [
                ['viewName'], 'match', 'pattern' => '/^\w+[\\-\\/\w]*$/',
                                       'message' => 'Only word characters, dashes and slashes are allowed.',
            ],
            [
                ['viewPath'], 'match', 'pattern' => '/^@?\w+[\\-\\/\w]*$/',
                                       'message' => 'Only word characters, dashes, slashes and @ are allowed.',
            ],
            [['viewPath'], 'validateViewPath'],
            [
                ['scenarioName'], 'match', 'pattern' => '/^[\w\\-]+$/',
                                           'message' => 'Only word characters and dashes are allowed.',
            ],
            [['enableI18N'], 'boolean'],
            [['messageCategory'], 'validateMessageCategory', 'skipOnEmpty' => false],
        ]);
    }

    /**
     * Returns the attribute labels.
     *
     * @return array attribute labels (name => label)
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'modelClass'   => 'Model Class',
            'viewName'     => 'View Name',
            'viewPath'     => 'View Path',
            'scenarioName' => 'Scenario',
        ]);
    }

    /**
     * Returns a list of code template files that are required.
     *
     * @return array list of code template files that are required.
     */
    public function requiredTemplates()
    {
        return ['form.php', 'action.php'];
    }

    /**
     * Returns the list of sticky attributes.
     * A sticky attribute will remember its value and will initialize the attribute with this value
     * when the generator is restarted.
     *
     * @return array list of sticky attributes
     */
    public function stickyAttributes()
    {
        return array_merge(parent::stickyAttributes(), ['viewPath', 'scenarioName']);
    }

    /**
     * Returns the list of hint messages.
     * The array keys are the attribute names, and the array values are the corresponding hint messages.
     * Hint messages will be displayed to end users when they are filling the form for the generator.
     *
     * @return array the list of hint messages
     */
    public function hints()
    {
        return array_merge(parent::hints(), [
            'modelClass'   => 'This is the model class for collecting the form input. You should provide a fully qualified class name, e.g., <code>app\models\Post</code>.',
            'viewName'     => 'This is the view name with respect to the view path. For example, <code>site/index</code> would generate a <code>site/index.php</code> view file under the view path.',
            'viewPath'     => 'This is the root view path to keep the generated view files. You may provide either a directory or a path alias, e.g., <code>@app/views</code>.',
            'scenarioName' => 'This is the scenario to be used by the model when collecting the form input. If empty, the default scenario will be used.',
        ]);
    }

    /**
     * Returns the message to be displayed when the newly generated code is saved successfully.
     *
     * @return string the message to be displayed when the newly generated code is saved successfully.
     */
    public function successMessage()
    {
        $code = highlight_string($this->render('action.php'), true);

        return <<<EOD
<p>The form has been generated successfully.</p>
<p>You may add the following code in an appropriate controller class to invoke the view:</p>
<pre>$code</pre>
EOD;
    }

    /**
     * Validates [[viewPath]] to make sure it is a valid path or path alias and exists.
     */
    public function validateViewPath()
    {
        $path = Yii::getAlias($this->viewPath, false);
        if ($path === false || !is_dir($path)) {
            $this->addError('viewPath', 'View path does not exist.');
        }
    }

    /**
     * @return array list of safe attributes of [[modelClass]]
     */
    public function getModelAttributes()
    {
        /* @var $model Model */
        $model = new $this->modelClass();
        if (!empty($this->scenarioName)) {
            $model->setScenario($this->scenarioName);
        }

        return $model->safeAttributes();
    }
}
