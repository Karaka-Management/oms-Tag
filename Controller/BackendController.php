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
     * Routing end-point for application behavior.
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
     * Routing end-point for application behavior.
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

        $mapper = TagMapper::getAll()
            ->with('title')
            ->where('title/language', $request->header->l11n->language)
            ->limit(25);

        if ($request->getData('ptype') === 'p') {
            $view->data['tags'] = $mapper->where('id', $request->getDataInt('id') ?? 0, '<')
                ->execute();
        } elseif ($request->getData('ptype') === 'n') {
            $view->data['tags'] = $mapper->where('id', $request->getDataInt('id') ?? 0, '>')
                ->execute();
        } else {
            $view->data['tags'] = $mapper->where('id', 0, '>')
                ->execute();
        }

        return $view;
    }

    /**
     * Routing end-point for application behavior.
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

        $view->data['l11nView'] = new \Web\Backend\Views\L11nView($this->app->l11nManager, $request, $response);

        /** @var \phpOMS\Localization\BaseStringL11n[] $l11nValues */
        $l11nValues = TagL11nMapper::getAll()
            ->where('ref', $tag->id)
            ->execute();

        $view->data['l11nValues'] = $l11nValues;

        return $view;
    }
}
