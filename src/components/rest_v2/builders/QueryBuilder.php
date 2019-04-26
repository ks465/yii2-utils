<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 28/03/19
 * Time: 12:13
 */


namespace khans\utils\components\rest_v2\builders;


use yii\db\ExpressionInterface;

/**
 * Class QueryBuilder is builder behind RestQuery
 *
 * @package khans\utils\components\rest_v2
 * @version 0.1.0-980101
 * @since   1.0
 */
class QueryBuilder extends \yii\db\QueryBuilder
{
    /**
     * @inheritDoc
     */
    protected function defaultExpressionBuilders()
    {
        return [
//            'khans\utils\components\rest_v2\builders\StringCondition'=> 'khans\utils\components\rest_v2\builders\StringConditionBuilder',
            'yii\db\Query'                           => 'khans\utils\components\rest_v2\builders\QueryExpressionBuilder',
            'yii\db\Expression'                      => 'khans\utils\components\rest_v2\builders\ExpressionBuilder',
            'yii\db\conditions\ConjunctionCondition' => 'khans\utils\components\rest_v2\builders\ConjunctionConditionBuilder',
            'yii\db\conditions\NotCondition'         => 'khans\utils\components\rest_v2\builders\NotConditionBuilder',
            'yii\db\conditions\AndCondition'         => 'khans\utils\components\rest_v2\builders\ConjunctionConditionBuilder',
            'yii\db\conditions\OrCondition'          => 'khans\utils\components\rest_v2\builders\ConjunctionConditionBuilder',
            'yii\db\conditions\BetweenCondition'     => 'khans\utils\components\rest_v2\builders\BetweenConditionBuilder',
            'yii\db\conditions\InCondition'          => 'khans\utils\components\rest_v2\builders\InConditionBuilder',
            'yii\db\conditions\LikeCondition'        => 'khans\utils\components\rest_v2\builders\LikeConditionBuilder',
            'yii\db\conditions\ExistsCondition'      => 'khans\utils\components\rest_v2\builders\ExistsConditionBuilder',
            'yii\db\conditions\SimpleCondition'      => 'khans\utils\components\rest_v2\builders\SimpleConditionBuilder',
            'yii\db\conditions\HashCondition'        => 'khans\utils\components\rest_v2\builders\HashConditionBuilder',
        ];
    }

    /**
     * @inheritDoc
     */
    public function XgetExpressionBuilder(ExpressionInterface $expression)
    {
        $x = parent::getExpressionBuilder($expression);
        var_dump($x);
        return $x;
    }

    /**
     * @inheritDoc
     */
    public function bindParam($value, &$params)
    {
        return $value;
    }

    /**
     * Translate mathematical operators into PostgREST operators
     *
     * @param string $operator
     * @param bool   $negate
     *
     * @return string
     */
    public static function getOperator($operator, $negate = false)
    {
        switch ($operator) {
            case '=':
                $apiOperator = 'eq';
                break;
            case '>':
                $apiOperator = 'gt';
                break;
            case '>=':
                $apiOperator = 'gte';
                break;
            case '<':
                $apiOperator = 'lt';
                break;
            case '<=':
                $apiOperator = 'lte';
                break;
            case '<>':
            case '!=':
                $apiOperator = 'neq';
                break;
            case 'like':
            case 'LIKE':
                $apiOperator = 'like';
                break;
            case 'in':
            case 'IN':
                $apiOperator = 'in';
                break;
            default:
                $apiOperator = $operator;
        }

        if ($negate) {
            return 'not.' . $apiOperator;
        }

        return $apiOperator;
    }
}