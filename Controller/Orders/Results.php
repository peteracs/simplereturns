<?php
/**
 * Results.php
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

namespace Tmo\SimpleReturns\Controller\Orders;

use Tmo\SimpleReturns\{
    Helper\Action as ActionHelper,
    Model\AdapterModel\Sales\Order as OrderAdapter,
    Model\ViewModel\Rma\ListView as ViewModel,
    Shared\ModuleComponentInterface
};
use Magento\Framework\{
    App\Action\Action,
    App\Action\Context,
    App\Action\HttpGetActionInterface,
    App\Request\DataPersistorInterface,
    View\Result\PageFactory
};

class Results extends Action implements
    HttpGetActionInterface,
    ModuleComponentInterface
{
    /** @property DataPersistorInterface $dataPersistor */
    protected $dataPersistor;

    /** @property OrderAdapter $orderAdapter */
    protected $orderAdapter;

    /** @property PageFactory $resultPageFactory */
    protected $resultPageFactory;

    /** @property ViewModel $viewModel */
    protected $viewModel;

    /**
     * @param Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param OrderAdapter $orderAdapter
     * @param PageFactory $resultPageFactory
     * @param ViewModel $viewModel
     * @return void
     */
    public function __construct(
        Context $context,
        DataPersistorInterface $dataPersistor,
        OrderAdapter $orderAdapter,
        PageFactory $resultPageFactory,
        ViewModel $viewModel
    ) {
        parent::__construct($context);
        $this->dataPersistor = $dataPersistor;
        $this->orderAdapter = $orderAdapter;
        $this->resultPageFactory = $resultPageFactory;
        $this->viewModel = $viewModel;
    }

    /**
     * Execute simplereturns_rma_overview action.
     *
     * @return Page
     */
    public function execute()
    {
        /** @var array $data */
        $data = $this->dataPersistor->get(self::DATA_PERSISTOR_KEY);
        $this->dataPersistor->clear(self::DATA_PERSISTOR_KEY);

        /** @var Page $resultPage */
        $resultPage = $this->resultPageFactory->create();

        /** @var string|null $zipCode */
        $zipCode = $data['zip_code'] ?? null;
        $zipCode = !empty($zipCode) ? trim($zipCode) : $zipCode;

        /** @var string|null $email */
        $email = $data['email'] ?? null;
        $email = !empty($email) ? trim($email) : $email;

        /** @var string|null $orderId */
        $orderId = $data['order_id'] ?? null;
        $orderId = !empty($orderId) ? trim($orderId) : $orderId;

        if ($zipCode !== null) {
            if ($email !== null) {
                /** @var OrderInterface[] $orders */
                $orders = $this->orderAdapter->getOrdersByCustomerEmailAndZipCode($email, $zipCode);

                $this->viewModel->setData('orders', $orders);
            } elseif ($orderId !== null) {
                /** @var OrderInterface[] $orders */
                $orders = $this->orderAdapter->getOrdersByIncrementIdAndZipCode($orderId, $zipCode);

                $this->viewModel->setData('orders', $orders);
            }
        }

        /** @var Magento\Framework\View\Element\AbstractBlock|bool $block */
        $block = $resultPage->getLayout()->getBlock(self::BLOCK_SIMPLERETURNS_ORDERS_RESULTS);

        if ($block) {
            $block->setData('view_model', $this->viewModel);
        }

        return $resultPage;
    }
}
