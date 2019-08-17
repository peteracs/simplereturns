<?php
/**
 * Actions.php
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Aurora Extensions EULA,
 * which is bundled with this package in the file LICENSE.txt.
 *
 * It is also available on the Internet at the following URL:
 * https://docs.auroraextensions.com/magento/extensions/2.x/simplereturns/LICENSE.txt
 *
 * @package       AuroraExtensions_SimpleReturns
 * @copyright     Copyright (C) 2019 Aurora Extensions <support@auroraextensions.com>
 * @license       Aurora Extensions EULA
 */
declare(strict_types=1);

namespace AuroraExtensions\SimpleReturns\Block\Adminhtml\Rma\Status;

use AuroraExtensions\SimpleReturns\{
    Model\AdapterModel\Security\Token as Tokenizer,
    Model\SystemModel\Module\Config as ModuleConfig,
    Shared\ModuleComponentInterface
};
use Magento\Backend\{
    Block\Widget\Button\SplitButton,
    Block\Widget\Context,
    Block\Widget\Container
};

class Actions extends Container implements ModuleComponentInterface
{
    /** @property string $_blockGroup */
    protected $_blockGroup = 'AuroraExtensions_SimpleReturns';

    /** @property ModuleConfig $moduleConfig */
    protected $moduleConfig;

    /**
     * @param ModuleConfig $moduleConfig
     * @param Context $context
     * @param array $data
     * @return void
     */
    public function __construct(
        ModuleConfig $moduleConfig,
        Context $context,
        array $data = []
    ) {
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
                'label' => __('Actions'),
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

        /** @var array $statuses */
        $statuses = $this->moduleConfig->getStatuses();

        /** @var string $name */
        /** @var string $label */
        foreach ($statuses as $name => $label) {
            $options[] = [
                'class' => "action {$name}",
                'id' => "action-{$name}",
                'label' => __($label),
                'onclick' => $this->getOnClickJs($name),
            ];
        }

        return $options;
    }

    /**
     * @param string $status
     * @return string|null
     */
    protected function getOnClickJs(string $status): ?string
    {
        /** @var int|string|null $rmaId */
        $rmaId = $this->getRequest()->getParam(self::PARAM_RMA_ID);
        $rmaId = $rmaId !== null && is_numeric($rmaId)
            ? (int) $rmaId
            : null;

        if ($rmaId !== null) {
            /** @var string|null $token */
            $token = $this->getRequest()->getParam(self::PARAM_TOKEN);
            $token = $token !== null && Tokenizer::isHex($token) ? $token : null;

            if ($token !== null) {
                /** @var string $actionUrl */
                $actionUrl = $this->getUrl(
                    'simplereturns/rma_status/editPost',
                    [
                        'rma_id' => $rmaId,
                        'token'  => $token,
                        'status' => $status,
                    ]
                );

                return "(function(){jQuery.post('{$actionUrl}', function(response){console.log(response);});})();";
            }
        }

        return null;
    }
}