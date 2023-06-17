<?php
/**
 * Jingga
 *
 * PHP Version 8.1
 *
 * @package   Modules\Tag\Models
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\Tag\Models;

use Modules\Admin\Models\Account;
use phpOMS\Localization\BaseStringL11n;
use phpOMS\Localization\ISO639x1Enum;

/**
 * Tag class.
 *
 * @package Modules\Tag\Models
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
class Tag implements \JsonSerializable
{
    /**
     * Article ID.
     *
     * @var int
     * @since 1.0.0
     */
    public int $id = 0;

    /**
     * Title.
     *
     * @var string|BaseStringL11n
     * @since 1.0.0
     */
    public string | BaseStringL11n $title = '';

    /**
     * Color RGBA.
     *
     * @var string
     * @since 1.0.0
     */
    public string $color = '00000000';

    /**
     * Icon.
     *
     * @var string
     * @since 1.0.0
     */
    public string $icon = '';

    /**
     * Creator.
     *
     * @var null|Account
     * @since 1.0.0
     */
    public ?Account $owner = null;

    /**
     * Tag type.
     *
     * @var int
     * @since 1.0.0
     */
    public int $type = TagType::SINGLE;

    /**
     * Get type.
     *
     * @return int
     *
     * @since 1.0.0
     */
    public function getType() : int
    {
        return $this->type;
    }

    /**
     * Set type.
     *
     * @param int $type Tag type
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function setType(int $type = TagType::SINGLE) : void
    {
        $this->type = $type;
    }

    /**
     * @return string
     *
     * @since 1.0.0
     */
    public function getL11n() : string
    {
        return $this->title instanceof BaseStringL11n ? $this->title->content : $this->title;
    }

    /**
     * Set title
     *
     * @param string|BaseStringL11n $title Tag article title
     * @param string                $lang  Language
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function setL11n(string | BaseStringL11n $title, string $lang = ISO639x1Enum::_EN) : void
    {
        if ($title instanceof BaseStringL11n) {
            $this->title = $title;
        } elseif (isset($this->title) && $this->title instanceof BaseStringL11n) {
            $this->title->content = $title;
        } else {
            $this->title          = new BaseStringL11n();
            $this->title->content = $title;
            $this->title->setLanguage($lang);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function toArray() : array
    {
        return [
            'id'    => $this->id,
            'title' => $this->title,
            'color' => $this->color,
            'type'  => $this->type,
            'owner' => $this->owner,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize() : mixed
    {
        return $this->toArray();
    }
}
