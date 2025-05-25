<?php

namespace Tourze\CouponWechatMiniProgramBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Tourze\CouponWechatMiniProgramBundle\Entity\WechatMiniProgramConfig;


/**
 * @method WechatMiniProgramConfig|null find($id, $lockMode = null, $lockVersion = null)
 * @method WechatMiniProgramConfig|null findOneBy(array $criteria, array $orderBy = null)
 * @method WechatMiniProgramConfig[]    findAll()
 * @method WechatMiniProgramConfig[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WechatMiniProgramConfigRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WechatMiniProgramConfig::class);
    }
}
