<?php


namespace khans\utils\demos\data;


use khans\utils\behaviors\EavQueryTrait;

/**
 * This is the ActiveQuery class for [[MultiFormatEav]].
 *
 * @see MultiFormatEav
 *
 * @package KHanS\Utils
 * @version 0.1.1-971126
 * @since   1.0
 */
class MultiFormatEavQuery extends \khans\utils\models\queries\KHanQuery
{
    use EavQueryTrait;
}
