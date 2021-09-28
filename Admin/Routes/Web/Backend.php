<?php
/**
 * Orange Management
 *
 * PHP Version 8.0
 *
 * @package   Modules
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

use Modules\Tag\Controller\BackendController;
use Modules\Tag\Models\PermissionState;
use phpOMS\Account\PermissionType;
use phpOMS\Router\RouteVerb;

return [
    '^.*/tag/create.*$' => [
        [
            'dest'       => '\Modules\Tag\Controller\BackendController:viewTagCreate',
            'verb'       => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::CREATE,
                'state'  => PermissionState::TAG,
            ],
        ],
    ],
    '^.*/tag/list.*$' => [
        [
            'dest'       => '\Modules\Tag\Controller\BackendController:viewTagList',
            'verb'       => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionState::TAG,
            ],
        ],
    ],
    '^.*/tag/single.*$' => [
        [
            'dest'       => '\Modules\Tag\Controller\BackendController:viewTagSingle',
            'verb'       => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionState::TAG,
            ],
        ],
    ],
];
