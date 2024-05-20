<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\Tag
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.2
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\Tag\Controller;

use Modules\Tag\Models\NullTag;
use Modules\Tag\Models\Tag;
use Modules\Tag\Models\TagL11nMapper;
use Modules\Tag\Models\TagMapper;
use phpOMS\Localization\BaseStringL11n;
use phpOMS\Localization\ISO639x1Enum;
use phpOMS\Message\Http\HttpResponse;
use phpOMS\Message\Http\RequestStatusCode;
use phpOMS\Message\RequestAbstract;
use phpOMS\Message\ResponseAbstract;
use phpOMS\System\MimeType;

/**
 * Tag controller class.
 *
 * @package Modules\Tag
 * @license OMS License 2.2
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
     * Api method to update tag
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiTagUpdate(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        /** @var Tag $old */
        $old = TagMapper::get()->where('id', (int) $request->getData('id'))->execute();
        $new = $this->updateTagFromRequest($request, clone $old);

        $this->updateModel($request->header->account, $old, $new, TagMapper::class, 'tag', $request->getOrigin());
        $this->createStandardUpdateResponse($request, $response, $new);
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
    private function updateTagFromRequest(RequestAbstract $request, Tag $new) : Tag
    {
        $new->setL11n($request->getDataString('title') ?? $new->getL11n());
        $new->color = \str_pad($request->getDataString('color') ?? $new->color, 9, 'ff', \STR_PAD_RIGHT);

        return $new;
    }

    /**
     * Api method to create tag
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiTagCreate(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        if (!empty($val = $this->validateTagCreate($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidCreateResponse($request, $response, $val);

            return;
        }

        $tag = $this->createTagFromRequest($request);
        $this->createModel($request->header->account, $tag, TagMapper::class, 'tag', $request->getOrigin());
        $this->createStandardCreateResponse($request, $response, $tag);
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
     * @param array            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiTagL11nCreate(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        if (!empty($val = $this->validateTagL11nCreate($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidCreateResponse($request, $response, $val);

            return;
        }

        $l11nTag = $this->createTagL11nFromRequest($request);
        $this->createModel($request->header->account, $l11nTag, TagL11nMapper::class, 'tag_l11n', $request->getOrigin());
        $this->createStandardCreateResponse($request, $response, $l11nTag);
    }

    /**
     * Create tags from request
     *
     * @param RequestAbstract $request Request
     *
     * @return Tag[]
     *
     * @since 1.0.0
     */
    public function createTagsFromRequest(RequestAbstract $request) : array
    {
        $tagJsonArray = $request->getDataJson('tags');
        $tags         = [];

        foreach ($tagJsonArray as $tag) {
            if (isset($tag['id'])) {
                $tags[] = new NullTag((int) $tag['id']);
            } else {
                $request->setData('title', $tag['title'], true);
                $request->setData('color', $tag['color'], true);
                $request->setData('icon', $tag['icon'] ?? null, true);
                $request->setData('language', $tag['language'], true);

                $internalResponse = new HttpResponse();
                $this->apiTagCreate($request, $internalResponse);

                if (!\is_array($data = $internalResponse->getDataArray($request->uri->__toString()))) {
                    continue;
                }

                $tags[] = $data['response'];
            }
        }

        return $tags;
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
        $tag->name  = $request->getDataString('name') ?? '';
        $tag->color = \str_pad($request->getDataString('color') ?? '#000000ff', 9, 'f');
        $tag->icon  = $request->getDataString('icon') ?? '';

        $tag->setL11n(
            $request->getDataString('title') ?? '',
            ISO639x1Enum::tryFromValue($request->getDataString('language')) ?? $request->header->l11n->language
        );

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
        $tagL11n           = new BaseStringL11n();
        $tagL11n->ref      = $request->getDataInt('tag') ?? 0;
        $tagL11n->language = ISO639x1Enum::tryFromValue($request->getDataString('language')) ?? $request->header->l11n->language;
        $tagL11n->content  = $request->getDataString('title') ?? '';

        return $tagL11n;
    }

    /**
     * Api method to get a tag
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiTagGet(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        /** @var Tag $tag */
        $tag = TagMapper::get()->where('id', (int) $request->getData('id'))->execute();
        $this->createStandardReturnResponse($request, $response, $tag);
    }

    /**
     * Api method to delete tag
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiTagDelete(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        /** @var Tag $tag */
        $tag = TagMapper::get()->where('id', (int) $request->getData('id'))->execute();
        $this->deleteModel($request->header->account, $tag, TagMapper::class, 'tag', $request->getOrigin());
        $this->createStandardDeleteResponse($request, $response, $tag);
    }

    /**
     * Api method to find tags
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiTagFind(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        /** @var \Modules\Tag\Models\Tag[] $tags */
        $tags = TagMapper::getAll()
            ->with('title')
            ->where('title/language', $request->header->l11n->language)
            ->where('title/content', '%' . ($request->getDataString('search') ?? '') . '%', 'LIKE')
            ->executeGetArray();

        $response->header->set('Content-Type', MimeType::M_JSON, true);
        $response->set($request->uri->__toString(), \array_values($tags));
    }

    /**
     * Api method to update TagL11n
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiTagL11nUpdate(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        if (!empty($val = $this->validateTagL11nUpdate($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidUpdateResponse($request, $response, $val);

            return;
        }

        /** @var BaseStringL11n $old */
        $old = TagL11nMapper::get()->where('id', (int) $request->getData('id'))->execute();
        $new = $this->updateTagL11nFromRequest($request, clone $old);

        $this->updateModel($request->header->account, $old, $new, TagL11nMapper::class, 'tag_l11n', $request->getOrigin());
        $this->createStandardUpdateResponse($request, $response, $new);
    }

    /**
     * Method to update TagL11n from request.
     *
     * @param RequestAbstract $request Request
     * @param BaseStringL11n  $new     Model to modify
     *
     * @return BaseStringL11n
     *
     * @todo Implement API update function
     *
     * @since 1.0.0
     */
    public function updateTagL11nFromRequest(RequestAbstract $request, BaseStringL11n $new) : BaseStringL11n
    {
        $new->language = ISO639x1Enum::tryFromValue($request->getDataString('language')) ?? $new->language;
        $new->content  = $request->getDataString('title') ?? $new->content;

        return $new;
    }

    /**
     * Validate TagL11n update request
     *
     * @param RequestAbstract $request Request
     *
     * @return array<string, bool>
     *
     * @todo Implement API validation function
     *
     * @since 1.0.0
     */
    private function validateTagL11nUpdate(RequestAbstract $request) : array
    {
        $val = [];
        if (($val['id'] = !$request->hasData('id'))) {
            return $val;
        }

        return [];
    }

    /**
     * Api method to delete TagL11n
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiTagL11nDelete(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        if (!empty($val = $this->validateTagL11nDelete($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidDeleteResponse($request, $response, $val);

            return;
        }

        /** @var BaseStringL11n $tagL11n */
        $tagL11n = TagL11nMapper::get()->where('id', (int) $request->getData('id'))->execute();
        $this->deleteModel($request->header->account, $tagL11n, TagL11nMapper::class, 'tag_l11n', $request->getOrigin());
        $this->createStandardDeleteResponse($request, $response, $tagL11n);
    }

    /**
     * Validate TagL11n delete request
     *
     * @param RequestAbstract $request Request
     *
     * @return array<string, bool>
     *
     * @since 1.0.0
     */
    private function validateTagL11nDelete(RequestAbstract $request) : array
    {
        $val = [];
        if (($val['id'] = !$request->hasData('id'))) {
            return $val;
        }

        return [];
    }
}
