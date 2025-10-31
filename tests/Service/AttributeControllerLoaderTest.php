<?php

declare(strict_types=1);

namespace Tourze\CouponWechatMiniProgramBundle\Tests\Service;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Symfony\Component\Routing\RouteCollection;
use Tourze\CouponWechatMiniProgramBundle\Service\AttributeControllerLoader;
use Tourze\PHPUnitSymfonyKernelTest\AbstractIntegrationTestCase;

/**
 * @internal
 */
#[CoversClass(AttributeControllerLoader::class)]
#[RunTestsInSeparateProcesses]
final class AttributeControllerLoaderTest extends AbstractIntegrationTestCase
{
    protected function onSetUp(): void
    {
        // 集成测试初始化
    }

    private function createLoader(): AttributeControllerLoader
    {
        return self::getService(AttributeControllerLoader::class);
    }

    public function testLoadReturnsRouteCollection(): void
    {
        $loader = $this->createLoader();
        $collection = $loader->load('test');

        $this->assertInstanceOf(RouteCollection::class, $collection);
    }

    public function testAutoloadReturnsRouteCollection(): void
    {
        $loader = $this->createLoader();
        $collection = $loader->autoload();

        $this->assertInstanceOf(RouteCollection::class, $collection);
    }

    public function testSupportsReturnsFalse(): void
    {
        $loader = $this->createLoader();
        $this->assertFalse($loader->supports('test'));
    }

    public function testLoadAndAutoloadReturnsSameCollection(): void
    {
        $loader = $this->createLoader();
        $loadCollection = $loader->load('test');
        $autoloadCollection = $loader->autoload();

        $this->assertEquals($loadCollection, $autoloadCollection);
    }
}
