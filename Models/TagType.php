<?php
/**
 * Jingga
 *
 * PHP Version 8.1
 *
 * @package   Modules\Tag\Models
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\Tag\Models;

use phpOMS\Stdlib\Base\Enum;

/**
 * Tag type enum.
 *
 * @package Modules\Tag\Models
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
abstract class TagType extends Enum
{
    public const SINGLE = 1;

    public const SHARED = 2;
}
