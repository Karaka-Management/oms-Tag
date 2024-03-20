<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

use Modules\Tag\Controller\BackendController;
use Modules\Tag\Models\PermissionCategory;
use phpOMS\Account\PermissionType;
use phpOMS\Router\RouteVerb;

return [
    '^.*/tag/create(\?.*$|$)' => [
        [
            'dest'       => '\Modules\Tag\Controller\BackendController:viewTagCreate',
            'verb'       => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::CREATE,
                'state'  => PermissionCategory::TAG,
            ],
        ],
    ],
    '^.*/tag/list(\?.*$|$)' => [
        [
            'dest'       => '\Modules\Tag\Controller\BackendController:viewTagList',
            'verb'       => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::TAG,
            ],
        ],
    ],
    '^.*/tag/view(\?.*$|$)' => [
        [
            'dest'       => '\Modules\Tag\Controller\BackendController:viewTagView',
            'verb'       => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::TAG,
            ],
        ],
    ],
];
