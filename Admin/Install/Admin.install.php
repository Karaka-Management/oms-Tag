<?php
/**
 * Jingga
 *
 * PHP Version 8.1
 *
 * @package   Modules\Tag\Admin
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

use Modules\Tag\Controller\ApiController;
use Modules\Tag\Models\SettingsEnum;

return [
    [
        'type'    => 'setting',
        'name'    => SettingsEnum::TAG_COLOR_PALLET,
        'content' => '["#ff000000","#ff00ff00","#ffffffff"]',
        'pattern' => '/(#[a-fA-F0-9]{8};)*(#[a-fA-F0-9]{8})/',
        'module'  => ApiController::NAME,
    ],
];
