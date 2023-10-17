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

use Modules\Tag\Models\NullTag;

/**
 * @internal
 */
final class NullTagTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @covers Modules\Tag\Models\NullTag
     * @group module
     */
    public function testNull() : void
    {
        self::assertInstanceOf('\Modules\Tag\Models\Tag', new NullTag());
    }

    /**
     * @covers Modules\Tag\Models\NullTag
     * @group module
     */
    public function testId() : void
    {
        $null = new NullTag(2);
        self::assertEquals(2, $null->id);
    }

    /**
     * @covers Modules\Tag\Models\NullTag
     * @group module
     */
    public function testJsonSerialize() : void
    {
        $null = new NullTag(2);
        self::assertEquals(['id' => 2], $null->jsonSerialize());
    }
}
