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

use Modules\Tag\Models\TagL11n;
use phpOMS\Localization\ISO639x1Enum;

/**
 * @internal
 */
class TagL11nTest extends \PHPUnit\Framework\TestCase
{
    private TagL11n $l11n;

    /**
     * {@inheritdoc}
     */
    protected function setUp() : void
    {
        $this->l11n = new TagL11n();
    }

    /**
     * @covers Modules\Tag\Models\TagL11n
     * @group module
     */
    public function testDefault() : void
    {
        self::assertEquals(0, $this->l11n->getId());
        self::assertEquals(0, $this->l11n->tag);
        self::assertEquals('', $this->l11n->title);
        self::assertEquals(ISO639x1Enum::_EN, $this->l11n->getLanguage());
    }

    /**
     * @covers Modules\Tag\Models\TagL11n
     * @group module
     */
    public function testTagInputOutput() : void
    {
        $this->l11n->tag = 2;
        self::assertEquals(2, $this->l11n->tag);
    }

    /**
     * @covers Modules\Tag\Models\TagL11n
     * @group module
     */
    public function testLanguageInputOutput() : void
    {
        $this->l11n->setLanguage(ISO639x1Enum::_DE);
        self::assertEquals(ISO639x1Enum::_DE, $this->l11n->getLanguage());
    }

    /**
     * @covers Modules\Tag\Models\TagL11n
     * @group module
     */
    public function testTitleInputOutput() : void
    {
        $this->l11n->title = 'Title';
        self::assertEquals('Title', $this->l11n->title);
    }

    /**
     * @covers Modules\Tag\Models\TagL11n
     * @group module
     */
    public function testSerialize() : void
    {
        $this->l11n->title = 'Title';
        $this->l11n->tag = 2;
        $this->l11n->setLanguage(ISO639x1Enum::_DE);

        self::assertEquals(
            [
                'id'       => 0,
                'title'    => 'Title',
                'tag'      => 2,
                'language' => ISO639x1Enum::_DE,
            ],
            $this->l11n->jsonSerialize()
        );
    }
}
