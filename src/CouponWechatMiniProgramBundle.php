<?php

namespace Tourze\CouponWechatMiniProgramBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Tourze\BundleDependency\BundleDependencyInterface;

class CouponWechatMiniProgramBundle extends Bundle implements BundleDependencyInterface
{
    public static function getBundleDependencies(): array
    {
        return [
            \Tourze\DoctrineUserBundle\DoctrineUserBundle::class => ['all' => true],
            \Tourze\DoctrineIndexedBundle\DoctrineIndexedBundle::class => ['all' => true],
            \Tourze\DoctrineIpBundle\DoctrineIpBundle::class => ['all' => true],
            \Tourze\DoctrineSnowflakeBundle\DoctrineSnowflakeBundle::class => ['all' => true],
        ];
    }
}
