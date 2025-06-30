<?php

namespace Tourze\CouponWechatMiniProgramBundle\Tests\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Framework\TestCase;
use Tourze\CouponWechatMiniProgramBundle\Entity\WechatMiniProgramConfig;
use Tourze\CouponWechatMiniProgramBundle\Repository\WechatMiniProgramConfigRepository;

class WechatMiniProgramConfigRepositoryTest extends TestCase
{
    private WechatMiniProgramConfigRepository $repository;
    private EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $registry = $this->createMock(ManagerRegistry::class);
        $registry->method('getManagerForClass')
            ->willReturn($this->entityManager);
        
        $this->repository = new WechatMiniProgramConfigRepository($registry);
    }

    public function testRepositoryInstance(): void
    {
        $this->assertInstanceOf(WechatMiniProgramConfigRepository::class, $this->repository);
    }
}