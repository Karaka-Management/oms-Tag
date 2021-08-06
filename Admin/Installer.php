<?php
/**
 * Orange Management
 *
 * PHP Version 8.0
 *
 * @package   Modules\Tag\Admin
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

namespace Modules\Tag\Admin;

use Model\Setting;
use Model\SettingMapper;
use phpOMS\Config\SettingsInterface;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\Module\InstallerAbstract;
use phpOMS\Module\ModuleInfo;

/**
 * Installer class.
 *
 * @package Modules\Tag\Admin
 * @license OMS License 1.0
 * @link    https://orange-management.org
 * @since   1.0.0
 */
final class Installer extends InstallerAbstract
{
    /**
     * {@inheritdoc}
     */
    public static function install(DatabasePool $dbPool, ModuleInfo $info, SettingsInterface $cfgHandler) : void
    {
        parent::install($dbPool, $info, $cfgHandler);

        self::installDefaultColors($info, $cfgHandler);
    }

    /**
     * Installing default tag colors
     *
     * @return void
     */
    private static function installDefaultColors() : void
    {
        $setting = new Setting();
        SettingMapper::create($setting->with(0, '1007500001', '#ff000000;#ff00ff00;#ffffffff', 'Tag'));
    }
}
