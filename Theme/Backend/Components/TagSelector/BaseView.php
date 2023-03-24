<?php
/**
 * Karaka
 *
 * PHP Version 8.1
 *
 * @package   Modules\Tag
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\Tag\Theme\Backend\Components\TagSelector;

use phpOMS\Localization\L11nManager;
use phpOMS\Message\RequestAbstract;
use phpOMS\Message\ResponseAbstract;
use phpOMS\Views\View;

/**
 * Component view.
 *
 * @package Modules\Tag
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 * @codeCoverageIgnore
 */
class BaseView extends View
{
    /**
     * Dom id
     *
     * @var string
     * @since 1.0.0
     */
    private string $id = '';

    /**
     * Is required?
     *
     * @var bool
     * @since 1.0.0
     */
    private bool $isRequired = false;

    /**
     * Dom form
     *
     * @var string
     * @since 1.0.0
     */
    private string $form = '';

    /**
     * Dom name
     *
     * @var string
     * @since 1.0.0
     */
    public string $name = '';

    /**
     * {@inheritdoc}
     */
    public function __construct(L11nManager $l11n = null, RequestAbstract $request, ResponseAbstract $response)
    {
        parent::__construct($l11n, $request, $response);
        $this->setTemplate('/Modules/Tag/Theme/Backend/Components/TagSelector/base');
    }

    /**
     * Get selector id
     *
     * @return string
     *
     * @since 1.0.0
     */
    public function getId() : string
    {
        return $this->id;
    }

    /**
     * Get form
     *
     * @return string
     *
     * @since 1.0.0
     */
    public function getForm() : string
    {
        return $this->form;
    }

    /**
     * Is required?
     *
     * @return bool
     *
     * @since 1.0.0
     */
    public function isRequired() : bool
    {
        return $this->isRequired;
    }

    /**
     * {@inheritdoc}
     */
    public function render(mixed ...$data) : string
    {
        /** @var array{0:string, 1:string, 2:string, 3:null|bool} $data */
        $this->id         = $data[0];
        $this->name       = $data[1];
        $this->form       = $data[2];
        $this->isRequired = $data[3] ?? false;
        return parent::render();
    }
}
