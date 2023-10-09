<?php
/**
 * Jingga
 *
 * PHP Version 8.1
 *
 * @package   tests
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\Tag\tests\Controller;

use Model\CoreSettings;
use Modules\Admin\Models\AccountPermission;
use phpOMS\Account\Account;
use phpOMS\Account\AccountManager;
use phpOMS\Account\PermissionType;
use phpOMS\Application\ApplicationAbstract;
use phpOMS\Dispatcher\Dispatcher;
use phpOMS\Event\EventManager;
use phpOMS\Localization\ISO639x1Enum;
use phpOMS\Localization\L11nManager;
use phpOMS\Message\Http\HttpRequest;
use phpOMS\Message\Http\HttpResponse;
use phpOMS\Message\Http\RequestStatusCode;
use phpOMS\Module\ModuleManager;
use phpOMS\Router\WebRouter;
use phpOMS\Uri\HttpUri;
use phpOMS\Utils\TestUtils;

/**
 * @internal
 */
final class ApiControllerTest extends \PHPUnit\Framework\TestCase
{
    protected $app = null;

    /** @var \Modules\Tag\Controller\ApiController $module */
    protected $module = null;

    /**
     * {@inheritdoc}
     */
    protected function setUp() : void
    {
        $this->app = new class() extends ApplicationAbstract
        {
            protected string $appName = 'Api';
        };

        $this->app->dbPool          = $GLOBALS['dbpool'];
        $this->app->unitId          = 1;
        $this->app->accountManager  = new AccountManager($GLOBALS['session']);
        $this->app->appSettings     = new CoreSettings();
        $this->app->moduleManager   = new ModuleManager($this->app, __DIR__ . '/../../../Modules/');
        $this->app->dispatcher      = new Dispatcher($this->app);
        $this->app->eventManager    = new EventManager($this->app->dispatcher);
        $this->app->l11nManager     = new L11nManager();
        $this->app->eventManager->importFromFile(__DIR__ . '/../../../Web/Api/Hooks.php');

        $account = new Account();
        TestUtils::setMember($account, 'id', 1);

        $permission       = new AccountPermission();
        $permission->unit = 1;
        $permission->app  = 2;
        $permission->setPermission(
            PermissionType::READ
            | PermissionType::CREATE
            | PermissionType::MODIFY
            | PermissionType::DELETE
            | PermissionType::PERMISSION
        );

        $account->addPermission($permission);

        $this->app->accountManager->add($account);
        $this->app->router = new WebRouter();

        $this->module = $this->app->moduleManager->get('Tag');

        TestUtils::setMember($this->module, 'app', $this->app);
    }

    /**
     * Tag id of the last tag created
     * @var int
     * @since 1.0.0
     **/
    private static int $tagId = 0;

    /**
     * @covers Modules\Tag\Controller\ApiController
     * @group module
     */
    public function testApiTagCreate() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest(new HttpUri(''));

        $request->header->account = 1;
        $request->setData('color', '#ff0000ff');
        $request->setData('title', 'ApiTagEN');
        $request->setData('language', ISO639x1Enum::_EN);

        $this->module->apiTagCreate($request, $response);

        self::assertEquals('ApiTagEN', $response->getDataArray('')['response']->getL11n());
        self::assertGreaterThan(0, $response->getDataArray('')['response']->id);

        self::$tagId = $response->getDataArray('')['response']->id;
    }

    /**
     * @covers Modules\Tag\Controller\ApiController
     * @group module
     */
    public function testApiTagCreateInvalid() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest(new HttpUri(''));

        $this->module->apiTagCreate($request, $response);

        self::assertEquals(RequestStatusCode::R_400, $response->header->status);
    }

    /**
     * @covers Modules\Tag\Controller\ApiController
     * @group module
     */
    public function testApiTagL11nCreate() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest(new HttpUri(''));

        $request->header->account = 1;
        $request->setData('tag', self::$tagId);
        $request->setData('title', 'ApiTagDE');
        $request->setData('language', ISO639x1Enum::_DE);

        $this->module->apiTagL11nCreate($request, $response);

        self::assertEquals('ApiTagDE', $response->getDataArray('')['response']->content);
        self::assertGreaterThan(0, $response->getDataArray('')['response']->id);
    }

    /**
     * @covers Modules\Tag\Controller\ApiController
     * @group module
     */
    public function testApiTagL11nCreateInvalid() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest(new HttpUri(''));

        $this->module->apiTagL11nCreate($request, $response);

        self::assertEquals(RequestStatusCode::R_400, $response->header->status);
    }

    /**
     * @covers Modules\Tag\Controller\ApiController
     * @group module
     */
    public function testApiTagGet() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest(new HttpUri(''));

        $request->header->account = 1;
        $request->setData('id', self::$tagId);

        $this->module->apiTagGet($request, $response);

        self::assertEquals(self::$tagId, $response->getDataArray('')['response']->id);
    }

    /**
     * @covers Modules\Tag\Controller\ApiController
     * @group module
     */
    public function testApiTagUpdate() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest(new HttpUri(''));

        $request->header->account = 1;
        $request->setData('id', self::$tagId);
        $request->setData('color', '#00ff00ff');

        $this->module->apiTagUpdate($request, $response);

        self::assertEquals('#00ff00ff', $response->getDataArray('')['response']->color);
        self::assertEquals(self::$tagId, $response->getDataArray('')['response']->id);
    }

    /**
     * @covers Modules\Tag\Controller\ApiController
     * @group module
     */
    public function testApiUnitFind() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest(new HttpUri(''));

        $request->header->account = 1;
        $request->setData('search', 'ApiTag');

        $this->module->apiTagFind($request, $response);

        self::assertEquals('ApiTagEN', $response->getData('')[0]->getL11n());
        self::assertEquals(self::$tagId, $response->getData('')[0]->id);
    }
}
