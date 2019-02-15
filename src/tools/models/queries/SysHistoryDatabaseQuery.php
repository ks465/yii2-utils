<?php


namespace khans\utils\tools\models\queries;

/**
 * This is the ActiveQuery class for [[\khans\utils\tools\models\SysHistoryDatabase]].
 *
 * @see \khans\utils\tools\models\SysHistoryDatabase
 *
 * @package KHanS\Utils
 * @version 0.1.0-971020
 * @since   1.0
 */
class SysHistoryDatabaseQuery extends \khans\utils\models\queries\KHanQuery
{
    /**
     * Build condition to filter history for a given record
     *
     * @param string $tableName name of the containing table
     * @param string $fieldID id of the field in the table
     *
     * @return $this
     */
    public function forRecord($tableName, $fieldID)
    {
        return $this
            ->andWhere(['field_id' => $fieldID])
            ->andWhere(['table' => $tableName]);
    }
}
