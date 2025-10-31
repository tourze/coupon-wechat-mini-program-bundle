<?php

namespace Tourze\CouponWechatMiniProgramBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\Attribute\When;
use Tourze\CouponCoreBundle\DataFixtures\CouponFixtures;
use Tourze\CouponCoreBundle\Entity\Coupon;
use Tourze\CouponWechatMiniProgramBundle\Entity\WechatMiniProgramConfig;

#[When(env: 'test')]
#[When(env: 'dev')]
class WechatMiniProgramConfigFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    public const WECHAT_CONFIG_DISCOUNT_20 = 'wechat-config-discount-20';
    public const WECHAT_CONFIG_PERCENT_10 = 'wechat-config-percent-10';
    public const WECHAT_CONFIG_FREE_SHIPPING = 'wechat-config-free-shipping';

    public function load(ObjectManager $manager): void
    {
        $discount20Coupon = $this->getReference(CouponFixtures::COUPON_BASIC_DISCOUNT, Coupon::class);
        $percent10Coupon = $this->getReference(CouponFixtures::COUPON_SHORT_TERM, Coupon::class);
        $freeShippingCoupon = $this->getReference(CouponFixtures::COUPON_NEED_ACTIVE, Coupon::class);

        $wechatConfig1 = new WechatMiniProgramConfig();
        $wechatConfig1->setCoupon($discount20Coupon);
        $wechatConfig1->setAppId('wx1234567890abcdef');
        $wechatConfig1->setPath('pages/coupon/detail');
        $wechatConfig1->setEnvVersion('release');

        $manager->persist($wechatConfig1);

        $wechatConfig2 = new WechatMiniProgramConfig();
        $wechatConfig2->setCoupon($percent10Coupon);
        $wechatConfig2->setAppId('wx0987654321fedcba');
        $wechatConfig2->setPath('pages/restaurant/coupon');
        $wechatConfig2->setEnvVersion('trial');

        $manager->persist($wechatConfig2);

        $wechatConfig3 = new WechatMiniProgramConfig();
        $wechatConfig3->setCoupon($freeShippingCoupon);
        $wechatConfig3->setAppId('wxabcdef1234567890');
        $wechatConfig3->setPath('pages/delivery/free');
        $wechatConfig3->setEnvVersion(null);

        $manager->persist($wechatConfig3);

        $manager->flush();

        $this->addReference(self::WECHAT_CONFIG_DISCOUNT_20, $wechatConfig1);
        $this->addReference(self::WECHAT_CONFIG_PERCENT_10, $wechatConfig2);
        $this->addReference(self::WECHAT_CONFIG_FREE_SHIPPING, $wechatConfig3);
    }

    public function getDependencies(): array
    {
        return [
            CouponFixtures::class,
        ];
    }

    public static function getGroups(): array
    {
        return ['coupon', 'wechat', 'test'];
    }
}
