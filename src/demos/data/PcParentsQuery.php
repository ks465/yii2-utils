<?php

namespace khans\utils\demos\data;

use \khans\utils\behaviors\ParentChildTrait;
/**
 * This is the ActiveQuery class for [[PcParents]].
 *
 * @see PcParents
 *
 * @package KHanS\Utils
 * @version 0.1.0-971020
 * @since   1.0
 */
class PcParentsQuery extends \khans\utils\models\queries\KHanQuery
{
    use ParentChildTrait;

    /**
     * Get an array suitable for Select2 selection dropdown
     *
     * @return array
     */
    public function getSelectionList()
    {
        return $this
            ->getTitle()
            ->all()
        ;
    }

    /**
     * Create a meaningful title for the list of system database tables
     *
     * @param string $title column name for the title field
     *
     * @return $this
     */
    public function getTitle($title = 'title')
    {
        return $this
            ->select(['id', $title => 'comment'])
            ->orderBy(['comment' => SORT_ASC])
            ->asArray()
        ;
    }
}
