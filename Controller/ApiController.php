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

use Modules\Tag\Models\L11nTag;
use Modules\Tag\Models\L11nTagMapper;
use Modules\Tag\Models\Tag;
use Modules\Tag\Models\TagMapper;
use phpOMS\Message\Http\HttpRequest;
use phpOMS\Message\NotificationLevel;
use phpOMS\Message\RequestAbstract;
use phpOMS\Message\ResponseAbstract;
use phpOMS\Model\Message\FormValidation;
use phpOMS\System\MimeType;

/**
 * Tag controller class.
 *
 * @package Modules\Tag
 * @license OMS License 1.0
 * @link    https://orange-management.org
 * @since   1.0.0
 *
 * @todo Orange-Management/Modules#153
 *  Create Module
 *  Create a badge module instead of letting modules create their own internal badge/tag system.
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
        if (($val['title'] = empty($request->getData('title')))
            || ($val['color'] = (!empty($request->getData('color'))
                && (!\ctype_xdigit(\ltrim($request->getData('color'), '#'))
                    || \stripos($request->getData('color'), '#') !== 0)))
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
    public function apiTagUpdate(RequestAbstract $request, ResponseAbstract $response, $data = null) : void
    {
        /** @var Tag $old */
        $old = clone TagMapper::get((int) $request->getData('id'));
        $new = $this->updateTagFromRequest($request);
        $this->updateModel($request->getHeader()->getAccount(), $old, $new, TagMapper::class, 'tag', $request->getOrigin());
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
        $tag = TagMapper::get((int) $request->getData('id'));
        $tag->setTitle((string) ($request->getData('title') ?? $tag->getTitle()));
        $tag->setColor($request->getData('color') ?? $tag->getColor());

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
    public function apiTagCreate(RequestAbstract $request, ResponseAbstract $response, $data = null) : void
    {
        if (!empty($val = $this->validateTagCreate($request))) {
            $response->set('tag_create', new FormValidation($val));

            return;
        }

        $tag = $this->createTagFromRequest($request);
        $this->createModel($request->getHeader()->getAccount(), $tag, TagMapper::class, 'tag', $request->getOrigin());

        $l11nRequest = new HttpRequest($request->getUri());
        $l11nRequest->setData('tag', $tag->getId());
        $l11nRequest->setData('title', $request->getData('title'));
        $l11nRequest->setData('color', $request->getData('color'));
        $l11nRequest->setData('language', $request->getData('language'));

        $l11nTag = $this->createL11nTagFromRequest($l11nRequest);
        $this->createModel($request->getHeader()->getAccount(), $l11nTag, L11nTagMapper::class, 'tag_l11n', $request->getOrigin());

        $this->fillJsonResponse($request, $response, NotificationLevel::OK, 'Tag', 'Tag successfully created', $tag);
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
    public function apiTagL11nCreate(RequestAbstract $request, ResponseAbstract $response, $data = null) : void
    {
        if (!empty($val = $this->validateTagCreate($request))) {
            $response->set('tag_create', new FormValidation($val));

            return;
        }

        $l11nTag = $this->createL11nTagFromRequest($request);
        $this->createModel($request->getHeader()->getAccount(), $l11nTag, L11nTagMapper::class, 'tag_l11n', $request->getOrigin());

        $this->fillJsonResponse($request, $response, NotificationLevel::OK, 'Localization', 'Tag localization successfully created', $l11nTag);
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
        $tag = new Tag();
        $tag->setColor(\str_pad($request->getData('color') ?? '#000000ff', 9, 'f'));

        return $tag;
    }

    /**
     * Method to create tag localization from request.
     *
     * @param RequestAbstract $request Request
     *
     * @return L11nTag
     *
     * @since 1.0.0
     */
    private function createL11nTagFromRequest(RequestAbstract $request) : L11nTag
    {
        $l11nTag = new L11nTag();
        $l11nTag->setTag((int) ($request->getData('tag') ?? 0));
        $l11nTag->setLanguage((string) (
            $request->getData('language') ?? $request->getHeader()->getL11n()->getLanguage()
        ));
        $l11nTag->setTitle((string) ($request->getData('title') ?? ''));

        return $l11nTag;
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
    public function apiTagGet(RequestAbstract $request, ResponseAbstract $response, $data = null) : void
    {
        /** @var Tag $tag */
        $tag = TagMapper::get((int) $request->getData('id'));
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
    public function apiTagDelete(RequestAbstract $request, ResponseAbstract $response, $data = null) : void
    {
        /** @var Tag $tag */
        $tag = TagMapper::get((int) $request->getData('id'));
        $this->deleteModel($request->getHeader()->getAccount(), $tag, TagMapper::class, 'tag', $request->getOrigin());
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
    public function apiTagFind(RequestAbstract $request, ResponseAbstract $response, $data = null) : void
    {
        $response->getHeader()->set('Content-Type', MimeType::M_JSON, true);
        $response->set(
            $request->getUri()->__toString(),
            \array_values(
                TagMapper::find((string) ($request->getData('search') ?? ''))
            )
        );
    }
}
