<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\Tag\Models
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.2
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
 * @license OMS License 2.2
 * @link    https://jingga.app
 * @since   1.0.0
 *
 * @template T of Tag
 * @extends DataMapperFactory<T>
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
        'tag_name'  => ['name' => 'tag_name', 'type' => 'string', 'internal' => 'name'],
        'tag_color' => ['name' => 'tag_color', 'type' => 'string', 'internal' => 'color'],
        'tag_icon'  => ['name' => 'tag_icon',  'type' => 'string', 'internal' => 'icon'],
        'tag_type'  => ['name' => 'tag_type',  'type' => 'int',    'internal' => 'type'],
        'tag_owner' => ['name' => 'tag_owner', 'type' => 'int',    'internal' => 'owner'],
    ];

    /**
     * Has many relation.
     *
     * @var array<string, array{mapper:class-string, table:string, self?:?string, external?:?string, column?:string}>
     * @since 1.0.0
     */
    public const HAS_MANY = [
        'title' => [
            'mapper'   => TagL11nMapper::class,
            'table'    => 'tag_l11n',
            'self'     => 'tag_l11n_tag',
            'column'   => 'content',
            'external' => null,
        ],
    ];

    /**
     * Belongs to.
     *
     * @var array<string, array{mapper:class-string, self:string}>
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
     * @var class-string<T>
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
    public const PRIMARYFIELD = 'tag_id';
}
