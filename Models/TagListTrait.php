<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\Tag\Models
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.2
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\Tag\Models;

/**
 * Tag class.
 *
 * @package Modules\Tag\Models
 * @license OMS License 2.2
 * @link    https://jingga.app
 * @since   1.0.0
 *
 * @property \Modules\Tag\Models\Tag[] $tags
 */
trait TagListTrait
{
    /**
     * Tags.
     *
     * @var Tag[]
     * @since 1.0.0
     */
    public array $tags = [];

    /**
     * Get media tag by type
     *
     * @param int $type Tag type
     *
     * @return Tag
     *
     * @since 1.0.0
     */
    public function getTagByType(int $type) : Tag
    {
        foreach ($this->tags as $tag) {
            if ($tag->id === $type) {
                return $tag;
            }
        }

        return new NullTag();
    }

    /**
     * Get all media tags by type name
     *
     * @param string $type Tag type
     *
     * @return Tag
     *
     * @since 1.0.0
     */
    public function getTagByTypeName(string $type) : Tag
    {
        foreach ($this->tags as $tag) {
            if ($tag->name === $type) {
                return $tag;
            }
        }

        return new NullTag();
    }

    /**
     * Get all media tags by type name
     *
     * @param string $type Tag type
     *
     * @return Tag[]
     *
     * @since 1.0.0
     */
    public function getTagsByTypeName(string $type) : array
    {
        $tags = [];
        foreach ($this->tags as $tag) {
            if ($tag->name === $type) {
                $tags[] = $tag;
            }
        }

        return $tags;
    }

    /**
     * Check if tag with a certain type name exists
     *
     * @param string $type Type name
     *
     * @return bool
     *
     * @since 1.0.0
     */
    public function hasTagTypeName(string $type) : bool
    {
        foreach ($this->tags as $tag) {
            if ($tag->name === $type) {
                return true;
            }
        }

        return false;
    }
}
