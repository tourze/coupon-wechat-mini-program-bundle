<?php

namespace Tourze\CouponWechatMiniProgramBundle\Tests\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Tourze\CouponWechatMiniProgramBundle\DependencyInjection\CouponWechatMiniProgramExtension;

class CouponWechatMiniProgramExtensionTest extends TestCase
{
    private CouponWechatMiniProgramExtension $extension;
    private ContainerBuilder $container;

    protected function setUp(): void
    {
        $this->extension = new CouponWechatMiniProgramExtension();
        $this->container = new ContainerBuilder();
    }

    public function testLoad(): void
    {
        $this->extension->load([], $this->container);
        $this->assertTrue($this->container->has('Tourze\CouponWechatMiniProgramBundle\Repository\WechatMiniProgramConfigRepository'));
    }
}