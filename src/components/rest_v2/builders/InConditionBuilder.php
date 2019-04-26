<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */


namespace khans\utils\components\rest_v2\builders;

use yii\db\conditions\ConditionInterface;
use yii\db\conditions\InCondition;
use yii\db\ExpressionBuilderInterface;
use yii\db\ExpressionBuilderTrait;
use yii\db\ExpressionInterface;
use yii\db\Query;

/**
 * Class InConditionBuilder builds objects of [[InCondition]]
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 * @since 2.0.14
 */
class InConditionBuilder implements ExpressionBuilderInterface
{
    use ExpressionBuilderTrait;


    /**
     * Method builds the raw SQL from the $expression that will not be additionally
     * escaped or quoted.
     *
     * @param ExpressionInterface|InCondition $expression the expression to be built.
     * @param array                           $params the binding parameters.
     *
     * @return string the raw SQL that will not be additionally escaped or quoted.
     */
    public function build(ExpressionInterface $expression, array &$params = [])
    {
        $operator = strtolower($expression->getOperator());
        $column = $expression->getColumn();
        $values = $expression->getValues();

        if ($column === []) {
            // no columns to test against
            return $operator === 'IN' ? '0=1' : '';
        }

        if ($values instanceof Query) {
            return $this->buildSubqueryInCondition($operator, $column, $values, $params);
        }

        if ($column instanceof \Traversable) {
            if (iterator_count($column) > 1) {
                return $this->buildCompositeInCondition($operator, $column, $values, $params);
            } else {
                $column->rewind();
                $column = $column->current();
            }
        }

        $sqlValues = $this->buildValues($expression, $values, $params);
        if (empty($sqlValues)) {
            return $operator === 'IN' ? '0=1' : '';
        }

        if ($operator === 'not in') {
            $operator = 'not.in';
        }
        if (count($sqlValues) > 1) {
            return "$column.$operator.(" . implode(',', $sqlValues) . ')';
        }

        $operator = $operator === 'IN' ? '=' : '<>';

        return $column . $operator . reset($sqlValues);
    }

    /**
     * Builds $values to be used in [[InCondition]]
     *
     * @param ConditionInterface|InCondition $condition
     * @param array                          $values
     * @param array                          $params the binding parameters
     *
     * @return array of prepared for SQL placeholders
     */
    protected function buildValues(ConditionInterface $condition, $values, &$params)
    {
        $sqlValues = [];
        $column = $condition->getColumn();

        if (is_array($column)) {
            $column = reset($column);
        }

        if ($column instanceof \Traversable) {
            $column->rewind();
            $column = $column->current();
        }

        foreach ($values as $i => $value) {
            if (is_array($value) || $value instanceof \ArrayAccess) {
                $value = isset($value[$column]) ? $value[$column] : null;
            }
            if ($value === null) {
                $sqlValues[$i] = 'NULL';
            } else {
                $sqlValues[$i] = $this->queryBuilder->bindParam($value, $params);
            }
        }

        return $sqlValues;
    }

    /**
     * Builds SQL for IN condition.
     *
     * @param string       $operator
     * @param array|string $columns
     * @param Query        $values
     * @param array        $params
     */
    protected function buildSubqueryInCondition($operator, $columns, $values, &$params)
    {
        throw new \BadFunctionCallException('This capability is not implemented.');
    }

    /**
     * Builds SQL for IN condition.
     *
     * @param string             $operator
     * @param array|\Traversable $columns
     * @param array              $values
     * @param array              $params
     */
    protected function buildCompositeInCondition($operator, $columns, $values, &$params)
    {
        throw new \BadFunctionCallException('This capability is not implemented.');
    }
}
