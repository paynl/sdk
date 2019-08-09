<?php
declare(strict_types=1);

namespace PayNL\Sdk\Model;

/**
 * Class PaymentMethod
 *
 * @package PayNL\Sdk\Model
 */
class PaymentMethod implements ModelInterface
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $settings = [];

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return PaymentMethod
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return PaymentMethod
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return array
     */
    public function getSettings(): array
    {
        return $this->settings;
    }

    /**
     * @param array $settings
     *
     * @return PaymentMethod
     */
    public function setSettings(array $settings): self
    {
        foreach ($settings as $setting) {
            $this->addSetting($setting);
        }
        return $this;
    }

    /**
     * @param string $setting
     *
     * @return PaymentMethod
     */
    public function addSetting(string $setting): self
    {
        $this->settings[] = $setting;
        return $this;
    }
}
