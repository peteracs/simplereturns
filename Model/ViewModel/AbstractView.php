<?php
/**
 * AbstractView.php
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

namespace Tmo\SimpleReturns\Model\ViewModel;

use Tmo\SimpleReturns\{
    Exception\ExceptionFactory,
    Helper\Config as ConfigHelper,
    Shared\ModuleComponentInterface
};
use Magento\Framework\{
    App\RequestInterface,
    DataObject,
    UrlInterface,
    View\Element\Block\ArgumentInterface
};

abstract class AbstractView extends DataObject implements
    ArgumentInterface,
    ModuleComponentInterface
{
    /** @property ConfigHelper $configHelper */
    protected $configHelper;

    /** @property ExceptionFactory $exceptionFactory */
    protected $exceptionFactory;

    /** @property RequestInterface $request */
    protected $request;

    /** @property UrlInterface $urlBuilder */
    protected $urlBuilder;

    /**
     * @param ConfigHelper $configHelper
     * @param ExceptionFactory $exceptionFactory
     * @param RequestInterface $request
     * @param UrlInterface $urlBuilder
     * @param array $data
     * @return void
     */
    public function __construct(
        ConfigHelper $configHelper,
        ExceptionFactory $exceptionFactory,
        RequestInterface $request,
        UrlInterface $urlBuilder,
        array $data = []
    ) {
        parent::__construct($data);
        $this->configHelper = $configHelper;
        $this->exceptionFactory = $exceptionFactory;
        $this->request = $request;
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * Get POST action URL.
     *
     * @param string $route
     * @return string
     */
    public function getPostActionUrl(string $route): string
    {
        return $this->urlBuilder->getUrl(
            $route,
            [
                '_secure' => true,
            ]
        );
    }
}
