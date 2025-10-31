<?php

declare(strict_types=1);

namespace Tourze\CouponWechatMiniProgramBundle\Tests\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\CouponCoreBundle\Entity\Coupon;
use Tourze\CouponWechatMiniProgramBundle\Entity\WechatMiniProgramConfig;
use Tourze\CouponWechatMiniProgramBundle\Repository\WechatMiniProgramConfigRepository;
use Tourze\PHPUnitSymfonyKernelTest\AbstractRepositoryTestCase;

/**
 * @internal
 */
#[CoversClass(WechatMiniProgramConfigRepository::class)]
#[RunTestsInSeparateProcesses]
final class WechatMiniProgramConfigRepositoryTest extends AbstractRepositoryTestCase
{
    protected function createNewEntity(): object
    {
        $config = new WechatMiniProgramConfig();
        $config->setAppId('wx' . uniqid());
        $config->setAppSecret('secret_' . uniqid());
        $config->setAppName('Test MiniProgram ' . uniqid());

        $coupon = new Coupon();
        $coupon->setName('Test Coupon ' . uniqid());
        $coupon->setSn('TEST_COUPON_' . strtoupper(uniqid()));
        $coupon->setValid(true);
        $coupon->setExpireDay(30);
        $config->setCoupon($coupon);

        return $config;
    }

    /**
     * @return ServiceEntityRepository<WechatMiniProgramConfig>
     */
    protected function getRepository(): ServiceEntityRepository
    {
        $repository = self::getService(WechatMiniProgramConfigRepository::class);
        $this->assertInstanceOf(WechatMiniProgramConfigRepository::class, $repository);

        return $repository;
    }

    protected function onSetUp(): void
    {
    }
}
