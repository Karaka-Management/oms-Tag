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
    private L11nTag $l11n;

    public function setUp() : void
    {
        $this->l11n = new L11nTag();
    }

    /**
     * @covers Modules\Tag\Models\L11nTag
     * @group module
     */
    public function testDefault() : void
    {
        self::assertEquals(0, $this->l11n->getId());
        self::assertEquals(0, $this->l11n->getTag());
        self::assertEquals('', $this->l11n->getTitle());
        self::assertEquals(ISO639x1Enum::_EN, $this->l11n->getLanguage());
    }

    /**
     * @covers Modules\Tag\Models\L11nTag
     * @group module
     */
    public function testTagInputOutput() : void
    {
        $this->l11n->setTag(2);
        self::assertEquals(2, $this->l11n->getTag());
    }

    /**
     * @covers Modules\Tag\Models\L11nTag
     * @group module
     */
    public function testLanguageInputOutput() : void
    {
        $this->l11n->setLanguage(ISO639x1Enum::_DE);
        self::assertEquals(ISO639x1Enum::_DE, $this->l11n->getLanguage());
    }

    /**
     * @covers Modules\Tag\Models\L11nTag
     * @group module
     */
    public function testTitleInputOutput() : void
    {
        $this->l11n->setTitle('Title');
        self::assertEquals('Title', $this->l11n->getTitle());
    }

    /**
     * @covers Modules\Tag\Models\L11nTag
     * @group module
     */
    public function testSerialize() : void
    {
        $this->l11n->setTitle('Title');
        $this->l11n->setTag(2);
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
