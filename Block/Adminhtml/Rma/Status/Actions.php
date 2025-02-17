<?php
/**
 * Actions.php
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT License, which
 * is bundled with this package in the file LICENSE.txt.
 *
 * It is also available on the Internet at the following URL:
 * https://docs.auroraextensions.com/magento/extensions/2.x/simplereturns/LICENSE.txt
 *
 * @package       Tmo_SimpleReturns
 * @copyright     Copyright (C) 2019 Aurora Extensions <support@auroraextensions.com>
 * @license       MIT License
 */
declare(strict_types=1);

namespace Tmo\SimpleReturns\Block\Adminhtml\Rma\Status;

use Tmo\SimpleReturns\{
    Model\Security\Token as Tokenizer,
    Model\SystemModel\Module\Config as ModuleConfig,
    Shared\ModuleComponentInterface
};
use Magento\Backend\{
    Block\Widget\Button\SplitButton,
    Block\Widget\Context,
    Block\Widget\Container
};
use Magento\Framework\Data\Form\FormKey;

class Actions extends Container implements ModuleComponentInterface
{
    /** @property string $_blockGroup */
    protected $_blockGroup = 'Tmo_SimpleReturns';

    /** @property FormKey $formKey */
    protected $formKey;

    /** @property ModuleConfig $moduleConfig */
    protected $moduleConfig;

    /**
     * @param FormKey $formKey
     * @param ModuleConfig $moduleConfig
     * @param Context $context
     * @param array $data
     * @return void
     */
    public function __construct(
        FormKey $formKey,
        ModuleConfig $moduleConfig,
        Context $context,
        array $data = []
    ) {
        $this->formKey = $formKey;
        $this->moduleConfig = $moduleConfig;
        parent::__construct(
            $context,
            $data
        );
    }

    /**
     * @return void
     */
    public function _construct()
    {
        parent::_construct();
        $this->_objectId = 'simplereturns_rma_status_actions';
        $this->_controller = 'adminhtml_rma_status';
        $this->setId('simplereturns_rma_status_actions');

        $this->buttonList->add(
            'simplereturns_rma_status_actions',
            [
                'class' => 'actions',
                'class_name' => SplitButton::class,
                'id' => 'simplereturns-rma-status-actions',
                'label' => __('Status'),
                'options' => $this->getStatusOptions(),
            ]
        );
    }

    /**
     * @return array
     */
    protected function getStatusOptions(): array
    {
        /** @var array $options */
        $options = [];

        /** @var Magento\Framework\App\RequestInterface $request */
        $request = $this->getRequest();

        /** @var int|string|null $rmaId */
        $rmaId = $request->getParam(self::PARAM_RMA_ID);
        $rmaId = $rmaId !== null && is_numeric($rmaId)
            ? (int) $rmaId
            : null;

        /** @var array $statuses */
        $statuses = $this->moduleConfig->getStatuses();

        /** @var string $name */
        /** @var string $label */
        foreach ($statuses as $name => $label) {
            $options[] = [
                'class' => "action {$name}",
                'data_attribute' => [
                    'mage-init' => [
                        'simpleReturnsRmaEditStatus' => [
                            'actionUrl' => $this->getActionUrl($name),
                            'statusCode' => $name,
                        ],
                    ],
                ],
                'id' => "action-{$name}",
                'label' => __($label),
            ];
        }

        return $options;
    }

    /**
     * @return string|null
     */
    protected function getActionUrl(): ?string
    {
        /** @var Magento\Framework\App\RequestInterface $request */
        $request = $this->getRequest();

        /** @var int|string|null $rmaId */
        $rmaId = $request->getParam(self::PARAM_RMA_ID);
        $rmaId = $rmaId !== null && is_numeric($rmaId)
            ? (int) $rmaId
            : null;

        if ($rmaId !== null) {
            /** @var string|null $token */
            $token = $request->getParam(self::PARAM_TOKEN);
            $token = $token !== null && Tokenizer::isHex($token) ? $token : null;

            if ($token !== null) {
                return $this->getUrl(
                    'simplereturns/rma_status/editPost',
                    [
                        'form_key' => $this->formKey->getFormKey(),
                        'rma_id' => $rmaId,
                        'token' => $token,
                    ]
                );
            }
        }

        return null;
    }
}
