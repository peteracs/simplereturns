<?php
/**
 * CreateView.php
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

namespace Tmo\SimpleReturns\Model\ViewModel\Rma;

use Tmo\SimpleReturns\{
    Exception\ExceptionFactory,
    Helper\Action as ActionHelper,
    Helper\Config as ConfigHelper,
    Model\AdapterModel\Sales\Order as OrderAdapter,
    Model\SystemModel\Module\Config as ModuleConfig,
    Model\ViewModel\AbstractView,
    Shared\ModuleComponentInterface
};
use Magento\Framework\{
    App\RequestInterface,
    Exception\NoSuchEntityException,
    Message\ManagerInterface as MessageManagerInterface,
    UrlInterface,
    View\Element\Block\ArgumentInterface
};
use Magento\Sales\Api\Data\OrderInterface;

class CreateView extends AbstractView implements
    ArgumentInterface,
    ModuleComponentInterface
{
    /** @property MessageManagerInterface $messageManager */
    protected $messageManager;

    /** @property ModuleConfig $moduleConfig */
    protected $moduleConfig;

    /** @property OrderInterface $order */
    protected $order;

    /** @property OrderAdapter $orderAdapter */
    protected $orderAdapter;

    /**
     * @param ConfigHelper $configHelper
     * @param ExceptionFactory $exceptionFactory
     * @param RequestInterface $request
     * @param UrlInterface $urlBuilder
     * @param array $data
     * @param MessageManagerInterface $messageManager
     * @param ModuleConfig $moduleConfig
     * @param OrderAdapter $orderAdapter
     * @return void
     */
    public function __construct(
        ConfigHelper $configHelper,
        ExceptionFactory $exceptionFactory,
        RequestInterface $request,
        UrlInterface $urlBuilder,
        array $data = [],
        MessageManagerInterface $messageManager,
        ModuleConfig $moduleConfig,
        OrderAdapter $orderAdapter
    ) {
        parent::__construct(
            $configHelper,
            $exceptionFactory,
            $request,
            $urlBuilder,
            $data
        );
        $this->messageManager = $messageManager;
        $this->moduleConfig = $moduleConfig;
        $this->orderAdapter = $orderAdapter;
    }

    /**
     * @return OrderInterface|null
     * @throws NoSuchEntityException
     */
    public function getOrder(): ?OrderInterface
    {
        if ($this->order !== null) {
            return $this->order;
        }

        /** @var int|string $orderId */
        $orderId = $this->request->getParam(self::PARAM_ORDER_ID);

        /** @var string $orderId */
        $protectCode = $this->request->getParam(self::PARAM_PROTECT_CODE);

        if ($orderId !== null && $protectCode !== null) {
            /** @var array $fields */
            $fields = [
                self::FIELD_INCREMENT_ID => $orderId,
                self::FIELD_PROTECT_CODE => $protectCode,
            ];

            try {
                /** @var OrderInterface[] $orders */
                $orders = $this->orderAdapter->getOrdersByFields($fields);

                if (!empty($orders)) {
                    $this->order = $orders[0];

                    return $this->order;
                }

                /** @var NoSuchEntityException $exception */
                $exception = $this->exceptionFactory->create(
                    NoSuchEntityException::class,
                    __('Unable to locate any matching orders.')
                );

                throw $exception;
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addError($e->getMessage());
            }
        }

        return null;
    }

    /**
     * @return string|null
     */
    public function getViewOrderUrl(): ?string
    {
        /** @var OrderInterface $order */
        $order = $this->getOrder();

        if ($order !== null) {
            return $this->urlBuilder->getUrl(
                'sales/order/view',
                [
                    'order_id' => $order->getId(),
                    '_secure' => true,
                ]
            );
        }

        return null;
    }

    /**
     * @return array
     */
    public function getReasons(): array
    {
        return $this->moduleConfig->getReasons();
    }

    /**
     * @return array
     */
    public function getResolutions(): array
    {
        return $this->moduleConfig->getResolutions();
    }

    /**
     * @param string $route
     * @return string
     */
    public function getPostActionUrl(
        string $route = self::ROUTE_SIMPLERETURNS_RMA_CREATEPOST
    ): string
    {
        /** @var array $params */
        $params = [
            '_secure' => true,
        ];

        /** @var int|string|null $orderId */
        $orderId = $this->request->getParam(self::PARAM_ORDER_ID);

        if ($orderId !== null) {
            $params['order_id'] = $orderId;
        }

        /** @var string|null $protectCode */
        $protectCode = $this->request->getParam(self::PARAM_PROTECT_CODE);

        if ($protectCode !== null) {
            $params['code'] = $protectCode;
        }

        return $this->urlBuilder->getUrl($route, $params);
    }
}
