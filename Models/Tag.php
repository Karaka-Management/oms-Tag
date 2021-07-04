<?php
/**
 * Orange Management
 *
 * PHP Version 8.0
 *
 * @package   Modules\Tag\Models
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

namespace Modules\Tag\Models;

use Modules\Admin\Models\Account;
use Modules\Admin\Models\NullAccount;
use phpOMS\Contract\ArrayableInterface;
use phpOMS\Localization\ISO639x1Enum;

/**
 * Tag class.
 *
 * @package Modules\Tag\Models
 * @license OMS License 1.0
 * @link    https://orange-management.org
 * @since   1.0.0
 */
class Tag implements \JsonSerializable, ArrayableInterface
{
    /**
     * Article ID.
     *
     * @var int
     * @since 1.0.0
     */
    protected int $id = 0;

    /**
     * Title.
     *
     * @var string|TagL11n
     * @since 1.0.0
     */
    protected $title = '';

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
     * @var null|string
     * @since 1.0.0
     */
    public ?string $icon = null;

    /**
     * Creator.
     *
     * @var null|Account
     * @since 1.0.0
     */
    protected ?Account $owner = null;

    /**
     * Tag type.
     *
     * @var int
     * @since 1.0.0
     */
    protected int $type = TagType::SINGLE;

    /**
     * Get created by
     *
     * @return Account
     *
     * @since 1.0.0
     */
    public function getOwner() : Account
    {
        return $this->owner ?? new NullAccount();
    }

    /**
     * Set created by
     *
     * @param Account $id Created by
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function setOwner(Account $id) : void
    {
        $this->owner = $id;
    }

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
     * Get id
     *
     * @return int
     *
     * @since 1.0.0
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @return string
     *
     * @since 1.0.0
     */
    public function getL11n() : string
    {
        return $this->title instanceof TagL11n ? $this->title->title : $this->title;
    }

    /**
     * Set title
     *
     * @param string|TagL11n $title Tag article title
     * @param string         $lang  Language
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function setL11n(string | TagL11n $title, string $lang = ISO639x1Enum::_EN) : void
    {
        if ($title instanceof TagL11n) {
            $this->title = $title;
        } elseif (isset($this->title) && $this->title instanceof TagL11n) {
            $this->title->title = $title;
        } else {
            $this->title        = new TagL11n();
            $this->title->title = $title;
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
    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
