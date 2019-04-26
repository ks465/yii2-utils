<?php

namespace khans\utils\demos\data;

use \khans\utils\behaviors\ParentChildTrait;
/**
 * This is the ActiveQuery class for [[PcChildren]].
 *
 * @see PcChildren
 *
 * @package KHanS\Utils
 * @version 0.1.0-971020
 * @since   1.0
 */
class PcChildrenQuery extends \khans\utils\models\queries\KHanQuery
{
    use ParentChildTrait;
}
