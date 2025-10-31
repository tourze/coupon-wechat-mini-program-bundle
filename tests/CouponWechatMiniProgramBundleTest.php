<?php

declare(strict_types=1);

namespace CouponWechatMiniProgramBundle\Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\CouponWechatMiniProgramBundle\CouponWechatMiniProgramBundle;
use Tourze\PHPUnitSymfonyKernelTest\AbstractBundleTestCase;

/**
 * @internal
 */
#[CoversClass(CouponWechatMiniProgramBundle::class)]
#[RunTestsInSeparateProcesses]
final class CouponWechatMiniProgramBundleTest extends AbstractBundleTestCase
{
}
