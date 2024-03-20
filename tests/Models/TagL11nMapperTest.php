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
use Modules\Tag\Models\TagL11nMapper;
use Modules\Tag\Models\TagMapper;
use Modules\Tag\Models\TagType;
use phpOMS\Localization\BaseStringL11n;
use phpOMS\Localization\ISO639x1Enum;

/**
 * @internal
 */
#[\PHPUnit\Framework\Attributes\CoversClass(\Modules\Tag\Models\TagL11nMapper::class)]
final class TagL11nMapperTest extends \PHPUnit\Framework\TestCase
{
    #[\PHPUnit\Framework\Attributes\Group('module')]
    public function testCR() : void
    {
        $tag        = new Tag();
        $tag->color = '#ffffffff';
        $tag->type  = TagType::SINGLE;

        $id = TagMapper::create()->execute($tag);
        self::assertGreaterThan(0, $tag->id);
        self::assertEquals($id, $tag->id);

        $l11n           = new BaseStringL11n();
        $l11n->content  = 'TestTitle';
        $l11n->language = ISO639x1Enum::_EN;
        $l11n->ref      = $id;

        $id = TagL11nMapper::create()->execute($l11n);
        self::assertGreaterThan(0, $l11n->id);
        self::assertEquals($id, $l11n->id);

        $l11nR = TagL11nMapper::get()->where('id', $l11n->id)->execute();
        self::assertEquals($l11n->content, $l11nR->content);
        self::assertEquals($l11n->language, $l11nR->language);
    }
}
