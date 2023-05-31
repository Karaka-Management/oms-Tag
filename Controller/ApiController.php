<?php
/**
 * Karaka
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

use Modules\Tag\Models\Tag;
use Modules\Tag\Models\TagL11nMapper;
use Modules\Tag\Models\TagMapper;
use phpOMS\Localization\BaseStringL11n;
use phpOMS\Message\Http\RequestStatusCode;
use phpOMS\Message\NotificationLevel;
use phpOMS\Message\RequestAbstract;
use phpOMS\Message\ResponseAbstract;
use phpOMS\Model\Message\FormValidation;
use phpOMS\System\MimeType;

/**
 * Tag controller class.
 *
 * @package Modules\Tag
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
final class ApiController extends Controller
{
    /**
     * Validate tag create request
     *
     * @param RequestAbstract $request Request
     *
     * @return array<string, bool>
     *
     * @since 1.0.0
     */
    private function validateTagCreate(RequestAbstract $request) : array
    {
        $val = [];
        if (($val['title'] = !$request->hasData('title'))
            || ($val['color'] = ($request->hasData('color')
                && (!\ctype_xdigit(\ltrim((string) $request->getData('color'), '#'))
                    || \stripos((string) $request->getData('color'), '#') !== 0)))
        ) {
            return $val;
        }

        return [];
    }

    /**
     * Api method to create tag
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiTagUpdate(RequestAbstract $request, ResponseAbstract $response, mixed $data = null) : void
    {
        /** @var Tag $old */
        $old = TagMapper::get()->where('id', (int) $request->getData('id'))->execute();
        $old = clone $old;
        $new = $this->updateTagFromRequest($request);
        $this->updateModel($request->header->account, $old, $new, TagMapper::class, 'tag', $request->getOrigin());
        $this->fillJsonResponse($request, $response, NotificationLevel::OK, 'Tag', 'Tag successfully updated', $new);
    }

    /**
     * Method to update tag from request.
     *
     * @param RequestAbstract $request Request
     *
     * @return Tag
     *
     * @since 1.0.0
     */
    private function updateTagFromRequest(RequestAbstract $request) : Tag
    {
        /** @var Tag $tag */
        $tag = TagMapper::get()->where('id', (int) $request->getData('id'))->execute();
        $tag->setL11n($request->getDataString('title') ?? $tag->getL11n());
        $tag->color = \str_pad($request->getDataString('color') ?? $tag->color, 9, 'ff', \STR_PAD_RIGHT);

        return $tag;
    }

    /**
     * Api method to create tag
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiTagCreate(RequestAbstract $request, ResponseAbstract $response, mixed $data = null) : void
    {
        if (!empty($val = $this->validateTagCreate($request))) {
            $response->data['tag_create'] = new FormValidation($val);
            $response->header->status     = RequestStatusCode::R_400;

            return;
        }

        $tag = $this->createTagFromRequest($request);
        $tag->setL11n($request->getDataString('title') ?? '', $request->getDataString('language') ?? $request->header->l11n->language);
        $this->createModel($request->header->account, $tag, TagMapper::class, 'tag', $request->getOrigin());

        $this->fillJsonResponse($request, $response, NotificationLevel::OK, 'Tag', 'Tag successfully created', $tag);
    }

    /**
     * Validate tag l11n create request
     *
     * @param RequestAbstract $request Request
     *
     * @return array<string, bool>
     *
     * @since 1.0.0
     */
    private function validateTagL11nCreate(RequestAbstract $request) : array
    {
        $val = [];
        if (($val['title'] = !$request->hasData('title'))
            || ($val['tag'] = !$request->hasData('tag'))
        ) {
            return $val;
        }

        return [];
    }

    /**
     * Api method to create tag localization
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiTagL11nCreate(RequestAbstract $request, ResponseAbstract $response, mixed $data = null) : void
    {
        if (!empty($val = $this->validateTagL11nCreate($request))) {
            $response->data['tag_l11n_create'] = new FormValidation($val);
            $response->header->status          = RequestStatusCode::R_400;

            return;
        }

        $l11nTag = $this->createTagL11nFromRequest($request);
        $this->createModel($request->header->account, $l11nTag, TagL11nMapper::class, 'tag_l11n', $request->getOrigin());

        $this->fillJsonResponse($request, $response, NotificationLevel::OK, 'Localization', 'Localization successfully created', $l11nTag);
    }

    /**
     * Method to create tag from request.
     *
     * @param RequestAbstract $request Request
     *
     * @return Tag
     *
     * @since 1.0.0
     */
    private function createTagFromRequest(RequestAbstract $request) : Tag
    {
        $tag        = new Tag();
        $tag->color = \str_pad($request->getDataString('color') ?? '#000000ff', 9, 'f');
        $tag->icon  = $request->getDataString('icon') ?? '';

        return $tag;
    }

    /**
     * Method to create tag localization from request.
     *
     * @param RequestAbstract $request Request
     *
     * @return BaseStringL11n
     *
     * @since 1.0.0
     */
    private function createTagL11nFromRequest(RequestAbstract $request) : BaseStringL11n
    {
        $tagL11n      = new BaseStringL11n();
        $tagL11n->ref = $request->getDataInt('tag') ?? 0;
        $tagL11n->setLanguage(
            $request->getDataString('language') ?? $request->header->l11n->language
        );
        $tagL11n->content = $request->getDataString('title') ?? '';

        return $tagL11n;
    }

    /**
     * Api method to get a tag
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiTagGet(RequestAbstract $request, ResponseAbstract $response, mixed $data = null) : void
    {
        /** @var Tag $tag */
        $tag = TagMapper::get()->where('id', (int) $request->getData('id'))->execute();
        $this->fillJsonResponse($request, $response, NotificationLevel::OK, 'Tag', 'Tag successfully returned', $tag);
    }

    /**
     * Api method to delete tag
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiTagDelete(RequestAbstract $request, ResponseAbstract $response, mixed $data = null) : void
    {
        /** @var Tag $tag */
        $tag = TagMapper::get()->where('id', (int) $request->getData('id'))->execute();
        $this->deleteModel($request->header->account, $tag, TagMapper::class, 'tag', $request->getOrigin());
        $this->fillJsonResponse($request, $response, NotificationLevel::OK, 'Tag', 'Tag successfully deleted', $tag);
    }

    /**
     * Api method to find tags
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiTagFind(RequestAbstract $request, ResponseAbstract $response, mixed $data = null) : void
    {
        /** @var \Modules\Tag\Models\Tag[] $tags */
        $tags = TagMapper::getAll()
            ->with('title')
            ->where('title/language', $request->header->l11n->language)
            ->where('title/content', '%' . ($request->getDataString('search') ?? '') . '%', 'LIKE')
            ->execute();

        $response->header->set('Content-Type', MimeType::M_JSON, true);
        $response->set($request->uri->__toString(), \array_values($tags));
    }
}
