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

use Modules\Tag\Models\NullTag;

/**
 * @internal
 */
final class Null extends \PHPUnit\Framework\TestCase
{
    /**
     * @covers Modules\Tag\Models\NullTag
     * @group framework
     */
    public function testNull() : void
    {
        self::assertInstanceOf('\Modules\Tag\Models\Tag', new NullTag());
    }

    /**
     * @covers Modules\Tag\Models\NullTag
     * @group framework
     */
    public function testId() : void
    {
        $null = new NullTag(2);
        self::assertEquals(2, $null->getId());
    }
}
