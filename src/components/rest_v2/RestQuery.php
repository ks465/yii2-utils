<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 26/03/19
 * Time: 17:28
 */


namespace khans\utils\components\rest_v2;


use khans\utils\components\rest_v2\builders\QueryBuilder;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\Exception;
use yii\db\ExpressionInterface;
use yii\db\Query;

/**
 * Class RestQuery is a base query for reading from PostgREST server with an interface similar to the standard Yii2
 * Query
 *
 * @package khans\utils\components\rest_v2
 * @version 0.1.0-980107
 * @since   1.0
 */
class RestQuery extends Query
{
    /**
     * @var string Base address of the REST server
     */
    public $baseUrl = 'http://192.168.56.3:8081/';

    /**
     * @inheritDoc
     */
    public function select($columns, $option = null)
    {
        $this->select = [];

        return $this->addSelect($columns);
    }

    /**
     * @inheritDoc
     */
    public function addSelect($columns)
    {
        if (!is_array($columns)) {
            $columns = [$columns];
        }
        foreach ($columns as $alias => $column) {
            $this->select[] = (is_numeric($alias) ? '' : $alias . ':') . $column;
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function orderBy($columns)
    {
        $this->orderBy = [];

        return $this->addOrderBy($columns);
    }

    /**
     * @inheritDoc
     */
    public function addOrderBy($columns)
    {
        foreach ($columns as $column => $type) {
            $this->orderBy[] = $column . '.' . ($type == SORT_DESC ? 'desc' : 'asc');
        }

        return $this;
    }

    /**
     * Construct the SQL query
     *
     * @param null $db This is only to save the inheritance
     *
     * @return RestCommand
     */
    public function createCommand($db = null)
    {
        $parts = [];
        if (!empty($this->from)) {
            $sql = $this->baseUrl . $this->from[0];
        } else {
            $sql = $this->baseUrl;
        }
        if (!empty($this->select)) {
            $parts[] = 'select=' . implode(',', $this->select);
        }
        if (!empty($this->orderBy)) {
            $parts[] = 'order=' . implode(',', $this->orderBy);
        }

        if (!empty($this->limit)) {
            $parts[] = 'limit=' . $this->limit;
        }
        if (!empty($this->offset)) {
            $parts[] = 'offset=' . $this->offset;
        }
        if (!empty($this->where)) {

            $parts[] = 'and=(' . $this->buildConditions() . ')';
        }

        if (count($parts) > 0) {
            $sql .= '?' . implode('&', $parts);
        }

        $config = [
            'class' => 'khans\utils\components\rest_v2\RestCommand',
            'sql'   => $sql,
        ];
        /** @var RestCommand $command */
        try {
            $command = Yii::createObject($config);
        } catch (InvalidConfigException $e) {
            $command = new RestCommand();
        }

        return $command;
    }

    /**
     * Compile conditions using QueryBuilder and ConditionBuilders similar to Yii2 ones.
     *
     * @return string
     */
    private function buildConditions()
    {
        $params = [];
        $condition = $this->where;
        $query = new QueryBuilder(Yii::$app->db);
        if (is_array($condition)) {
            if (empty($condition)) {
                return '';
            }

            $condition = $query->createConditionFromArray($condition);
        }

        if ($condition instanceof ExpressionInterface) {
            return $query->buildExpression($condition, $params);
        }

        return (string)$condition;
    }

    /**
     * Queries a scalar value by setting [[select]] first.
     * Restores the value of select to make this query reusable.
     *
     * @param string|ExpressionInterface $selectExpression
     *
     * @return array
     */
    protected function queryColumn($selectExpression)
    {
        $select = $this->select;
        $order = $this->orderBy;
        $limit = $this->limit;
        $offset = $this->offset;

        $this->select = [$selectExpression];
        $this->orderBy = null;
        $this->limit = null;
        $this->offset = null;
        $command = $this->createCommand(null);

        $this->select = $select;
        $this->orderBy = $order;
        $this->limit = $limit;
        $this->offset = $offset;

        try {
            return $command->queryColumn();
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }

    }

    /**
     * @inheritDoc
     */
    public function exists($db = null)
    {
        $command = $this->createCommand(null);

        try {
            return (bool)$command->queryScalar();
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * @inheritDoc
     */
    public function count($q = '*', $db = null)
    {
        $data = $this->queryColumn($q);
        if (is_bool($data) || is_null($data)) {
            return 0;
        }

        return count($data);
    }

    /**
     * @inheritDoc
     */
    public function sum($q, $db = null)
    {
        $data = $this->queryColumn($q);
        if (is_bool($data) || is_null($data)) {
            return null;
        }

        return array_sum($this->queryColumn($q));
    }

    /**
     * @inheritDoc
     */
    public function average($q, $db = null)
    {
        $data = $this->queryColumn($q);
        if (is_bool($data) || is_null($data)) {
            return null;
        }
        $count = count($data);
        if ($count == 0) {
            return null;
        }

        return array_sum($data) / $count;
    }

    /**
     * @inheritDoc
     */
    public function min($q, $db = null)
    {
        $data = $this->queryColumn($q);
        if (is_bool($data) || is_null($data)) {
            return null;
        }
        $count = count($data);
        if ($count == 0) {
            return null;
        }

        return min($data);
    }

    /**
     * @inheritDoc
     */
    public function max($q, $db = null)
    {
        $data = $this->queryColumn($q);
        if (is_bool($data) || is_null($data)) {
            return null;
        }
        $count = count($data);
        if ($count == 0) {
            return null;
        }

        return max($data);
    }


}