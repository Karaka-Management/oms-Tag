<?php
/**
 * Jingga
 *
 * PHP Version 8.1
 *
 * @package   tests
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
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
#[\PHPUnit\Framework\Attributes\CoversClass(\Modules\Tag\Models\TagMapper::class)]
final class TagMapperTest extends \PHPUnit\Framework\TestCase
{
    #[\PHPUnit\Framework\Attributes\Group('module')]
    public function testCR() : void
    {
        $tag = new Tag();
        $tag->setL11n('TestTag');
        $tag->color = '#ff0000ff';
        $tag->type  = TagType::SINGLE;

        $id = TagMapper::create()->execute($tag);
        self::assertGreaterThan(0, $tag->id);
        self::assertEquals($id, $tag->id);

        $tagR = TagMapper::get()->with('title')->where('id', $tag->id)->where('title/language', ISO639x1Enum::_EN)->execute();
        self::assertEquals($tag->getL11n(), $tagR->getL11n());
        self::assertEquals($tag->color, $tagR->color);
        self::assertEquals($tag->type, $tagR->type);
    }
}
