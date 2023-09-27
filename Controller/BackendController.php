<?php
/**
 * Jingga
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
 * @license OMS License 2.0
 * @link    https://jingga.app
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
     * @param array            $data     Generic data
     *
     * @return RenderableInterface
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function viewTagCreate(RequestAbstract $request, ResponseAbstract $response, array $data = []) : RenderableInterface
    {
        $view = new View($this->app->l11nManager, $request, $response);

        $view->setTemplate('/Modules/Tag/Theme/Backend/tag-create');
        $view->data['nav'] = $this->app->moduleManager->get('Navigation')->createNavigationMid(1007501001, $request, $response);

        return $view;
    }

    /**
     * Routing end-point for application behaviour.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return RenderableInterface
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function viewTagList(RequestAbstract $request, ResponseAbstract $response, array $data = []) : RenderableInterface
    {
        $view = new View($this->app->l11nManager, $request, $response);

        $view->setTemplate('/Modules/Tag/Theme/Backend/tag-list');
        $view->data['nav'] = $this->app->moduleManager->get('Navigation')->createNavigationMid(1007501001, $request, $response);

        if ($request->getData('ptype') === 'p') {
            $view->data['tags'] = TagMapper::getAll()
                    ->with('title')
                    ->where('id', $request->getDataInt('id') ?? 0, '<')
                    ->where('title/language', $request->header->l11n->language)
                    ->limit(25)
                    ->execute();
        } elseif ($request->getData('ptype') === 'n') {
            $view->data['tags'] = TagMapper::getAll()
                    ->with('title')
                    ->where('id', $request->getDataInt('id') ?? 0, '>')
                    ->where('title/language', $request->header->l11n->language)
                    ->limit(25)
                    ->execute();
        } else {
            $view->data['tags'] = TagMapper::getAll()
                    ->with('title')
                    ->where('id', 0, '>')
                    ->where('title/language', $request->header->l11n->language)
                    ->limit(25)
                    ->execute();
        }

        return $view;
    }

    /**
     * Routing end-point for application behaviour.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return RenderableInterface
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function viewTagSingle(RequestAbstract $request, ResponseAbstract $response, array $data = []) : RenderableInterface
    {
        $view = new View($this->app->l11nManager, $request, $response);

        /** @var \Modules\Tag\Models\Tag $tag */
        $tag = TagMapper::get()
            ->with('title')
            ->where('id', (int) $request->getData('id'))
            ->where('title/language', $response->header->l11n->language)
            ->execute();

        $view->setTemplate('/Modules/Tag/Theme/Backend/tag-single');
        $view->data['nav'] = $this->app->moduleManager->get('Navigation')->createNavigationMid(1007501001, $request, $response);
        $view->data['tag'] = $tag;

        /** @var \phpOMS\Localization\BaseStringL11n[] $l11n */
        $l11n = TagL11nMapper::getAll()
            ->where('ref', $tag->id)
            ->execute();

        $view->data['l11n'] = $l11n;

        return $view;
    }
}
