<?php

namespace Tourze\CouponWechatMiniProgramBundle\Tests\DependencyInjection;

use PHPUnit\Framework\Attributes\CoversClass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Tourze\CouponWechatMiniProgramBundle\DependencyInjection\CouponWechatMiniProgramExtension;
use Tourze\PHPUnitSymfonyUnitTest\AbstractDependencyInjectionExtensionTestCase;

/**
 * @internal
 */
#[CoversClass(CouponWechatMiniProgramExtension::class)]
final class CouponWechatMiniProgramExtensionTest extends AbstractDependencyInjectionExtensionTestCase
{
    private CouponWechatMiniProgramExtension $extension;

    private ContainerBuilder $container;

    protected function setUp(): void
    {
        parent::setUp();
        $this->extension = new CouponWechatMiniProgramExtension();
        $this->container = new ContainerBuilder();
        $this->container->setParameter('kernel.environment', 'test');
    }

    public function testLoadLoadsServicesPhp(): void
    {
        $this->extension->load([], $this->container);

        // 验证服务定义存在
        $this->assertTrue($this->container->has('Tourze\CouponWechatMiniProgramBundle\Repository\WechatMiniProgramConfigRepository'));
    }

    public function testLoadWithEmptyConfigsDoesNotThrowException(): void
    {
        // 确保方法不抛出异常
        $exception = null;
        try {
            $this->extension->load([], $this->container);
        } catch (\Throwable $e) {
            $exception = $e;
        }

        $this->assertNull($exception);
    }

    public function testExtensionAlias(): void
    {
        $this->assertEquals('coupon_wechat_mini_program', $this->extension->getAlias());
    }
}
