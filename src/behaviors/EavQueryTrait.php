<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 02/02/19
 * Time: 19:19
 */


namespace khans\utils\behaviors;

use khans\utils\tools\models\SysEavAttributes;
use yii\db\ActiveRecord;

/**
 * Class EavQueryTrait modifies an KHanQuery to support EAV
 *
 * @package KHanS\Utils
 * @version 0.2.1-980121
 * @since   1.0
 */
trait EavQueryTrait
{
    /**
     * @var bool status of joining the main table to table of attributes and table of values
     */
    private $joined = false;

    /**
     * Generate an AND condition from the give data for the EAV attributes and ignore empty values
     *
     * @param string $name the column name.
     * @param string $value the column value optionally prepended with the comparison operator.
     *
     * @return $this
     */
    public function andEavFilterWhere($name, $value)
    {
        if (empty($value)) {
            return $this;
        }
        $this->getEavJoinQuery();

        return $this->andWhere([
            'and',
            ['attr_name' => $name],
            ['value' => $value],
        ]);
    }

    /**
     * Generate an OR condition from the give data for the EAV attribute and ignore empty values
     *
     * @param string $name the column name.
     * @param string $value the column value optionally prepended with the comparison operator.
     *
     * @return $this
     */
    public function orEavFilterWhere($name, $value)
    {
        if (empty($value)) {
            return $this;
        }
        $this->getEavJoinQuery();

        return $this->orWhere([
            'and',
            ['attr_name' => $name],
            ['value' => $value],
        ]);
    }

    /**
     * Generates an conjugated AND condition from the given data for the EAV attribute and ignores the empty vlaues
     *
     * The comparison operator is intelligently determined based on the first few characters in the given value.
     * In particular, it recognizes the following operators if they appear as the leading characters in the given value:
     *
     * - `<`: the column must be less than the given value.
     * - `>`: the column must be greater than the given value.
     * - `<=`: the column must be less than or equal to the given value.
     * - `>=`: the column must be greater than or equal to the given value.
     * - `<>`: the column must not be the same as the given value.
     * - `=`: the column must be equal to the given value.
     * - `!=`: same as `<>`
     * - `like`: this is LIKE operator in the DBMS
     * - If none of the above operators is detected, the `$defaultOperator` will be used.
     *
     * @param string $name the column name.
     * @param string $value the column value optionally prepended with the comparison operator.
     * @param string $defaultOperator The operator to use, when no operator is given in `$value`.
     * Defaults to `=`, performing an exact match.
     *
     * @return $this The query object itself
     */
    public function andEavFilterCompare($name, $value, $defaultOperator = '=')
    {
        if (empty($value)) {
            return $this;
        }
        $this->getEavJoinQuery();

        if (preg_match('/^(<>|>=|>|<=|<|=|!=|like)/', $value, $matches)) {
            $operator = $matches[1];
            $value = substr($value, strlen($operator));
        } else {
            $operator = $defaultOperator;
        }

        return $this->andWhere([
            'and',
            ['attr_name' => $name],
            [$operator, 'value', $value],
        ]);
    }

    /**
     * Generates an conjugated OR condition from the given data for the EAV attribute and ignores the empty vlaues
     *
     * The comparison operator is intelligently determined based on the first few characters in the given value.
     * In particular, it recognizes the following operators if they appear as the leading characters in the given value:
     *
     * - `<`: the column must be less than the given value.
     * - `>`: the column must be greater than the given value.
     * - `<=`: the column must be less than or equal to the given value.
     * - `>=`: the column must be greater than or equal to the given value.
     * - `<>`: the column must not be the same as the given value.
     * - `=`: the column must be equal to the given value.
     * - `!=`: same as `<>`
     * - `like`: this is LIKE operator in the DBMS
     * - If none of the above operators is detected, the `$defaultOperator` will be used.
     *
     * @param string $name the column name.
     * @param string $value the column value optionally prepended with the comparison operator.
     * @param string $defaultOperator The operator to use, when no operator is given in `$value`.
     * Defaults to `=`, performing an exact match.
     *
     * @return $this The query object itself
     */
    public function orEavFilterCompare($name, $value, $defaultOperator = '=')
    {
        if (empty($value)) {
            return $this;
        }
        $this->getEavJoinQuery();

        if (preg_match('/^(<>|>=|>|<=|<|=|!=|like)/', $value, $matches)) {
            $operator = $matches[1];
            $value = substr($value, strlen($operator));
        } else {
            $operator = $defaultOperator;
        }

        return $this->orWhere([
            'and',
            ['attr_name' => $name],
            [$operator, 'value', $value],
        ]);
    }

    /**
     * Join the primary table to the table of attributes [[SysEavAttributes]] and table of values [[SysEavValues]]
     *
     * @return $this
     */
    public function getEavJoinQuery()
    {
        if ($this->joined) {
            return $this;
        }
        $this->joined = true;

        /* @var $modelClass ActiveRecord */
        $modelClass = $this->modelClass;
        $pk = $modelClass::primaryKey();

        return $this
            ->distinct()
            ->innerJoin('sys_eav_attributes')
            ->andWhere(['{{sys_eav_attributes}}.[[entity_table]]' => $this->getPrimaryTableName()])
            ->andWhere(['{{sys_eav_attributes}}.[[status]]' => SysEavAttributes::STATUS_ACTIVE])
            ->leftJoin('sys_eav_values', '{{sys_eav_attributes}}.[[id]] = {{sys_eav_values}}.[[attribute_id]]' .
                ' AND ' .
                '{{sys_eav_values}}.[[record_id]] = {{' . $this->getPrimaryTableName() . '}}.[[' . $pk[0] . ']]'
            );
    }
}
