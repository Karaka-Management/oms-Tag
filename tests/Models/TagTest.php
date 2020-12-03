<?php
/**
 * Orange Management
 *
 * PHP Version 8.0
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
use Modules\Tag\Models\TagL11n;
use Modules\Tag\Models\TagType;

/**
 * @internal
 */
class TagTest extends \PHPUnit\Framework\TestCase
{
    private Tag $tag;

    protected function setUp() : void
    {
        $this->tag = new Tag();
    }

    /**
     * @covers Modules\Tag\Models\Tag
     * @group module
     */
    public function testDefault() : void
    {
        self::assertEquals(0, $this->tag->getId());
        self::assertInstanceOf(NullAccount::class, $this->tag->getOwner());
        self::assertEquals(TagType::SINGLE, $this->tag->getType());
        self::assertEquals('00000000', $this->tag->getColor());
        self::assertEquals('', $this->tag->getTitle());
    }

    /**
     * @covers Modules\Tag\Models\Tag
     * @group module
     */
    public function testTitleInputOutput() : void
    {
        $this->tag->setTitle('Test');
        self::assertEquals('Test', $this->tag->getTitle());

        $this->tag->setTitle(new TagL11n('Test2'));
        self::assertEquals('Test2', $this->tag->getTitle());

        $this->tag->setTitle('Test3');
        self::assertEquals('Test3', $this->tag->getTitle());
    }

    /**
     * @covers Modules\Tag\Models\Tag
     * @group module
     */
    public function testOwnerInputOutput() : void
    {
        $this->tag->setOwner(new NullAccount(2));
        self::assertEquals(2, $this->tag->getOwner()->getId());
    }

    /**
     * @covers Modules\Tag\Models\Tag
     * @group module
     */
    public function testColorInputOutput() : void
    {
        $this->tag->setColor('ffffffff');
        self::assertEquals('ffffffff', $this->tag->getColor());
    }

    /**
     * @covers Modules\Tag\Models\Tag
     * @group module
     */
    public function testTypeInputOutput() : void
    {
        $this->tag->setType(TagType::SHARED);
        self::assertEquals(TagType::SHARED, $this->tag->getType());
    }

    /**
     * @covers Modules\Tag\Models\Tag
     * @group module
     */
    public function testSerialize() : void
    {
        $this->tag->setTitle($t = new TagL11n('Test'));
        $this->tag->setOwner($a = new NullAccount(2));
        $this->tag->setColor('ffffffff');
        $this->tag->setType(TagType::SHARED);

        self::assertEquals(
            [
                'id'    => 0,
                'title' => $t,
                'color' => 'ffffffff',
                'type'  => TagType::SHARED,
                'owner' => $a,
            ],
            $this->tag->jsonSerialize()
        );
    }
}
