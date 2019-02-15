<?php


namespace khans\utils\tools\models;

use khans\utils\models\queries\KHanQuery;

/**
 * This is the model class for table "sys_eav_values".
 *
 * @property int              $id ID
 * @property int              $attribute_id Attribute ID
 * @property int              $record_id Entity Table Record ID
 * @property string           $value Data Value
 * @property int              $status وضعیت رکورد
 * @property int              $created_by سازنده
 * @property int              $updated_by ویرایشگر
 * @property int              $created_at زمان افزودن
 * @property int              $updated_at زمان آخرین ویرایش
 *
 * @property SysEavAttributes $parent
 *
 * @package KHanS\Utils
 * @version 0.2.0-971114
 * @since   1.0
 */
class SysEavValues extends \khans\utils\models\KHanModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'sys_eav_values';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            [['attribute_id', 'record_id', 'value'], 'required'],
            [
                ['attribute_id', 'record_id', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'],
                'integer',
            ],
            [['value'], 'string', 'max' => 1023],
            [
                ['attribute_id'], 'exist', 'skipOnError'     => true, 'targetClass' => SysEavAttributes::class,
                                           'targetAttribute' => ['attribute_id' => 'id'],
            ],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return parent::attributeLabels() + [
                'id'           => 'ID',
                'attribute_id' => 'Attribute ID',
                'record_id'    => 'Entity Table Record ID',
                'value'        => 'Data Value',
                'status'       => 'وضعیت رکورد',
                'created_by'   => 'سازنده',
                'updated_by'   => 'ویرایشگر',
                'created_at'   => 'زمان افزودن',
                'updated_at'   => 'زمان آخرین ویرایش',
            ];
    }

    /**
     * {@inheritdoc}
     * @return queries\SysEavValuesQuery the active query used by this AR class.
     */
    public static function find(): KHanQuery
    {
        return new queries\SysEavValuesQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(SysEavAttributes::class, ['id' => 'attribute_id']);
    }
}
