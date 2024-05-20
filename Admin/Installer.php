<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\Tag\Admin
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.2
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\Tag\Admin;

use phpOMS\Application\ApplicationAbstract;
use phpOMS\Config\SettingsInterface;
use phpOMS\Message\Http\HttpRequest;
use phpOMS\Message\Http\HttpResponse;
use phpOMS\Module\InstallerAbstract;
use phpOMS\Module\ModuleInfo;
use phpOMS\System\File\PathException;

/**
 * Installer class.
 *
 * @package Modules\Tag\Admin
 * @license OMS License 2.2
 * @link    https://jingga.app
 * @since   1.0.0
 */
final class Installer extends InstallerAbstract
{
    /**
     * Path of the file
     *
     * @var string
     * @since 1.0.0
     */
    public const PATH = __DIR__;

    /**
     * Install data from providing modules.
     *
     * The data can be either directories which should be created or files which should be "uploaded"
     *
     * @param ApplicationAbstract $app  Application
     * @param array               $data Additional data
     *
     * @return array
     *
     * @throws PathException
     * @throws \Exception
     *
     * @since 1.0.0
     */
    public static function installExternal(ApplicationAbstract $app, array $data) : array
    {
        if (!\is_file($data['path'] ?? '')) {
            throw new PathException($data['path'] ?? '');
        }

        $tagFile = \file_get_contents($data['path'] ?? '');
        if ($tagFile === false) {
            throw new PathException($data['path'] ?? ''); // @codeCoverageIgnore
        }

        $tagData = \json_decode($tagFile, true) ?? [];
        if (!\is_array($tagData)) {
            throw new \Exception(); // @codeCoverageIgnore
        }

        /** @var \Modules\Tag\Controller\ApiController $module */
        $module = $app->moduleManager->get('Tag', 'Api');

        $tags = [];

        foreach ($tagData as $tag) {
            $response = new HttpResponse();
            $request  = new HttpRequest();

            $request->header->account = 1;
            $request->setData('name', $tag['name'] ?? '');
            $request->setData('color', $tag['color'] ?? '#3697db');

            if (!empty($tag['l11n'])) {
                $request->setData('title', \reset($tag['l11n']));
                $request->setData('lang', \array_keys($tag['l11n'])[0] ?? 'en');
            }

            $module->apiTagCreate($request, $response);

            $responseData = $response->getData('');
            if (!\is_array($responseData)) {
                return [];
            }

            $type = $responseData['response'];
            $id   = $type->id;

            $isFirst = true;
            foreach ($tag['l11n'] as $language => $l11n) {
                if ($isFirst) {
                    $isFirst = false;
                    continue;
                }

                $response = new HttpResponse();
                $request  = new HttpRequest();

                $request->header->account = 1;
                $request->setData('title', $l11n);
                $request->setData('lang', $language);
                $request->setData('type', $id);

                $module->apiTagL11nCreate($request, $response);
            }

            $tags[] = \is_array($type)
                ? $type
                : $type->toArray();
        }

        return $tags;
    }
}
