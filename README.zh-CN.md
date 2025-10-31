# coupon-wechat-mini-program-bundle

[English](README.md) | [中文](README.zh-CN.md)

[![PHP Version](https://img.shields.io/badge/php-%5E8.1-blue)](https://php.net)
[![Latest Version](https://img.shields.io/packagist/v/tourze/coupon-wechat-mini-program-bundle.svg?style=flat-square)](
https://packagist.org/packages/tourze/coupon-wechat-mini-program-bundle)
[![License](https://img.shields.io/badge/license-MIT-green)](LICENSE)
[![Build Status](https://img.shields.io/travis/tourze/coupon-wechat-mini-program-bundle/master.svg?style=flat-square)](
https://travis-ci.org/tourze/coupon-wechat-mini-program-bundle)
[![Quality Score](https://img.shields.io/scrutinizer/g/tourze/coupon-wechat-mini-program-bundle.svg?style=flat-square)](
https://scrutinizer-ci.com/g/tourze/coupon-wechat-mini-program-bundle)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/tourze/coupon-wechat-mini-program-bundle.svg?style=flat-square)](
https://scrutinizer-ci.com/g/tourze/coupon-wechat-mini-program-bundle)
[![Total Downloads](https://img.shields.io/packagist/dt/tourze/coupon-wechat-mini-program-bundle.svg?style=flat-square)](
https://packagist.org/packages/tourze/coupon-wechat-mini-program-bundle)

一个用于集成微信小程序功能与优惠券系统的 Symfony 包。

## 目录

- [功能特性](#功能特性)
- [安装](#安装)
- [快速开始](#快速开始)
- [配置](#配置)
- [API 集成](#api-集成)
- [数据库架构](#数据库架构)
- [高级用法](#高级用法)
- [系统要求](#系统要求)
- [贡献](#贡献)
- [许可证](#许可证)

## 功能特性

- 微信小程序配置管理
- 优惠券与微信小程序集成
- AppID 和路径配置
- 环境版本支持
- Doctrine ORM 集成
- RESTful API 支持

## 安装

```bash
composer require tourze/coupon-wechat-mini-program-bundle
```

## 快速开始

### 1. 注册包

```php
// config/bundles.php
return [
    // ...
    Tourze\CouponWechatMiniProgramBundle\CouponWechatMiniProgramBundle::class => ['all' => true],
];
```

### 2. 创建和配置微信小程序

```php
<?php

use Tourze\CouponWechatMiniProgramBundle\Entity\WechatMiniProgramConfig;
use Tourze\CouponCoreBundle\Entity\Coupon;

// 创建配置
$config = new WechatMiniProgramConfig();
$config->setAppId('your-wechat-app-id');
$config->setPath('pages/coupon/detail');
$config->setEnvVersion('release');
$config->setCoupon($coupon);

// 持久化到数据库
$entityManager->persist($config);
$entityManager->flush();
```

### 3. 获取配置

```php
<?php

use Tourze\CouponWechatMiniProgramBundle\Repository\WechatMiniProgramConfigRepository;

// 根据优惠券获取配置
$config = $repository->findOneBy(['coupon' => $coupon]);

// 获取 API 数组表示
$apiData = $config->retrieveApiArray();
```

## 配置

该包提供以下配置选项：

- **appId**: 微信小程序 App ID
- **path**: 小程序内跳转路径
- **envVersion**: 小程序环境版本（release/trial/develop）

## API 集成

`WechatMiniProgramConfig` 实体实现了 `ApiArrayInterface` 接口，
并为 RESTful API 提供序列化组：

```php
// 获取 API 表示
$apiArray = $config->retrieveApiArray();
// 返回: ['id', 'createTime', 'updateTime', 'appId', 'envVersion', 'path']
```

## 高级用法

### 自定义仓储方法

```php
<?php

use Tourze\CouponWechatMiniProgramBundle\Repository\WechatMiniProgramConfigRepository;

// 根据 App ID 查找配置
$configs = $repository->findBy(['appId' => 'your-app-id']);

// 查找特定环境的配置
$configs = $repository->findBy(['envVersion' => 'release']);
```

### 验证约束

实体包含自动验证：

- AppID：必填，最大 100 字符
- 环境版本：可选，最大 20 字符
- 路径：可选，最大 255 字符

## 数据库架构

该包创建一个 `coupon_wechat_mini_program_config` 表，包含以下字段：

- `id`: 雪花 ID（主键）
- `coupon_id`: 优惠券表外键
- `app_id`: 微信小程序 App ID
- `env_version`: 环境版本
- `path`: 跳转路径
- 时间戳字段（created_at, updated_at）
- 用户跟踪字段（created_by, updated_by）
- IP 跟踪字段

## 系统要求

- PHP 8.1+
- Symfony 7.3+
- Doctrine ORM 3.0+
- Doctrine DBAL 4.0+

## 测试

该包包含完整的测试覆盖：

- 实体功能的单元测试
- 仓储操作的集成测试
- 隔离的测试环境以避免外部依赖

运行测试：
```bash
./vendor/bin/phpunit packages/coupon-wechat-mini-program-bundle/tests
```

## 贡献

请查看 [CONTRIBUTING.md](CONTRIBUTING.md) 了解详情。

## 许可证

MIT 许可证。请查看 [License File](LICENSE) 了解更多信息。