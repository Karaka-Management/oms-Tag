<?php
/**
 * Jingga
 *
 * PHP Version 8.2
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

        $view->setTemplate('/Modules/Tag/Theme/Backend/tag-view');
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

        $view->data['tags'] = TagMapper::getAll()
            ->with('title')
            ->where('title/language', $request->header->l11n->language)
            ->limit(25)
            ->paginate(
                'id',
                $request->getDataString('ptype') ?? '',
                $request->getDataInt('offset')
            )->executeGetArray();

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
    public function viewTagView(RequestAbstract $request, ResponseAbstract $response, array $data = []) : RenderableInterface
    {
        $view = new View($this->app->l11nManager, $request, $response);
        $view->setTemplate('/Modules/Tag/Theme/Backend/tag-view');
        $view->data['nav'] = $this->app->moduleManager->get('Navigation')->createNavigationMid(1007501001, $request, $response);

        /** @var \Modules\Tag\Models\Tag $tag */
        $tag = TagMapper::get()
            ->with('title')
            ->where('id', (int) $request->getData('id'))
            ->where('title/language', $response->header->l11n->language)
            ->execute();

        $view->data['tag']      = $tag;
        $view->data['l11nView'] = new \Web\Backend\Views\L11nView($this->app->l11nManager, $request, $response);

        /** @var \phpOMS\Localization\BaseStringL11n[] $l11nValues */
        $l11nValues = TagL11nMapper::getAll()
            ->where('ref', $tag->id)
            ->executeGetArray();

        $view->data['l11nValues'] = $l11nValues;

        return $view;
    }
}
