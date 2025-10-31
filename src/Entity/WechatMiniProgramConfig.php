<?php

namespace Tourze\CouponWechatMiniProgramBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Attribute\Ignore;
use Symfony\Component\Validator\Constraints as Assert;
use Tourze\Arrayable\ApiArrayInterface;
use Tourze\CouponCoreBundle\Entity\Coupon;
use Tourze\CouponWechatMiniProgramBundle\Repository\WechatMiniProgramConfigRepository;
use Tourze\DoctrineIpBundle\Traits\IpTraceableAware;
use Tourze\DoctrineSnowflakeBundle\Traits\SnowflakeKeyAware;
use Tourze\DoctrineTimestampBundle\Traits\TimestampableAware;
use Tourze\DoctrineUserBundle\Traits\BlameableAware;

/**
 * @implements ApiArrayInterface<string, mixed>
 */
#[ORM\Entity(repositoryClass: WechatMiniProgramConfigRepository::class)]
#[ORM\Table(name: 'coupon_wechat_mini_program_config', options: ['comment' => '微信小程序配置'])]
class WechatMiniProgramConfig implements ApiArrayInterface, \Stringable
{
    use SnowflakeKeyAware;
    use BlameableAware;
    use IpTraceableAware;
    use TimestampableAware;

    #[Ignore]
    #[ORM\OneToOne(targetEntity: Coupon::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Coupon $coupon = null;

    #[Assert\NotBlank]
    #[Assert\Length(max: 100)]
    #[Groups(groups: ['restful_read'])]
    #[ORM\Column(type: Types::STRING, length: 100, options: ['comment' => 'AppID'])]
    private string $appId = '';

    #[Assert\Length(max: 20)]
    #[Groups(groups: ['restful_read'])]
    #[ORM\Column(type: Types::STRING, length: 20, nullable: true, options: ['comment' => '小程序版本'])]
    private ?string $envVersion = null;

    #[Assert\Length(max: 255)]
    #[Groups(groups: ['restful_read'])]
    #[ORM\Column(type: Types::STRING, length: 255, options: ['comment' => '跳转路径'])]
    private ?string $path = '';

    #[Assert\Length(max: 255)]
    #[Groups(groups: ['restful_read'])]
    #[ORM\Column(type: Types::STRING, length: 255, nullable: true, options: ['comment' => 'AppSecret'])]
    private ?string $appSecret = null;

    #[Assert\Length(max: 100)]
    #[Groups(groups: ['restful_read'])]
    #[ORM\Column(type: Types::STRING, length: 100, nullable: true, options: ['comment' => '小程序名称'])]
    private ?string $appName = null;

    public function getCoupon(): ?Coupon
    {
        return $this->coupon;
    }

    public function setCoupon(Coupon $coupon): void
    {
        $this->coupon = $coupon;
    }

    public function getAppId(): string
    {
        return $this->appId;
    }

    public function setAppId(string $appId): void
    {
        $this->appId = $appId;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(?string $path): void
    {
        $this->path = $path;
    }

    public function getEnvVersion(): ?string
    {
        return $this->envVersion;
    }

    public function setEnvVersion(?string $envVersion): void
    {
        $this->envVersion = $envVersion;
    }

    public function getAppSecret(): ?string
    {
        return $this->appSecret;
    }

    public function setAppSecret(?string $appSecret): void
    {
        $this->appSecret = $appSecret;
    }

    public function getAppName(): ?string
    {
        return $this->appName;
    }

    public function setAppName(?string $appName): void
    {
        $this->appName = $appName;
    }

    /**
     * @return array<string, mixed>
     */
    public function retrieveApiArray(): array
    {
        return [
            'id' => $this->getId(),
            'createTime' => $this->getCreateTime()?->format('Y-m-d H:i:s'),
            'updateTime' => $this->getUpdateTime()?->format('Y-m-d H:i:s'),
            'appId' => $this->getAppId(),
            'envVersion' => $this->getEnvVersion(),
            'path' => $this->getPath(),
            'appSecret' => $this->getAppSecret(),
            'appName' => $this->getAppName(),
        ];
    }

    public function __toString(): string
    {
        return sprintf('微信小程序配置 [%s]', '' !== $this->appId ? $this->appId : 'ID:' . $this->id);
    }
}
