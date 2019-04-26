<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */


namespace khans\utils\components\rest_v2\builders;

use yii\db\conditions\NotCondition;
use yii\db\ExpressionBuilderInterface;
use yii\db\ExpressionBuilderTrait;
use yii\db\ExpressionInterface;

/**
 * Class NotConditionBuilder builds objects of [[NotCondition]]
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 * @since 2.0.14
 */
class NotConditionBuilder implements ExpressionBuilderInterface
{
    use ExpressionBuilderTrait;


    /**
     * Method builds the raw SQL from the $expression that will not be additionally
     * escaped or quoted.
     *
     * @param ExpressionInterface|NotCondition $expression the expression to be built.
     * @param array                            $params the binding parameters.
     *
     * @return string the raw SQL that will not be additionally escaped or quoted.
     */
    public function build(ExpressionInterface $expression, array &$params = [])
    {
        $operand = $expression->getCondition();
        if ($operand === '') {
            return $this->getNegationOperator();
        }
        $expression = $this->queryBuilder->buildCondition($operand, $params);

        return "{$this->getNegationOperator()} ($expression)";
    }

    /**
     * @return string
     */
    protected function getNegationOperator()
    {
        return 'not';
    }
}
