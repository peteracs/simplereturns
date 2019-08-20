<?php
/**
 * User.php
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Aurora Extensions EULA,
 * which is bundled with this package in the file LICENSE.txt.
 *
 * It is also available on the Internet at the following URL:
 * https://docs.auroraextensions.com/magento/extensions/2.x/simplereturns/LICENSE.txt
 *
 * @package        AuroraExtensions_SimpleReturns
 * @copyright      Copyright (C) 2019 Aurora Extensions <support@auroraextensions.com>
 * @license        Aurora Extensions EULA
 */
declare(strict_types=1);

namespace AuroraExtensions\SimpleReturns\Model\Email\Transport;

use AuroraExtensions\SimpleReturns\{
    Model\SystemModel\Config\Module as ModuleConfig,
    Shared\ModuleComponentInterface
};
use Magento\Backend\{
    App\Area\FrontNameResolver,
    App\ConfigInterface
};
use Magento\Email\Model\BackendTemplate;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Store\Model\Store;

class User implements ModuleComponentInterface
{
    /** @property ConfigInterface $backendConfig */
    protected $backendConfig;

    /** @property TransportBuilder $transportBuilder */
    protected $transportBuilder;

    /**
     * @param ConfigInterface $backendConfig
     * @param TransportBuilder $transportBuilder
     * @return void
     */
    public function __construct(
        ConfigInterface $backendConfig,
        TransportBuilder $transportBuilder
    ) {
        $this->backendConfig = $backendConfig;
        $this->transportBuilder = $transportBuilder;
    }

    /**
     * @param string $template Template configuration ID.
     * @param string $sender Email sender identity XML path.
     * @param array $variables
     * @param string|null $email
     * @param string|null $name
     * @return $this
     */
    public function send(
        string $template,
        string $sender,
        array $variables = [],
        string $email = null,
        string $name = null
    ) {
        /** @var array $options */
        $options = [
            'area'  => FrontNameResolver::AREA_CODE,
            'store' => Store::DEFAULT_STORE_ID,
        ];

        /** @var string $templateId */
        $templateId = $this->backendConfig->getValue($template);

        /** @var string $identity */
        $identity = $this->backendConfig->getValue($sender);

        /** @var Magento\Framework\Mail\TransportInterface $transport */
        $transport = $this->transportBuilder
            ->setTemplateIdentifier($templateId)
            ->setTemplateModel(BackendTemplate::class)
            ->setTemplateVars($variables)
            ->setTemplateOptions($options)
            ->setFrom($identity)
            ->addTo($email, $name)
            ->getTransport();

        $transport->sendMessage();

        return $this;
    }
}
