<?php
/**
 * Karaka
 *
 * PHP Version 8.1
 *
 * @package   tests
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://karaka.app
 */
declare(strict_types=1);

namespace Modules\Tag\tests\Models;

use Modules\Tag\Models\Tag;
use Modules\Tag\Models\TagMapper;
use Modules\Tag\Models\TagType;
use phpOMS\Localization\ISO639x1Enum;

/**
 * @internal
 */
final class TagMapperTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @covers Modules\Tag\Models\TagMapper
     * @group module
     */
    public function testCR() : void
    {
        $tag = new Tag();
        $tag->setL11n('TestTag');
        $tag->color = '#ff0000ff';
        $tag->setType(TagType::SINGLE);

        $id = TagMapper::create()->execute($tag);
        self::assertGreaterThan(0, $tag->getId());
        self::assertEquals($id, $tag->getId());

        $tagR = TagMapper::get()->with('title')->where('id', $tag->getId())->where('title/language', ISO639x1Enum::_EN)->execute();
        self::assertEquals($tag->getL11n(), $tagR->getL11n());
        self::assertEquals($tag->color, $tagR->color);
        self::assertEquals($tag->getType(), $tagR->getType());
    }
}
