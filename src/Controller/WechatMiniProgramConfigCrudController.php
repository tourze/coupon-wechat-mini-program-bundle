<?php

declare(strict_types=1);

namespace Tourze\CouponWechatMiniProgramBundle\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminCrud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Tourze\CouponWechatMiniProgramBundle\Entity\WechatMiniProgramConfig;

/**
 * @extends AbstractCrudController<WechatMiniProgramConfig>
 */
#[AdminCrud(
    routePath: '/coupon-wechat-mini-program/config',
    routeName: 'coupon_wechat_mini_program_config'
)]
final class WechatMiniProgramConfigCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return WechatMiniProgramConfig::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('微信小程序配置')
            ->setEntityLabelInPlural('微信小程序配置')
            ->setPageTitle('index', '微信小程序配置管理')
            ->setPageTitle('new', '创建微信小程序配置')
            ->setPageTitle('edit', '编辑微信小程序配置')
            ->setPageTitle('detail', '微信小程序配置详情')
            ->setSearchFields(['appId', 'appName', 'envVersion'])
            ->setDefaultSort(['updateTime' => 'DESC'])
            ->setPaginatorPageSize(20)
            ->showEntityActionsInlined()
        ;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('appId')
            ->add('appName')
            ->add('envVersion')
            ->add('createTime')
            ->add('updateTime')
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id', 'ID')
            ->onlyOnDetail()
        ;

        yield AssociationField::new('coupon', '关联优惠券')
            ->setRequired(true)
            ->setHelp('选择要关联的优惠券')
            ->autocomplete()
        ;

        yield TextField::new('appId', 'AppID')
            ->setRequired(true)
            ->setMaxLength(100)
            ->setHelp('微信小程序的AppID，必填项')
        ;

        yield TextField::new('appName', '小程序名称')
            ->setMaxLength(100)
            ->setHelp('微信小程序的显示名称，可选项')
        ;

        yield TextField::new('envVersion', '小程序版本')
            ->setMaxLength(20)
            ->setHelp('小程序的版本号，如：release、trial、develop')
        ;

        yield TextareaField::new('path', '跳转路径')
            ->setMaxLength(255)
            ->setHelp('小程序内的页面路径，如：pages/index/index')
        ;

        yield TextField::new('appSecret', 'AppSecret')
            ->setMaxLength(255)
            ->setHelp('微信小程序的AppSecret，用于服务端调用')
            ->hideOnIndex()
        ;

        if (Crud::PAGE_DETAIL === $pageName || Crud::PAGE_INDEX === $pageName) {
            yield DateTimeField::new('createTime', '创建时间')
                ->setFormat('yyyy-MM-dd HH:mm:ss')
                ->onlyOnDetail()
            ;

            yield DateTimeField::new('updateTime', '更新时间')
                ->setFormat('yyyy-MM-dd HH:mm:ss')
            ;

            yield TextField::new('createdBy', '创建人')
                ->onlyOnDetail()
            ;

            yield TextField::new('updatedBy', '更新人')
                ->onlyOnDetail()
            ;
        }
    }
}
