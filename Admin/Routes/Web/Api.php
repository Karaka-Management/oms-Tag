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

use Modules\Tag\Controller\ApiController;
use Modules\Tag\Models\PermissionCategory;
use phpOMS\Account\PermissionType;
use phpOMS\Router\RouteVerb;

return [
    '^.*/tag$' => [
        [
            'dest'       => '\Modules\Tag\Controller\ApiController:apiTagCreate',
            'verb'       => RouteVerb::PUT,
            'csrf'       => true,
            'permission' => [
                'module' => ApiController::NAME,
                'type'   => PermissionType::CREATE,
                'state'  => PermissionCategory::TAG,
            ],
        ],
        [
            'dest'       => '\Modules\Tag\Controller\ApiController:apiTagUpdate',
            'verb'       => RouteVerb::SET,
            'csrf'       => true,
            'permission' => [
                'module' => ApiController::NAME,
                'type'   => PermissionType::MODIFY,
                'state'  => PermissionCategory::TAG,
            ],
        ],
        [
            'dest'       => '\Modules\Tag\Controller\ApiController:apiTagDelete',
            'verb'       => RouteVerb::DELETE,
            'csrf'       => true,
            'permission' => [
                'module' => ApiController::NAME,
                'type'   => PermissionType::DELETE,
                'state'  => PermissionCategory::TAG,
            ],
        ],
    ],
    '^.*/tag/find(\?.*$|$)' => [
        [
            'dest'       => '\Modules\Tag\Controller\ApiController:apiTagFind',
            'verb'       => RouteVerb::GET,
            'csrf'       => true,
            'permission' => [
                'module' => ApiController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::TAG,
            ],
        ],
    ],
    '^.*/tag/l11n$' => [
        [
            'dest'       => '\Modules\Tag\Controller\ApiController:apiTagL11nCreate',
            'verb'       => RouteVerb::PUT,
            'csrf'       => true,
            'permission' => [
                'module' => ApiController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::TAG,
            ],
        ],
        [
            'dest'       => '\Modules\Tag\Controller\ApiController:apiTagL11nUpdate',
            'verb'       => RouteVerb::SET,
            'csrf'       => true,
            'permission' => [
                'module' => ApiController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::TAG,
            ],
        ],
    ],
];
