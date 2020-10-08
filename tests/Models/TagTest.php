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

use Modules\Admin\Models\NullAccount;
use Modules\Tag\Models\Tag;
use Modules\Tag\Models\TagType;

/**
 * @internal
 */
class TagTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @covers Modules\Tag\Models\Tag
     * @group module
     */
    public function testDefault() : void
    {
        $tag = new Tag();

        self::assertEquals(0, $tag->getId());
        self::assertInstanceOf(NullAccount::class, $tag->getOwner());
        self::assertEquals(TagType::SINGLE, $tag->getType());
        self::assertEquals('00000000', $tag->getColor());
        self::assertEquals('', $tag->getTitle());
        self::assertEquals(
            [
                'id'    => 0,
                'title' => '',
                'color' => '00000000',
            ],
            $tag->toArray()
        );
        self::assertEquals(
            [
                'id'    => 0,
                'title' => '',
                'color' => '00000000',
            ],
            $tag->jsonSerialize()
        );
    }

    /**
     * @covers Modules\Tag\Models\Tag
     * @group module
     */
    public function testTitleInputOutput() : void
    {
        $tag = new Tag();

        $tag->setTitle('Test');
        self::assertEquals('Test', $tag->getTitle());
    }

    /**
     * @covers Modules\Tag\Models\Tag
     * @group module
     */
    public function testColorInputOutput() : void
    {
        $tag = new Tag();

        $tag->setColor('ffffffff');
        self::assertEquals('ffffffff', $tag->getColor());
    }

    /**
     * @covers Modules\Tag\Models\Tag
     * @group module
     */
    public function testTypeInputOutput() : void
    {
        $tag = new Tag();

        $tag->setType(TagType::SHARED);
        self::assertEquals(TagType::SHARED, $tag->getType());
    }
}
