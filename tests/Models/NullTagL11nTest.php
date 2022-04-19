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
 * @link      https://karaka.app
 */
declare(strict_types=1);

namespace Modules\Tag\tests\Models;

use Modules\Tag\Models\NullTagL11n;

/**
 * @internal
 */
final class NullTagL11nTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @covers Modules\Tag\Models\NullTagL11n
     * @group framework
     */
    public function testNull() : void
    {
        self::assertInstanceOf('\Modules\Tag\Models\TagL11n', new NullTagL11n());
    }

    /**
     * @covers Modules\Tag\Models\NullTagL11n
     * @group framework
     */
    public function testId() : void
    {
        $null = new NullTagL11n(2);
        self::assertEquals(2, $null->getId());
    }
}
