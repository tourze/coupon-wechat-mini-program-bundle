<?php

declare(strict_types=1);

namespace Tourze\CouponWechatMiniProgramBundle\Service;

use Knp\Menu\ItemInterface;
use Tourze\CouponWechatMiniProgramBundle\Controller\WechatMiniProgramConfigCrudController;
use Tourze\EasyAdminMenuBundle\Service\LinkGeneratorInterface;
use Tourze\EasyAdminMenuBundle\Service\MenuProviderInterface;

readonly class AdminMenu implements MenuProviderInterface
{
    public function __construct(
        private LinkGeneratorInterface $linkGenerator,
    ) {
    }

    public function __invoke(ItemInterface $item): void
    {
        if (null === $item->getChild('微信小程序配置')) {
            $item->addChild('微信小程序配置')->setExtra('permission', 'ROLE_ADMIN');
        }

        $wechatMiniProgramMenu = $item->getChild('微信小程序配置');
        if (null !== $wechatMiniProgramMenu) {
            $wechatMiniProgramMenu->addChild('微信小程序配置')
                ->setUri($this->linkGenerator->getCurdListPage(WechatMiniProgramConfigCrudController::class))
                ->setAttribute('icon', 'fa fa-cog')
                ->setExtra('permission', 'ROLE_ADMIN')
            ;
        }
    }
}
