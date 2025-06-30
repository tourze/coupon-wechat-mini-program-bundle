<?php

namespace Tourze\CouponWechatMiniProgramBundle\Tests\Entity;

use PHPUnit\Framework\TestCase;
use Tourze\CouponCoreBundle\Entity\Coupon;
use Tourze\CouponWechatMiniProgramBundle\Entity\WechatMiniProgramConfig;

class WechatMiniProgramConfigTest extends TestCase
{
    private WechatMiniProgramConfig $config;

    protected function setUp(): void
    {
        $this->config = new WechatMiniProgramConfig();
    }

    public function testGetSetAppId(): void
    {
        $appId = 'wx1234567890';
        $this->config->setAppId($appId);
        $this->assertSame($appId, $this->config->getAppId());
    }

    public function testGetSetPath(): void
    {
        $path = '/pages/index/index';
        $this->config->setPath($path);
        $this->assertSame($path, $this->config->getPath());
    }

    public function testGetSetEnvVersion(): void
    {
        $envVersion = 'release';
        $this->config->setEnvVersion($envVersion);
        $this->assertSame($envVersion, $this->config->getEnvVersion());
    }

    public function testGetSetCoupon(): void
    {
        $coupon = new Coupon();
        $this->config->setCoupon($coupon);
        $this->assertSame($coupon, $this->config->getCoupon());
    }

    public function testRetrieveApiArray(): void
    {
        $appId = 'wx1234567890';
        $envVersion = 'release';
        $path = '/pages/index/index';
        
        $this->config->setAppId($appId);
        $this->config->setEnvVersion($envVersion);
        $this->config->setPath($path);
        
        $apiArray = $this->config->retrieveApiArray();
        
        // API array 总是返回数组，不需要检查
        $this->assertArrayHasKey('id', $apiArray);
        $this->assertArrayHasKey('createTime', $apiArray);
        $this->assertArrayHasKey('updateTime', $apiArray);
        $this->assertArrayHasKey('appId', $apiArray);
        $this->assertArrayHasKey('envVersion', $apiArray);
        $this->assertArrayHasKey('path', $apiArray);
        
        $this->assertSame($appId, $apiArray['appId']);
        $this->assertSame($envVersion, $apiArray['envVersion']);
        $this->assertSame($path, $apiArray['path']);
    }

    public function testToStringWithAppId(): void
    {
        $appId = 'wx1234567890';
        $this->config->setAppId($appId);
        $this->assertSame('微信小程序配置 [wx1234567890]', (string)$this->config);
    }

    public function testToStringWithoutAppId(): void
    {
        $this->assertStringStartsWith('微信小程序配置 [ID:', (string)$this->config);
    }
}