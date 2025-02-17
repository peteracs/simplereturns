<?php
/**
 * IncrementId.php
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

namespace Tmo\SimpleReturns\Ui\Component\Listing\Column\Order;

use Exception;
use Magento\Framework\{
    Exception\NoSuchEntityException,
    UrlInterface,
    View\Element\UiComponent\ContextInterface,
    View\Element\UiComponentFactory
};
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Ui\Component\Listing\Columns\Column;

class IncrementId extends Column
{
    /** @constant string COLUMN_KEY */
    public const COLUMN_KEY = 'increment_id';

    /** @constant string ENTITY_KEY */
    public const ENTITY_KEY = 'order_id';

    /** @property OrderRepositoryInterface $orderRepository */
    protected $orderRepository;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param array $components
     * @param array $data
     * @param OrderRepositoryInterface $orderRepository
     * @return void
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = [],
        OrderRepositoryInterface $orderRepository
    ) {
        parent::__construct(
            $context,
            $uiComponentFactory,
            $components,
            $data
        );
        $this->orderRepository = $orderRepository;
    }

    /**
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            /** @var array $item */
            foreach ($dataSource['data']['items'] as &$item) {
                /** @var int|string|null $orderId */
                $orderId = $item[static::ENTITY_KEY] ?? null;

                if ($orderId !== null) {
                    $item[static::COLUMN_KEY] = $this->getIncrementId((int) $orderId);
                }
            }
        }

        return $dataSource;
    }

    /**
     * @param int $orderId
     * @return string|null
     */
    private function getIncrementId(int $orderId): ?string
    {
        try {
            /** @var OrderInterface $order */
            $order = $this->orderRepository->get($orderId);

            return (string) $order->getRealOrderId();
        } catch (NoSuchEntityException $e) {
            /* No action required. */
        } catch (Exception $e) {
            /* No action required. */
        }

        return null;
    }
}
