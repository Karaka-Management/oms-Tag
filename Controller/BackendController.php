<?php
/**
 * Orange Management
 *
 * PHP Version 7.4
 *
 * @package   Modules\Tag
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

namespace Modules\Tag\Controller;

use Modules\Tag\Models\L11nTagMapper;

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
 * @link    https://orange-management.org
 * @since   1.0.0
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

        if ($request->getData('ptype') === '-') {
            $view->setData('tags',
                TagMapper::withConditional('language', $response->getHeader()->getL11n()->getLanguage())
                    ::getBeforePivot((int) ($request->getData('id') ?? 0), null, 25)
            );
        } else {
            $view->setData('tags',
                TagMapper::withConditional('language', $response->getHeader()->getL11n()->getLanguage())
                    ::getAfterPivot((int) ($request->getData('id') ?? 0), null, 25)
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
        $tag  = TagMapper::withConditional('language', $response->getHeader()->getL11n()->getLanguage())::get((int) $request->getData('id'));

        $view->setTemplate('/Modules/Tag/Theme/Backend/tag-single');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1007501001, $request, $response));
        $view->addData('tag', $tag);

        $l11n = L11nTagMapper::withConditional('tag', $tag->getId())::getAll();
        $view->addData('l11n', $l11n);

        return $view;
    }
}
