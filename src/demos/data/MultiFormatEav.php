<?php

namespace khans\utils\demos\data;

use Yii;
use \khans\utils\models\queries\KHanQuery;
use khans\utils\demos\data\SysEavAttributes;

/**
 * This is the model class for table "multi_format_data".
 *
 * @property string $tableComment Multi Format Data
 *
 * @property int $pk_column
 * @property int $integer_column
 * @property string $text_column
 * @property double $real_column
 * @property int $boolean_column
 * @property int $timestamp_column
 * @property string $progress_column
 * @property int $status
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 *
 * @property array    $_labels
 * @property array    $_attributes
 *
 * @package KHanS\Utils
 * @version 0.3.0-980123
 * @since   1.0
 */
class MultiFormatEav extends \khans\utils\demos\data\KHanModel
{
    /**
     * @var string Comment given to the table in the database
     */
    public static $tableComment = 'EAV Sample Data';

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'multi_format_data';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('test');
    }

    /**
     * Add EAV behavior by default
     */
    public function behaviors(): array
    {
        return array_merge([
            'EAV' => [
                'class' => '\khans\utils\demos\data\EavBehavior',
                'id'    => 'multi_format_data',
            ],
        ], parent::behaviors());
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            [['integer_column', 'boolean_column', 'timestamp_column', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['text_column', 'progress_column'], 'string'],
            [['real_column'], 'number'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return parent::attributeLabels() + $this->_labels + [
            'pk_column' => 'Pk Column',
            'integer_column' => 'Integer Column',
            'text_column' => 'Text Column',
            'real_column' => 'Real Column',
            'boolean_column' => 'Boolean Column',
            'timestamp_column' => 'Timestamp Column',
            'progress_column' => 'Progress Column',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return MultiFormatEavQuery the active query used by this AR class.
     */
    public static function find(): \khans\utils\models\queries\KHanQuery    {
        return new MultiFormatEavQuery(get_called_class());
    }
}
