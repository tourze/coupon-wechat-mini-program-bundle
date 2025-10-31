<?php

namespace Tourze\CouponWechatMiniProgramBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Tourze\CouponWechatMiniProgramBundle\Entity\WechatMiniProgramConfig;
use Tourze\PHPUnitSymfonyKernelTest\Attribute\AsRepository;

/**
 * @extends ServiceEntityRepository<WechatMiniProgramConfig>
 */
#[AsRepository(entityClass: WechatMiniProgramConfig::class)]
class WechatMiniProgramConfigRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WechatMiniProgramConfig::class);
    }

    public function save(WechatMiniProgramConfig $entity, bool $flush = true): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(WechatMiniProgramConfig $entity, bool $flush = true): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
