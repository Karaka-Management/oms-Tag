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
final class TagTest extends \PHPUnit\Framework\TestCase
{
    private Tag $tag;

    /**
     * {@inheritdoc}
     */
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
        self::assertEquals(null, $this->tag->owner);
        self::assertEquals(TagType::SINGLE, $this->tag->getType());
        self::assertEquals('00000000', $this->tag->color);
        self::assertEquals('', $this->tag->getL11n());
    }

    /**
     * @covers Modules\Tag\Models\Tag
     * @group module
     */
    public function testTitleInputOutput() : void
    {
        $this->tag->setL11n('Test');
        self::assertEquals('Test', $this->tag->getL11n());

        $this->tag->setL11n(new TagL11n('Test2'));
        self::assertEquals('Test2', $this->tag->getL11n());

        $this->tag->setL11n('Test3');
        self::assertEquals('Test3', $this->tag->getL11n());
    }

    /**
     * @covers Modules\Tag\Models\Tag
     * @group module
     */
    public function testOwnerInputOutput() : void
    {
        $this->tag->owner = new NullAccount(2);
        self::assertEquals(2, $this->tag->owner->getId());
    }

    /**
     * @covers Modules\Tag\Models\Tag
     * @group module
     */
    public function testColorInputOutput() : void
    {
        $this->tag->color = 'ffffffff';
        self::assertEquals('ffffffff', $this->tag->color);
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
        $this->tag->setL11n($t = new TagL11n('Test'));
        $this->tag->owner = new NullAccount(2);
        $this->tag->color = 'ffffffff';
        $this->tag->setType(TagType::SHARED);

        self::assertEquals(
            [
                'id'    => 0,
                'title' => $t,
                'color' => 'ffffffff',
                'type'  => TagType::SHARED,
                'owner' => $this->tag->owner,
            ],
            $this->tag->jsonSerialize()
        );
    }
}
