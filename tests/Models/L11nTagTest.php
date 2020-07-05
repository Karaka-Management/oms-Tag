<?php
/**
 * Orange Management
 *
 * PHP Version 7.4
 *
 * @package   tests
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

namespace Modules\Tag\tests\Models;

use Modules\Tag\Models\L11nTag;
use phpOMS\Localization\ISO639x1Enum;

/**
 * @internal
 */
class L11nTagTest extends \PHPUnit\Framework\TestCase
{
    public function testDefault() : void
    {
        $tag = new L11nTag();

        self::assertEquals(0, $tag->getId());
        self::assertEquals(0, $tag->getTag());
        self::assertEquals('', $tag->getTitle());
        self::assertEquals(ISO639x1Enum::_EN, $tag->getLanguage());
        self::assertEquals(
            [
                'id' => 0,
                'title' => '',
                'tag' => 0,
                'language' => ISO639x1Enum::_EN,
            ],
            $tag->toArray()
        );
        self::assertEquals(
            [
                'id' => 0,
                'title' => '',
                'tag' => 0,
                'language' => ISO639x1Enum::_EN,
            ],
            $tag->jsonSerialize()
        );
    }
}
