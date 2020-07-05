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

use Modules\Tag\Models\Tag;
use Modules\Tag\Models\TagType;
use Modules\Tag\Models\TagMapper;

/**
 * @internal
 */
class TagMapperTest extends \PHPUnit\Framework\TestCase
{
    public function testCR() : void
    {
        $tag = new Tag();
        $tag->setTitle('TestTag');
        $tag->setColor('#ff0000ff');
        $tag->setType(TagType::SINGLE);

        $id = TagMapper::create($tag);
        self::assertGreaterThan(0, $tag->getId());
        self::assertEquals($id, $tag->getId());

        $tagR = TagMapper::get($tag->getId());
        self::assertEquals($tag->getTitle(), $tagR->getTitle());
        self::assertEquals($tag->getColor(), $tagR->getColor());
        self::assertEquals($tag->getType(), $tagR->getType());
    }
}