<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 7/18/16
 * Time: 3:51 PM
 */


namespace khans\utils\models\queries;

use khans\utils\models\KHanModel;

/**
 * Common methods in the queries of the site
 *
 * @package khans\utils
 * @version 0.2.1-970825
 * @since   1.0
 */
class KHanQuery extends \yii\db\ActiveQuery
{
    /**
     * return only active items
     *
     * @return $this
     */
    public function active()
    {
        return $this->andWhere(['{{' . $this->getPrimaryTableName() . '}}.[[status]]' => KHanModel::STATUS_ACTIVE]);
    }

    /**
     * return only visible items
     *
     * @return $this
     */
    public function visible()
    {
        return $this->andWhere([
            '!=', '{{' . $this->getPrimaryTableName() . '}}.[[status]]', KHanModel::STATUS_DELETED,
        ]);
    }
}
