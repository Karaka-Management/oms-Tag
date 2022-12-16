<?php
/**
 * Karaka
 *
 * PHP Version 8.1
 *
 * @package   Modules\Tag\Models
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\Tag\Models;

use phpOMS\DataStorage\Database\Mapper\DataMapperFactory;

/**
 * Tag mapper class.
 *
 * @package Modules\Tag\Models
 * @license OMS License 1.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
final class TagL11nMapper extends DataMapperFactory
{
    /**
     * Columns.
     *
     * @var array<string, array{name:string, type:string, internal:string, autocomplete?:bool, readonly?:bool, writeonly?:bool, annotations?:array}>
     * @since 1.0.0
     */
    public const COLUMNS = [
        'tag_l11n_id'       => ['name' => 'tag_l11n_id',       'type' => 'int',    'internal' => 'id'],
        'tag_l11n_title'    => ['name' => 'tag_l11n_title',    'type' => 'string', 'internal' => 'title', 'autocomplete' => true],
        'tag_l11n_tag'      => ['name' => 'tag_l11n_tag',      'type' => 'int',    'internal' => 'tag'],
        'tag_l11n_language' => ['name' => 'tag_l11n_language', 'type' => 'string', 'internal' => 'language'],
    ];

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    public const TABLE = 'tag_l11n';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    public const PRIMARYFIELD ='tag_l11n_id';
}
