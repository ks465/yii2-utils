<?php


namespace khans\utils\tools\models\queries;

/**
 * This is the ActiveQuery class for [[\khans\utils\tools\models\SysEavAttributes]].
 *
 * @see \khans\utils\tools\models\SysEavAttributes
 *
 * @package KHanS\Utils
 * @version 0.1.0-971020
 * @since   1.0
 */
class SysEavAttributesQuery extends \khans\utils\models\queries\KHanQuery
{
    /**
     * Create a meaningful title for the list of EAV list of values
     *
     * @param string $title column name for the title field
     *
     * @return $this
     */
    public function getTitle($title = 'title'): SysEavAttributesQuery
    {
        return $this
            ->select([
                'id',
                $title => 'CONCAT([[attr_label]], " (", [[entity_table]], ".", [[attr_name]], ")")',
            ])
            ->orderBy(['entity_table' => SORT_ASC, 'attr_name' => SORT_ASC, 'attr_label' => SORT_ASC])
            ->asArray();
    }
}
