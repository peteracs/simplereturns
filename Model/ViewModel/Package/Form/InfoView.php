<?php
/**
 * InfoView.php
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

namespace Tmo\SimpleReturns\Model\ViewModel\Package\Form;

use Tmo\SimpleReturns\{
    Api\Data\SimpleReturnInterface,
    Api\SimpleReturnRepositoryInterface,
    Component\System\ModuleConfigTrait,
    Exception\ExceptionFactory,
    Helper\Config as ConfigHelper,
    Model\AdapterModel\Sales\Order as OrderAdapter,
    Model\Security\Token as Tokenizer,
    Model\ViewModel\AbstractView,
    Shared\ModuleComponentInterface,
    Csi\System\Module\ConfigInterface
};
use Magento\Directory\Helper\Data as DirectoryHelper;
use Magento\Framework\{
    App\RequestInterface,
    Exception\LocalizedException,
    Exception\NoSuchEntityException,
    Message\ManagerInterface as MessageManagerInterface,
    UrlInterface,
    View\Element\Block\ArgumentInterface
};
use Magento\Sales\Api\Data\OrderInterface;

class InfoView extends AbstractView implements
    ArgumentInterface,
    ModuleComponentInterface
{
    use ModuleConfigTrait;

    /** @property DirectoryHelper $directoryHelper */
    protected $directoryHelper;

    /** @property MessageManagerInterface $messageManager */
    protected $messageManager;

    /** @property OrderInterface $order */
    protected $order;

    /** @property OrderAdapter $orderAdapter */
    protected $orderAdapter;

    /** @property SimpleReturnInterface $rma */
    protected $rma;

    /** @property SimpleReturnRepositoryInterface $simpleReturnRepository */
    protected $simpleReturnRepository;

    /**
     * @param ConfigHelper $configHelper
     * @param ExceptionFactory $exceptionFactory
     * @param RequestInterface $request
     * @param UrlInterface $urlBuilder
     * @param array $data
     * @param DirectoryHelper $directoryHelper
     * @param MessageManagerInterface $messageManager
     * @param ConfigInterface $moduleConfig
     * @param OrderAdapter $orderAdapter
     * @param SimpleReturnRepositoryInterface $simpleReturnRepository
     * @return void
     */
    public function __construct(
        ConfigHelper $configHelper,
        ExceptionFactory $exceptionFactory,
        RequestInterface $request,
        UrlInterface $urlBuilder,
        array $data = [],
        DirectoryHelper $directoryHelper,
        MessageManagerInterface $messageManager,
        ConfigInterface $moduleConfig,
        OrderAdapter $orderAdapter,
        SimpleReturnRepositoryInterface $simpleReturnRepository
    ) {
        parent::__construct(
            $configHelper,
            $exceptionFactory,
            $request,
            $urlBuilder,
            $data
        );
        $this->directoryHelper = $directoryHelper;
        $this->messageManager = $messageManager;
        $this->moduleConfig = $moduleConfig;
        $this->orderAdapter = $orderAdapter;
        $this->simpleReturnRepository = $simpleReturnRepository;
    }

    /**
     * @return string
     */
    public function getShippingCarrier(): string
    {
        return $this->getConfig()
            ->getShippingCarrier();
    }

    /**
     * @return string
     */
    public function getShippingMethod(): string
    {
        return $this->getConfig()
            ->getShippingMethod();
    }

    /**
     * Get frontend label for field type by key(s).
     *
     * @param string $type
     * @param string $key
     * @param string|null $subkey
     * @param string
     */
    public function getFrontLabel(
        string $type,
        string $key,
        string $subkey = null
    ): string
    {
        /** @var array $labels */
        $labels = $this->getConfig()
            ->getSettings()
            ->getData($type);

        /** @var string|array $label */
        $label = $labels[$key] ?? $key;

        if ($subkey !== null) {
            $label = is_array($label) && isset($label[$subkey])
                ? $label[$subkey]
                : $label;
        }

        return $label;
    }

    /**
     * @return SimpleReturnInterface|null
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function getSimpleReturn(): ?SimpleReturnInterface
    {
        /** @var int|string|null $rmaId */
        $rmaId = $this->request->getParam(static::PARAM_RMA_ID);
        $rmaId = $rmaId !== null && is_numeric($rmaId)
            ? (int) $rmaId
            : null;

        if ($rmaId !== null) {
            /** @var string|null $token */
            $token = $this->request->getParam(static::PARAM_TOKEN);
            $token = $token !== null && Tokenizer::isHex($token) ? $token : null;

            if ($token !== null) {
                try {
                    /** @var SimpleReturnInterface $rma */
                    $rma = $this->simpleReturnRepository->getById($rmaId);

                    if (Tokenizer::isEqual($token, $rma->getToken())) {
                        return $rma;
                    }

                    /** @var LocalizedException $exception */
                    $exception = $this->exceptionFactory->create(
                        LocalizedException::class
                    );

                    throw $exception;
                } catch (NoSuchEntityException $e) {
                    /* No action required. */
                } catch (LocalizedException $e) {
                    /* No action required. */
                }
            }
        }

        return null;
    }

    /**
     * @return OrderInterface|null
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function getOrder(): ?OrderInterface
    {
        if ($this->order !== null) {
            return $this->order;
        }

        /** @var SimpleReturnInterface|null $rma */
        $rma = $this->getSimpleReturn();

        if ($rma !== null) {
            /** @var array $fields */
            $fields = [
                'entity_id' => $rma->getOrderId(),
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
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        }

        return null;
    }

    /**
     * @return string
     */
    public function getPackageWeight(): string
    {
        /** @var OrderInterface $order */
        $order = $this->getOrder();

        /** @var float $weight */
        $weight = (float)($order->getWeight() ?? $this->getConfig()->getPackageWeight());

        return number_format($weight, 2);
    }

    /**
     * @return string
     */
    public function getWeightUnits(): string
    {
        return $this->directoryHelper->getWeightUnit();
    }

    /**
     * @return string
     */
    public function getViewRmaUrl(): string
    {
        /** @var array $params */
        $params = [
            '_secure' => true,
        ];

        /** @var SimpleReturnInterface $rma */
        $rma = $this->getSimpleReturn();

        if ($rma !== null) {
            $params['rma_id'] = $rma->getId();
            $params['token'] = $rma->getToken();
        }

        return $this->urlBuilder->getUrl(
            'simplereturns/rma/view',
            $params
        );
    }
}
