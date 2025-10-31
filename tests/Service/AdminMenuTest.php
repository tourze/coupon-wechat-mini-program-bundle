<?php

declare(strict_types=1);

namespace Tourze\CouponWechatMiniProgramBundle\Tests\Service;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Knp\Menu\MenuFactory;
use Knp\Menu\MenuItem;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\CouponWechatMiniProgramBundle\Controller\WechatMiniProgramConfigCrudController;
use Tourze\CouponWechatMiniProgramBundle\Service\AdminMenu;
use Tourze\EasyAdminMenuBundle\Service\LinkGeneratorInterface;
use Tourze\EasyAdminMenuBundle\Service\MenuProviderInterface;
use Tourze\PHPUnitSymfonyWebTest\AbstractEasyAdminMenuTestCase;

/**
 * @internal
 */
#[CoversClass(AdminMenu::class)]
#[RunTestsInSeparateProcesses]
final class AdminMenuTest extends AbstractEasyAdminMenuTestCase
{
    private AdminMenu $adminMenu;

    private FactoryInterface $menuFactory;

    private LinkGeneratorInterface $linkGenerator;

    public function testImplementsMenuProviderInterface(): void
    {
        $this->assertInstanceOf(MenuProviderInterface::class, $this->adminMenu);
    }

    public function testInvokeCreatesWechatMiniProgramMenu(): void
    {
        $rootMenu = $this->createMenuItem('root');

        $this->adminMenu->__invoke($rootMenu);

        $this->assertTrue($rootMenu->hasChildren());
        $wechatMenu = $rootMenu->getChild('微信小程序配置');
        $this->assertNotNull($wechatMenu);
        $this->assertEquals('ROLE_ADMIN', $wechatMenu->getExtra('permission'));
    }

    public function testMenuHasCorrectStructure(): void
    {
        $rootMenu = $this->createMenuItem('root');

        $this->adminMenu->__invoke($rootMenu);

        $wechatMenu = $rootMenu->getChild('微信小程序配置');
        $this->assertNotNull($wechatMenu);

        $children = $wechatMenu->getChildren();
        $this->assertCount(1, $children);

        // Test menu item properties
        $configItem = $children['微信小程序配置'];
        $this->assertEquals('fa fa-cog', $configItem->getAttribute('icon'));
        $this->assertEquals('ROLE_ADMIN', $configItem->getExtra('permission'));
        $uri = $configItem->getUri();
        $this->assertNotEmpty($uri);
        $this->assertIsString($uri);
        $this->assertStringContainsString('WechatMiniProgramConfig', $uri);
    }

    public function testMenuIsNotCreatedWhenAlreadyExists(): void
    {
        $rootMenu = $this->createMenuItem('root');

        // Pre-create the menu
        $existingMenu = $rootMenu->addChild('微信小程序配置');
        $existingMenu->setExtra('permission', 'ROLE_CUSTOM');

        $this->adminMenu->__invoke($rootMenu);

        $wechatMenu = $rootMenu->getChild('微信小程序配置');
        $this->assertSame($existingMenu, $wechatMenu);
        $this->assertEquals('ROLE_CUSTOM', $wechatMenu->getExtra('permission'));
    }

    public function testHandlesNullWechatMenuGracefully(): void
    {
        $rootMenu = new class('root', $this->menuFactory) extends MenuItem {
            private bool $getChildCalled = false;

            private bool $addChildCalled = false;

            public function getChild(string $name): ?ItemInterface
            {
                $this->getChildCalled = true;

                return null;
            }

            public function addChild($child, array $options = []): ItemInterface
            {
                $this->addChildCalled = true;

                return new MenuItem('微信小程序配置', $this->factory);
            }

            public function wasGetChildCalled(): bool
            {
                return $this->getChildCalled;
            }

            public function wasAddChildCalled(): bool
            {
                return $this->addChildCalled;
            }
        };

        // This should not throw an exception
        $this->adminMenu->__invoke($rootMenu);

        // Verify the methods were called
        $this->assertTrue($rootMenu->wasGetChildCalled(), 'getChild method should have been called');
        $this->assertTrue($rootMenu->wasAddChildCalled(), 'addChild method should have been called');
    }

    public function testAllMenuItemsHaveRequiredPermissions(): void
    {
        $rootMenu = $this->createMenuItem('root');

        $this->adminMenu->__invoke($rootMenu);

        $wechatMenu = $rootMenu->getChild('微信小程序配置');
        $this->assertNotNull($wechatMenu);
        $this->assertEquals('ROLE_ADMIN', $wechatMenu->getExtra('permission'));

        foreach ($wechatMenu->getChildren() as $menuItem) {
            $this->assertEquals('ROLE_ADMIN', $menuItem->getExtra('permission'));
        }
    }

    private function createMenuItem(string $name): ItemInterface
    {
        return $this->menuFactory->createItem($name);
    }

    protected function onSetUp(): void
    {
        // 使用匿名类代替 mock
        $this->linkGenerator = new class implements LinkGeneratorInterface {
            public function getCurdListPage(string $entityClass): string
            {
                return match ($entityClass) {
                    WechatMiniProgramConfigCrudController::class => '/admin/WechatMiniProgramConfig',
                    default => '/admin/' . basename(str_replace('\\', '/', $entityClass)),
                };
            }

            public function extractEntityFqcn(string $url): ?string
            {
                return null;
            }

            public function setDashboard(string $dashboardControllerFqcn): void
            {
                // 测试环境中不需要具体实现
            }
        };

        $this->menuFactory = new MenuFactory();

        // 在容器中设置服务
        $container = self::getContainer();
        $container->set(LinkGeneratorInterface::class, $this->linkGenerator);

        // 从容器中获取服务实例
        $this->adminMenu = self::getService(AdminMenu::class);
    }
}
