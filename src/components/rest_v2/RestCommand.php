<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 28/03/19
 * Time: 15:41
 */


namespace khans\utils\components\rest_v2;

use khans\utils\components\JwtPayload;
use yii\base\InvalidValueException;
use yii\web\HttpException;

/**
 * Class Command implements Command component for PostgREST client.
 * This client utilizes JWT for authentication with the server.
 *
 * @package khans\utils\components\rest_v2
 * @version 0.1.1-980109
 * @since   1.0
 */
class RestCommand extends \yii\db\Command
{
    private $_sql = '';

    /**
     * @inheritDoc
     */
    public function setSql($sql)
    {
        $this->_sql = $sql;
    }

    /**
     * @inheritDoc
     */
    public function getSql()
    {
        return $this->_sql;
    }

    /**
     * @inheritDoc
     */
    public function getRawSql()
    {
        return $this->_sql;
    }

    /**
     * @inheritDoc
     * @throws HttpException
     */
    protected function queryInternal($method, $fetchMode = null)
    {
        $sql = $this->getRawSql();
        switch ($method) {
            case 'fetchAll':
                break;
            case 'fetch':
            case 'fetchColumn':
                if (strpos('?', $sql) !== false) {
                    $sql .= '&limit=1';
                } else {
                    $sql .= '?limit=1';
                }
                break;
        }

        try {
            $resultSet = $this->launchRestServer($sql);
        } catch (\Exception $e) {
            throw new HttpException($e->getMessage());
        }
        if(is_null($resultSet)){
            return [];
        }
        if ($method == 'fetchColumn') {
            $resultSet = current($resultSet);
        }
        if(is_string($resultSet)){
            throw new InvalidValueException($resultSet . ' from calling `' . $method . ', ' . $fetchMode . '` and SQL: ' . $sql);
        }elseif (is_null($resultSet)||is_bool($resultSet)){
            return $resultSet;
        }
        switch ($fetchMode) {
            case 0:
                if ($method == 'fetchAll') {
                    return $resultSet;
                }

                return current($resultSet);
            case \PDO::FETCH_COLUMN:
                $data = current($resultSet);
                if(is_string($data)){
                    throw new InvalidValueException($data . ' from calling `' . $method . ', ' . $fetchMode . '` and SQL: ' . $sql);
                }elseif (is_null($data)||is_bool($data)){
                    return $data;
                }
                $column = key($data);

                return array_column($resultSet, $column);
            default:
                return $resultSet;
        }
    }

    /**
     * @inheritDoc
     * @throws \Exception
     */
    public function execute()
    {
        return $this->launchRestServer($this->getRawSql());
    }

    /**
     * Contact PostgREST and get the results for the query.
     * If indexBy is set, do the indexing
     *
     * @param string $sql query to run
     *
     * @return array|bool|mixed|string
     * @throws \Exception
     */
    private function launchRestServer($sql)
    {
        $payLoad = new JwtPayload();
        $jwt = $payLoad->getJwt('portal');

        $curlOptions = [
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_HTTPHEADER     => ["Content-Type: application/json"],
            CURLOPT_RETURNTRANSFER => true,   // return web page
            CURLOPT_HEADER         => false,  // don't return headers
            CURLOPT_FOLLOWLOCATION => false,  // follow redirects
            CURLOPT_MAXREDIRS      => 1,      // stop after 10 redirects
            CURLOPT_ENCODING       => "",     // handle compressed
            CURLOPT_USERAGENT      => "test", // name of client
            CURLOPT_AUTOREFERER    => true,   // set referrer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,    // time-out on connect
            CURLOPT_TIMEOUT        => 120,    // time-out on response
        ];

        $curl = curl_init($sql);
        curl_setopt_array($curl, $curlOptions);
        curl_setopt($curl,CURLOPT_HTTPHEADER,['Authorization: Bearer ' . $jwt]);

        $result = curl_exec($curl);
//Yii::debug('readServer Result: ' . var_export($result, true), 'jwt');
        $error = curl_error($curl);
//Yii::debug('readServer Error: ' . var_export($error, true), 'jwt');
        curl_close($curl);
        if (!empty($error)) {
            throw new \Exception($error);
        }

        $result = json_decode($result, true);
        if(is_null($result)){
            echo '!!!' . __FILE__ . '#'.__LINE__ . "<br/>\n" . $sql;exit;
        }
        if (empty($this->indexBy)) {
            return $result;
        }

        $indexed = [];
        foreach ($result as $row) {
            $indexed[$row->{$this->indexBy}] = $row;
        }

        return $indexed;
    }
}