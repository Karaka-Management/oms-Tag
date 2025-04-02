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

use phpOMS\Stdlib\Base\Enum;

/**
 * Module settings enum.
 *
 * @package  Modules\Tag\Models
 * @license OMS License 2.2
 * @link    https://jingga.app
 * @since   1.0.0
 */
abstract class SettingsEnum extends Enum
{
    public const TAG_COLOR_PALLET = '1007500001';
}
