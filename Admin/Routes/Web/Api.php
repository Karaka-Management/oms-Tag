<?php
/**
 * Karaka
 *
 * PHP Version 8.0
 *
 * @package   Modules
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://karaka.app
 */
declare(strict_types=1);

use Modules\Tag\Controller\ApiController;
use Modules\Tag\Models\PermissionState;
use phpOMS\Account\PermissionType;
use phpOMS\Router\RouteVerb;

return [
    '^.*/tag$' => [
        [
            'dest'       => '\Modules\Tag\Controller\ApiController:apiTagCreate',
            'verb'       => RouteVerb::PUT,
            'permission' => [
                'module' => ApiController::NAME,
                'type'   => PermissionType::CREATE,
                'state'  => PermissionState::TAG,
            ],
        ],
        [
            'dest'       => '\Modules\Tag\Controller\ApiController:apiTagUpdate',
            'verb'       => RouteVerb::SET,
            'permission' => [
                'module' => ApiController::NAME,
                'type'   => PermissionType::MODIFY,
                'state'  => PermissionState::TAG,
            ],
        ],
        [
            'dest'       => '\Modules\Tag\Controller\ApiController:apiTagDelete',
            'verb'       => RouteVerb::DELETE,
            'permission' => [
                'module' => ApiController::NAME,
                'type'   => PermissionType::DELETE,
                'state'  => PermissionState::TAG,
            ],
        ],
    ],
    '^.*/tag/find.*$' => [
        [
            'dest'       => '\Modules\Tag\Controller\ApiController:apiTagFind',
            'verb'       => RouteVerb::GET,
            'permission' => [
                'module' => ApiController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionState::TAG,
            ],
        ],
    ],
];
