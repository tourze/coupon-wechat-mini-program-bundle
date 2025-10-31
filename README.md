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

A Symfony bundle for integrating WeChat Mini Program functionality with the coupon system.

## Table of Contents

- [Features](#features)
- [Installation](#installation)
- [Quick Start](#quick-start)
- [Configuration](#configuration)
- [API Integration](#api-integration)
- [Database Schema](#database-schema)
- [Advanced Usage](#advanced-usage)
- [Requirements](#requirements)
- [Contributing](#contributing)
- [License](#license)

## Features

- WeChat Mini Program configuration management
- Coupon integration with WeChat Mini Program
- AppID and path configuration
- Environment version support
- Doctrine ORM integration
- RESTful API support

## Installation

```bash
composer require tourze/coupon-wechat-mini-program-bundle
```

## Quick Start

### 1. Register the bundle

```php
// config/bundles.php
return [
    // ...
    Tourze\CouponWechatMiniProgramBundle\CouponWechatMiniProgramBundle::class => ['all' => true],
];
```

### 2. Create and configure WeChat Mini Program

```php
<?php

use Tourze\CouponWechatMiniProgramBundle\Entity\WechatMiniProgramConfig;
use Tourze\CouponCoreBundle\Entity\Coupon;

// Create configuration
$config = new WechatMiniProgramConfig();
$config->setAppId('your-wechat-app-id');
$config->setPath('pages/coupon/detail');
$config->setEnvVersion('release');
$config->setCoupon($coupon);

// Persist to database
$entityManager->persist($config);
$entityManager->flush();
```

### 3. Retrieve configuration

```php
<?php

use Tourze\CouponWechatMiniProgramBundle\Repository\WechatMiniProgramConfigRepository;

// Get configuration by coupon
$config = $repository->findOneBy(['coupon' => $coupon]);

// Get API array representation
$apiData = $config->retrieveApiArray();
```

## Configuration

The bundle provides the following configuration options:

- **appId**: WeChat Mini Program App ID
- **path**: Jump path within the mini program
- **envVersion**: Mini program environment version (release/trial/develop)

## API Integration

The `WechatMiniProgramConfig` entity implements `ApiArrayInterface` and provides 
serialization groups for RESTful APIs:

```php
// Get API representation
$apiArray = $config->retrieveApiArray();
// Returns: ['id', 'createTime', 'updateTime', 'appId', 'envVersion', 'path']
```

## Advanced Usage

### Custom Repository Methods

```php
<?php

use Tourze\CouponWechatMiniProgramBundle\Repository\WechatMiniProgramConfigRepository;

// Find configurations by App ID
$configs = $repository->findBy(['appId' => 'your-app-id']);

// Find configurations with specific environment
$configs = $repository->findBy(['envVersion' => 'release']);
```

### Validation Constraints

The entity includes automatic validation:

- AppID: Required, max 100 characters
- Environment Version: Optional, max 20 characters
- Path: Optional, max 255 characters

## Database Schema

The bundle creates a `coupon_wechat_mini_program_config` table with the following fields:

- `id`: Snowflake ID (primary key)
- `coupon_id`: Foreign key to coupon table
- `app_id`: WeChat Mini Program App ID
- `env_version`: Environment version
- `path`: Jump path
- Timestamp fields (created_at, updated_at)
- User tracking fields (created_by, updated_by)
- IP tracking fields

## Requirements

- PHP 8.1+
- Symfony 7.3+
- Doctrine ORM 3.0+
- Doctrine DBAL 4.0+

## Testing

The bundle includes comprehensive test coverage:

- Unit tests for entity functionality
- Integration tests for repository operations
- Isolated test environment to avoid external dependencies

Run tests with:
```bash
./vendor/bin/phpunit packages/coupon-wechat-mini-program-bundle/tests
```

## Contributing

Please see [CONTRIBUTING.md](CONTRIBUTING.md) for details.

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.