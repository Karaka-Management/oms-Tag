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
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\Tag\tests\Models;

use Modules\Tag\Models\Tag;
use Modules\Tag\Models\TagL11n;
use Modules\Tag\Models\TagL11nMapper;
use Modules\Tag\Models\TagMapper;
use Modules\Tag\Models\TagType;
use phpOMS\Localization\ISO639x1Enum;

/**
 * @internal
 */
final class TagL11nMapperTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @covers Modules\Tag\Models\TagL11nMapper
     * @group module
     */
    public function testCR() : void
    {
        $tag        = new Tag();
        $tag->color = '#ffffffff';
        $tag->setType(TagType::SINGLE);

        $id = TagMapper::create()->execute($tag);
        self::assertGreaterThan(0, $tag->getId());
        self::assertEquals($id, $tag->getId());

        $l11n        = new TagL11n();
        $l11n->title = 'TestTitle';
        $l11n->setLanguage(ISO639x1Enum::_EN);
        $l11n->tag = $id;

        $id = TagL11nMapper::create()->execute($l11n);
        self::assertGreaterThan(0, $l11n->getId());
        self::assertEquals($id, $l11n->getId());

        $l11nR = TagL11nMapper::get()->where('id', $l11n->getId())->execute();
        self::assertEquals($l11n->title, $l11nR->title);
        self::assertEquals($l11n->getLanguage(), $l11nR->getLanguage());
    }
}
