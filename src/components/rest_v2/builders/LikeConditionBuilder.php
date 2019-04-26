<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */


namespace khans\utils\components\rest_v2\builders;

use yii\base\InvalidArgumentException;
use yii\db\conditions\LikeCondition;
use yii\db\ExpressionBuilderInterface;
use yii\db\ExpressionBuilderTrait;
use yii\db\ExpressionInterface;

/**
 * Class LikeConditionBuilder builds objects of [[LikeCondition]]
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 * @since 2.0.14
 */
class LikeConditionBuilder implements ExpressionBuilderInterface
{
    use ExpressionBuilderTrait;

    /**
     * @var array map of chars to their replacements in LIKE conditions.
     * By default it's configured to escape `%`, `_` and `\` with `\`.
     */
    protected $escapingReplacements = [
        '%'  => '\%',
        '_'  => '\_',
        '\\' => '\\\\',
    ];
    /**
     * @var string|null character used to escape special characters in LIKE conditions.
     * By default it's assumed to be `\`.
     */
    protected $escapeCharacter;


    /**
     * Method builds the raw SQL from the $expression that will not be additionally
     * escaped or quoted.
     *
     * @param ExpressionInterface|LikeCondition $expression the expression to be built.
     * @param array                             $params the binding parameters.
     *
     * @return string the raw SQL that will not be additionally escaped or quoted.
     */
    public function build(ExpressionInterface $expression, array &$params = [])
    {
        $operator = $expression->getOperator();
        $column = $expression->getColumn();
        $values = $expression->getValue();

        list($and_or, $not, $operator) = $this->parseOperator($operator);
//var_dump($and_or, $not, $operator);
        if (!is_array($values)) {
            $values = [$values];
        }

        if (empty($values)) {
            return $not ? '' : '0=1';
        }

        if($not){
            $operator = 'not.' .$operator;
        }

        $escapeSql = $this->getEscapeSql();
        $parts = [];
        foreach ($values as $value) {
            if ($value instanceof ExpressionInterface) {
                $phName = $this->queryBuilder->buildExpression($value, $params);
            } else {
                $phName = '*' . $value . '*';
            }
//var_dump($phName);
//            $phName = '"' . strtr($phName, ['ی'=>'(ی|ي)', 'ي'=>'(ی|ي)']) . '"';
//            $phName = '"' . str_replace(['ی', 'ي'],'(ی|ي)',$phName) . '"';
//var_dump($phName);
            $parts[] = "{$column}.{$operator}.{$phName}{$escapeSql}";
        }
//var_dump($parts, $and_or . '(' . implode(',', $parts) . ')');exit;
//        return   implode(',', $parts) ;
        return $and_or . '(' . implode(',', $parts) . ')';
    }

    /**
     * @return string
     */
    private function getEscapeSql()
    {
        if ($this->escapeCharacter !== null) {
            return " ESCAPE '{$this->escapeCharacter}'";
        }

        return '';
    }

    /**
     * @param string $operator
     *
     * @return array
     */
    protected function parseOperator($operator)
    {
        if (!preg_match('/^(AND |OR |)(((NOT |))(I?LIKE))/', $operator, $matches)) {
            throw new InvalidArgumentException("Invalid operator '$operator'.");
        }

        $and_or = trim(strtolower(!empty($matches[1]) ? $matches[1] : 'AND'));

        $not = !empty($matches[3]);
        $operator = strtolower($matches[5]);
//var_dump($matches);
        return [$and_or, $not, $operator];
    }
}
