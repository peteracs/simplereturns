<?php
/**
 * Generate.php
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

namespace Tmo\SimpleReturns\Controller\Label;

use Tmo\SimpleReturns\{
    Api\Data\PackageInterface,
    Api\Data\PackageInterfaceFactory,
    Api\Data\SimpleReturnInterface,
    Api\Data\SimpleReturnInterfaceFactory,
    Api\PackageManagementInterface,
    Api\PackageRepositoryInterface,
    Api\SimpleReturnRepositoryInterface,
    Exception\ExceptionFactory,
    Exception\Http\Request\InvalidTokenException,
    Model\Security\Token as Tokenizer,
    Shared\Action\Redirector,
    Shared\ModuleComponentInterface
};
use Magento\Framework\{
    App\Action\Action,
    App\Action\Context,
    App\Action\HttpGetActionInterface,
    Controller\Result\Redirect as ResultRedirect,
    Exception\AlreadyExistsException,
    Exception\LocalizedException,
    Exception\NoSuchEntityException,
    HTTP\PhpEnvironment\RemoteAddress,
    UrlInterface
};

class
Generate extends Action implements
    HttpGetActionInterface,
    ModuleComponentInterface
{
    /** @see Tmo\SimpleReturns\Shared\Action\Redirector */
    use Redirector {
        Redirector::__initialize as protected;
    }

    /** @property ExceptionFactory $exceptionFactory */
    protected $exceptionFactory;

    /** @property PackageInterfaceFactory $packageFactory */
    protected $packageFactory;

    /** @property PackageManagementInterface $packageManagement */
    protected $packageManagement;

    /** @property PackageRepositoryInterface $packageRepository */
    protected $packageRepository;

    /** @property RemoteAddress $remoteAddress */
    protected $remoteAddress;

    /** @property SimpleReturnInterfaceFactory $simpleReturnFactory */
    protected $simpleReturnFactory;

    /** @property SimpleReturnRepositoryInterface $simpleReturnRepository */
    protected $simpleReturnRepository;

    /** @property UrlInterface $urlBuilder */
    protected $urlBuilder;

    /**
     * @param Context $context
     * @param ExceptionFactory $exceptionFactory
     * @param PackageInterfaceFactory $packageFactory
     * @param PackageManagementInterface $packageManagement
     * @param PackageRepositoryInterface $packageRepository
     * @param RemoteAddress $remoteAddress
     * @param SimpleReturnInterfaceFactory $simpleReturnFactory
     * @param SimpleReturnRepositoryInterface $simpleReturnRepository
     * @param UrlInterface $urlBuilder
     * @return void
     */
    public function __construct(
        Context $context,
        ExceptionFactory $exceptionFactory,
        PackageInterfaceFactory $packageFactory,
        PackageManagementInterface $packageManagement,
        PackageRepositoryInterface $packageRepository,
        RemoteAddress $remoteAddress,
        SimpleReturnInterfaceFactory $simpleReturnFactory,
        SimpleReturnRepositoryInterface $simpleReturnRepository,
        UrlInterface $urlBuilder
    ) {
        parent::__construct($context);
        $this->__initialize();
        $this->exceptionFactory = $exceptionFactory;
        $this->packageFactory = $packageFactory;
        $this->packageManagement = $packageManagement;
        $this->packageRepository = $packageRepository;
        $this->remoteAddress = $remoteAddress;
        $this->simpleReturnFactory = $simpleReturnFactory;
        $this->simpleReturnRepository = $simpleReturnRepository;
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * Execute simplereturns_label_generate action.
     *
     * @return Redirect
     */
    public function execute()
    {
        /** @var Magento\Framework\App\RequestInterface $request */
        $request = $this->getRequest();

        if (!$request->isGet()) {
            return $this->getRedirectToPath(self::ROUTE_SIMPLERETURNS_PKG_VIEW);
        }

        /** @var int|string|null $pkgId */
        $pkgId = $request->getParam(self::PARAM_PKG_ID);
        $pkgId = $pkgId !== null && is_numeric($pkgId)
            ? (int) $pkgId
            : null;

        if ($pkgId !== null) {
            /** @var array $params */
            $params = [
                '_secure' => true,
            ];

            /** @var string|null $token */
            $token = $request->getParam(self::PARAM_TOKEN);
            $token = $token !== null && !empty($token)
                ? $token
                : null;

            try {
                /** @var PackageInterface $package */
                $package = $this->packageRepository->getById($pkgId);

                if (!Tokenizer::isEqual($token, $package->getToken())) {
                    /** @var InvalidTokenException $exception */
                    $exception = $this->exceptionFactory->create(
                        InvalidTokenException::class
                    );

                    throw $exception;
                }

                /* Create RMA request and generate shipping label. */
                if ($this->packageManagement->requestToReturnShipment($package)) {
                    $params['pkg_id'] = $package->getId();
                    $params['token'] = $package->getToken();
                }

                /** @var string $viewUrl */
                $viewUrl = $this->urlBuilder->getUrl(
                    'simplereturns/package/view',
                    $params
                );

                return $this->getRedirectToUrl($viewUrl);
            } catch (InvalidTokenException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        }

        return $this->getRedirectToPath(self::ROUTE_SIMPLERETURNS_PKG_VIEW);
    }
}
