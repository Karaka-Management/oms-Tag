<?php
/**
 * Karaka
 *
 * PHP Version 8.0
 *
 * @package   Modules\Tag\Models
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://karaka.app
 */
declare(strict_types=1);

namespace Modules\Tag\Models;

use phpOMS\DataStorage\Database\Mapper\DataMapperFactory;

/**
 * Tag mapper class.
 *
 * @package Modules\Tag\Models
 * @license OMS License 1.0
 * @link    https://karaka.app
 * @since   1.0.0
 */
final class TagMapper extends DataMapperFactory
{
    /**
     * Columns.
     *
     * @var array<string, array{name:string, type:string, internal:string, autocomplete?:bool, readonly?:bool, writeonly?:bool, annotations?:array}>
     * @since 1.0.0
     */
    public const COLUMNS = [
        'tag_id'    => ['name' => 'tag_id',    'type' => 'int',    'internal' => 'id'],
        'tag_color' => ['name' => 'tag_color', 'type' => 'string', 'internal' => 'color'],
        'tag_icon'  => ['name' => 'tag_icon',  'type' => 'string', 'internal' => 'icon'],
        'tag_type'  => ['name' => 'tag_type',  'type' => 'int',    'internal' => 'type'],
        'tag_owner' => ['name' => 'tag_owner', 'type' => 'int',    'internal' => 'owner'],
    ];

    /**
     * Has many relation.
     *
     * @var array<string, array{mapper:string, table:string, self?:?string, external?:?string, column?:string}>
     * @since 1.0.0
     */
    public const HAS_MANY = [
        'title' => [
            'mapper'   => TagL11nMapper::class,
            'table'    => 'tag_l11n',
            'self'     => 'tag_l11n_tag',
            'column'   => 'title',
            'external' => null,
        ],
    ];

    /**
     * Belongs to.
     *
     * @var array<string, array{mapper:string, self:string}>
     * @since 1.0.0
     */
    /*
    public const BELONGS_TO = [
        'owner' => [
            'mapper' => AccountMapper::class,
            'external'   => 'tag_owner',
        ],
    ];
    */

    /**
     * Model to use by the mapper.
     *
     * @var string
     * @since 1.0.0
     */
    public const MODEL = Tag::class;

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    public const TABLE = 'tag';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    public const PRIMARYFIELD ='tag_id';
}
