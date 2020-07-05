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
use Modules\Tag\Models\L11nTagMapper;
use Modules\Tag\Models\Tag;
use Modules\Tag\Models\TagType;
use Modules\Tag\Models\TagMapper;
use phpOMS\Localization\ISO639x1Enum;

/**
 * @internal
 */
class L11nTagMapperTest extends \PHPUnit\Framework\TestCase
{
    public function testCR() : void
    {
        $tag = new Tag();
        $tag->setColor('ffffffff');
        $tag->setType(TagType::SINGLE);

        $id = TagMapper::create($tag);
        self::assertGreaterThan(0, $tag->getId());
        self::assertEquals($id, $tag->getId());

        $l11n = new L11nTag();
        $l11n->setTitle('TestTitle');
        $l11n->setLanguage(ISO639x1Enum::_EN);
        $l11n->setTag($id);

        $id = L11nTagMapper::create($l11n);
        self::assertGreaterThan(0, $l11n->getId());
        self::assertEquals($id, $l11n->getId());

        $l11nR = L11nTagMapper::get($l11n->getId());
        self::assertEquals($l11n->getTitle(), $l11nR->getTitle());
        self::assertEquals($l11n->getLanguage(), $l11nR->getLanguage());
    }
}
