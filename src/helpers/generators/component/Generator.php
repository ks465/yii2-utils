<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 19/01/19
 * Time: 09:23
 */


namespace khans\utils\helpers\generators\component;


use khans\utils\components\StringHelper;
use khans\utils\models\KHanModel;
use Yii;
use yii\db\BaseActiveRecord;
use yii\gii\CodeFile;
use yii\helpers\Inflector;

/**
 * This generator will generate Action for searching model, RelatedColumn for grid view with searching capability, and
 * Selector widget for selecting records from the given model.
 *
 * @package KHanS\Utils
 * @version 0.1.0-971029
 * @since   1.0
 */
class Generator extends \yii\gii\Generator
{
    /**
     * @var string A model used as target for [[RelatedColumn]], searching model for the action and selector widget.
     */
    public $targetModel;
    /**
     * @var string The key field in the target model.
     */
    public $targetField = 'id';
    /**
     * @var string The field in the target model which could be used as a title for records.
     */
    public $titleField = 'title';
    /**
     * @var string The namespace for the created column class.
     */
    public $columnClass = 'app\common\columns';
    /**
     * @var string The URL to the selector widgets directory.
     */
    public $selectorPath = '@app/common/widgets/selectors';
    /**
     * @var string The namespace of the actions.
     */
    public $actionClass = 'app\common\actionAction';
    /**
     * @var string The URL to the view widgets directory.
     */
    public $widgetPath = '@app/common/widgets/viewer';

    /**
     * @return string name of the code generator
     */
    public function getName(): string
    {
        return 'KHan Component Generator';
    }

    /**
     * @return string the detailed description of the generator.
     */
    public function getDescription(): string
    {
        return '<div class=" alert alert-info">' .
            'This generator helps you to quickly generate multiple useful components and widgets.' .
            'These include:' .
            '<ul>' .
            '<li>' . '<code>Selector</code> ' .
            'Generates a selecting widget for a record in the given model.' .
            '</li>' .

            '<li>' . '<code>Action</code> ' .
            'Generates an action class to respond to the search request from the `selector`.' .
            '</li>' .

            '<li>' . '<code>Column</code> ' .
            'Generates a column class based on `RelatedColumn` for showing a relation in the grid view.' .
            '</li>' .

            '<li>' . '<code>View Widget</code> ' .
            'Generates a view page for including in other pages.' .
            '</li>' .

            '</ul>' .
            '</div>';
    }

    /**
     * @return array rules for validating the required data
     */
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            [
                ['targetModel', 'targetField', 'titleField', 'columnClass', 'selectorPath', 'actionClass'], 'filter',
                'filter' => 'trim',
            ],
            [['targetModel', 'targetField', 'titleField', 'columnClass', 'selectorPath', 'actionClass'], 'required'],

            [['targetModel'], 'validateClass', 'params' => ['extends' => BaseActiveRecord::class]],

            [
                ['columnClass'], 'match', 'pattern' => '/Column$/',
                                          'message' => 'Column class name must be suffixed with "Column".',
            ],
            [
                ['columnClass'], 'match', 'pattern' => '/(^|\\\\)[A-Z][^\\\\]+Column/',
                                          'message' => 'Column class name must start with an uppercase letter.',
            ],

            [
                ['actionClass'], 'match', 'pattern' => '/Action$/',
                                          'message' => 'Action class name must be suffixed with "Action".',
            ],
            [
                ['actionClass'], 'match', 'pattern' => '/(^|\\\\)[A-Z][^\\\\]+Action/',
                                          'message' => 'Action class name must start with an uppercase letter.',
            ],

            [
                ['targetModel', 'targetField', 'titleField', 'columnClass', 'actionClass'], 'match',
                'pattern' => '/^[\w\\\\]*$/', 'message' => 'Only word characters and backslashes are allowed.',
            ],
        ]);
    }

    /**
     * @return array labels for the web form
     */
    public function attributeLabels(): array
    {
        return array_merge(parent::attributeLabels(), [
            'targetModel'  => 'Target Model',
            'targetField'  => 'Key field in the Target Model',
            'titleField'   => 'Title Field in the Target model',
            'columnClass'  => 'Column Class',
            'selectorPath' => 'Path to Selector',
            'actionClass'  => 'Action Class',
        ]);
    }

    /**
     * @return array Hints for the web version of the Generator
     */
    public function hints()
    {
        return [
            'targetModel'  => 'This is the name of the model class in request. You should
                provide a fully qualified namespaced class (e.g. <code>app\models\References</code>),
                and class should Exist. This model will be used as <code>targetModel</code> 
                for generated `Column`, and also searching model for `Selector` and `Action`.',
            'targetField'  => 'This is the name of a field in the given `targetModel` which is indeed a Primary Key 
                (or at least a Unique Key) to its records.',
            'titleField'   => 'This is the name of a field in the given `targetModel` which can be used as a descriptor or title 
                for each record.',

            'columnClass'  => 'This is the name of the column class to be generated. You should
                provide a fully qualified namespaced class (e.g. <code>app\common\columns\SampleColumn</code>),
                and class name should be in CamelCase with an uppercase first letter.',

            'selectorPath' => 'Specify the directory for storing the selector widgets. You may use path alias here, e.g.,
                <code>/var/www/basic/widgets/selectors/sample</code>, <code>@app/views/widgets/sample</code>.',

            'actionClass'  => 'This is the name of the action class to be generated. You should
                provide a fully qualified namespaced class (e.g. <code>app\common\actions\SampleAction</code>),
                and class name should be in CamelCase with an uppercase first letter.',
        ];
    }

    /**
     * @return string Message for successfully generating the widgets
     */
    public function successMessage()
    {
        return 'The widgets have been generated successfully.' . $this->getLinkToTry();
    }

    /**
     * Generates the code based on the current user input and the specified code template files.
     * This is the main method that child classes should implement.
     * Please refer to [[\yii\gii\generators\controller\Generator::generate()]] as an example
     * on how to implement this method.
     *
     * @return CodeFile[] a list of code files to be created.
     */
    public function generate()
    {
        $selectorName = '_select-' . Inflector::camel2id(Inflector::singularize(StringHelper::basename($this->targetModel)));

        $files = [];
        $files[] = new CodeFile(
            Yii::getAlias('@' . str_replace('\\', '/', ltrim($this->actionClass, '\\')) . '.php'),
            $this->render('action.php')
        );
        $files[] = new CodeFile(
            Yii::getAlias('@' . str_replace('\\', '/', ltrim($this->columnClass, '\\')) . '.php'),

            $this->render('column.php')
        );
        $files[] = new CodeFile(
            Yii::getAlias($this->selectorPath) . '/' . $selectorName . '.php',
            $this->render('selector.php')
        );

        return $files;
    }
}
