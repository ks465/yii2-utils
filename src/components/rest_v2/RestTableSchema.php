<?php


namespace khans\utils\components\rest_v2;


use yii\db\TableSchema;

/**
 * Class RestTableSchema reads the table schema from the REST server and provides related services to other classes
 *
 * @package khans\utils\components\rest_v2
 * @version 0.1.1-980217
 * @since   1.0
 */
class RestTableSchema extends TableSchema
{
    /* @var string Prefix for naming the cache item */
    private $cacheID = 'rest_cache_';
    
    /* @var string Base URL of the PostgREST server */
    public $baseUrl = 'http://192.168.56.2:8081/';
    
    /* @var array List of available tables and definitions from PostgREST */
    private $schema;
       
    /**
     * Read data from REST server into cache for all tables.
     * Populate `columns` property of the current model
     */
    public function init()
    {
        $this->cacheID .= str_replace(['/', '.', ':'], '_', $this->baseUrl . '_' . $this->name);
        
        $result = \Yii::$app->cache->get($this->cacheID);
        if ($result === false) {
            $query = new RestQuery(['baseUrl' => $this->baseUrl]);
            $result = $query->all();
            $result = $result['definitions'];
            
            \Yii::$app->cache->set($this->cacheID, $result, 86400);
        }
        
        $this->columns = $result[$this->name]['properties'];
        parent::init();
    }
    
    /**
     * Delete the cache item for REST schema manually
     *
     * @return boolean result of deleting the item
     */
    public function invalidateCache()
    {
        return \Yii::$app->cache->delete($this->cacheID);
    }

}