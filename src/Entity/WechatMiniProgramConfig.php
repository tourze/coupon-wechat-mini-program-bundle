<?php

namespace Tourze\CouponWechatMiniProgramBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Stringable;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Attribute\Ignore;
use Tourze\Arrayable\ApiArrayInterface;
use Tourze\CouponCoreBundle\Entity\Coupon;
use Tourze\CouponWechatMiniProgramBundle\Repository\WechatMiniProgramConfigRepository;
use Tourze\DoctrineIpBundle\Traits\IpTraceableAware;
use Tourze\DoctrineSnowflakeBundle\Service\SnowflakeIdGenerator;
use Tourze\DoctrineTimestampBundle\Traits\TimestampableAware;
use Tourze\DoctrineUserBundle\Traits\BlameableAware;

#[ORM\Entity(repositoryClass: WechatMiniProgramConfigRepository::class)]
#[ORM\Table(name: 'coupon_wechat_mini_program_config', options: ['comment' => '微信小程序配置'])]
class WechatMiniProgramConfig implements ApiArrayInterface, Stringable
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(SnowflakeIdGenerator::class)]
    #[ORM\Column(type: Types::BIGINT, nullable: false, options: ['comment' => 'ID'])]
    private ?string $id = null;

    #[Ignore]
    #[ORM\OneToOne(targetEntity: Coupon::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Coupon $coupon = null;

    #[Groups(['restful_read'])]
    #[ORM\Column(type: Types::STRING, length: 100, options: ['comment' => 'AppID'])]
    private string $appId = '';

    #[Groups(['restful_read'])]
    #[ORM\Column(type: Types::STRING, length: 20, nullable: true, options: ['comment' => '小程序版本'])]
    private ?string $envVersion = null;

    #[Groups(['restful_read'])]
    #[ORM\Column(type: Types::STRING, length: 255, options: ['comment' => '跳转路径'])]
    private ?string $path = '';

    use BlameableAware;
    use IpTraceableAware;
    use TimestampableAware;

    public function getId(): ?string
    {
        return $this->id;
    }


    public function getCoupon(): ?Coupon
    {
        return $this->coupon;
    }

    public function setCoupon(Coupon $coupon): self
    {
        $this->coupon = $coupon;

        return $this;
    }

    public function getAppId(): string
    {
        return $this->appId;
    }

    public function setAppId(string $appId): self
    {
        $this->appId = $appId;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(?string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getEnvVersion(): ?string
    {
        return $this->envVersion;
    }

    public function setEnvVersion(?string $envVersion): self
    {
        $this->envVersion = $envVersion;

        return $this;
    }

    public function retrieveApiArray(): array
    {
        return [
            'id' => $this->getId(),
            'createTime' => $this->getCreateTime()?->format('Y-m-d H:i:s'),
            'updateTime' => $this->getUpdateTime()?->format('Y-m-d H:i:s'),
            'appId' => $this->getAppId(),
            'envVersion' => $this->getEnvVersion(),
            'path' => $this->getPath(),
        ];
    }

    public function __toString(): string
    {
        return sprintf('微信小程序配置 [%s]', $this->appId ?: 'ID:' . $this->id);
    }
}
