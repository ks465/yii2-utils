<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 01/04/19
 * Time: 13:57
 */


namespace khans\utils\components\rest_v2;


use yii\data\ArrayDataProvider;

/**
 * Class RestDataProvider is a wrapper for ArrayDataProvider and accepts RestQuery similar
 * to ActiveDataProvider
 *
 * @package khans\utils\components\rest_v2
 * @version 0.1.0-980107
 * @since   1.0
 */
class RestDataProvider extends ArrayDataProvider
{
    /**
     * @var RestQuery Used to retrieve `allModels`
     */
public $query;

    /**
     * Load data from the REST server and build a class of type ArrayDataProvider
     */
    public function init()
    {
        //todo: set `key` for the provider
        //todo: either cache the models or limit the size
        $query = clone $this->query;
        $this->allModels = $query->all();

    $this->sort=[
        'attributes'=> $query->select,
    ];

        parent::init();

    }
}