<?php
/**
 * Karaka
 *
 * PHP Version 8.0
 *
 * @package   Modules\Tag
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://karaka.app
 */
declare(strict_types=1);

namespace Modules\Tag\Controller;

use Modules\Tag\Models\TagL11nMapper;
use Modules\Tag\Models\TagMapper;
use phpOMS\Contract\RenderableInterface;
use phpOMS\Message\RequestAbstract;
use phpOMS\Message\ResponseAbstract;
use phpOMS\Views\View;

/**
 * Calendar controller class.
 *
 * @package Modules\Tag
 * @license OMS License 1.0
 * @link    https://karaka.app
 * @since   1.0.0
 * @codeCoverageIgnore
 */
final class BackendController extends Controller
{
    /**
     * Routing end-point for application behaviour.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return RenderableInterface
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function viewTagCreate(RequestAbstract $request, ResponseAbstract $response, $data = null) : RenderableInterface
    {
        $view = new View($this->app->l11nManager, $request, $response);

        $view->setTemplate('/Modules/Tag/Theme/Backend/tag-create');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1007501001, $request, $response));

        return $view;
    }

    /**
     * Routing end-point for application behaviour.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return RenderableInterface
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function viewTagList(RequestAbstract $request, ResponseAbstract $response, $data = null) : RenderableInterface
    {
        $view = new View($this->app->l11nManager, $request, $response);

        $view->setTemplate('/Modules/Tag/Theme/Backend/tag-list');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1007501001, $request, $response));

        if ($request->getData('ptype') === 'p') {
            $view->setData('tags',
                TagMapper::getAll()->with('title')->where('id', (int) ($request->getData('id') ?? 0), '<')->where('title/language', $request->getLanguage())->limit(25)->execute()
            );
        } elseif ($request->getData('ptype') === 'n') {
            $view->setData('tags',
                TagMapper::getAll()->with('title')->where('id', (int) ($request->getData('id') ?? 0), '>')->where('title/language', $request->getLanguage())->limit(25)->execute()
            );
        } else {
            $view->setData('tags',
                TagMapper::getAll()->with('title')->where('id', 0, '>')->where('title/language', $request->getLanguage())->limit(25)->execute()
            );
        }

        return $view;
    }

    /**
     * Routing end-point for application behaviour.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return RenderableInterface
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function viewTagSingle(RequestAbstract $request, ResponseAbstract $response, $data = null) : RenderableInterface
    {
        $view = new View($this->app->l11nManager, $request, $response);
        $tag  = TagMapper::get()->with('title')->where('id', (int) $request->getData('id'))->where('title/language', $response->getLanguage())->execute();

        $view->setTemplate('/Modules/Tag/Theme/Backend/tag-single');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1007501001, $request, $response));
        $view->addData('tag', $tag);

        $l11n = TagL11nMapper::getAll()->where('tag', $tag->getId())->execute();
        $view->addData('l11n', $l11n);

        return $view;
    }
}
