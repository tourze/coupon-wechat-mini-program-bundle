<?php

namespace Tourze\CouponWechatMiniProgramBundle\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Tourze\CouponWechatMiniProgramBundle\CouponWechatMiniProgramBundle;

class CouponWechatMiniProgramBundleTest extends TestCase
{
    private CouponWechatMiniProgramBundle $bundle;

    protected function setUp(): void
    {
        $this->bundle = new CouponWechatMiniProgramBundle();
    }

    public function testGetBundleDependencies(): void
    {
        $dependencies = CouponWechatMiniProgramBundle::getBundleDependencies();
        
        $this->assertArrayHasKey(\Tourze\DoctrineUserBundle\DoctrineUserBundle::class, $dependencies);
        $this->assertArrayHasKey(\Tourze\DoctrineIndexedBundle\DoctrineIndexedBundle::class, $dependencies);
        $this->assertArrayHasKey(\Tourze\DoctrineIpBundle\DoctrineIpBundle::class, $dependencies);
        $this->assertArrayHasKey(\Tourze\DoctrineSnowflakeBundle\DoctrineSnowflakeBundle::class, $dependencies);
        
        foreach ($dependencies as $dependency => $config) {
            $this->assertIsArray($config);
            $this->assertArrayHasKey('all', $config);
            $this->assertTrue($config['all']);
        }
    }

    public function testBundleIsInstanceOfBundle(): void
    {
        $this->assertInstanceOf(\Symfony\Component\HttpKernel\Bundle\Bundle::class, $this->bundle);
    }

    public function testBundleImplementsBundleDependencyInterface(): void
    {
        $this->assertInstanceOf(\Tourze\BundleDependency\BundleDependencyInterface::class, $this->bundle);
    }
}