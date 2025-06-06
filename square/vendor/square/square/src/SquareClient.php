<?php

declare(strict_types=1);

namespace Square;

use Square\Apis;

/**
 * Square client class
 */
class SquareClient implements ConfigurationInterface
{
    private $mobileAuthorization;
    private $oAuth;
    private $v1Transactions;
    private $applePay;
    private $bankAccounts;
    private $bookings;
    private $cards;
    private $cashDrawers;
    private $catalog;
    private $customers;
    private $customerCustomAttributes;
    private $customerGroups;
    private $customerSegments;
    private $devices;
    private $disputes;
    private $employees;
    private $giftCards;
    private $giftCardActivities;
    private $inventory;
    private $invoices;
    private $labor;
    private $locations;
    private $checkout;
    private $transactions;
    private $loyalty;
    private $merchants;
    private $orders;
    private $payments;
    private $payouts;
    private $refunds;
    private $sites;
    private $snippets;
    private $subscriptions;
    private $team;
    private $terminal;
    private $vendors;

    private $timeout = ConfigurationDefaults::TIMEOUT;
    private $enableRetries = ConfigurationDefaults::ENABLE_RETRIES;
    private $numberOfRetries = ConfigurationDefaults::NUMBER_OF_RETRIES;
    private $retryInterval = ConfigurationDefaults::RETRY_INTERVAL;
    private $backOffFactor = ConfigurationDefaults::BACK_OFF_FACTOR;
    private $maximumRetryWaitTime = ConfigurationDefaults::MAXIMUM_RETRY_WAIT_TIME;
    private $retryOnTimeout = ConfigurationDefaults::RETRY_ON_TIMEOUT;
    private $httpStatusCodesToRetry = ConfigurationDefaults::HTTP_STATUS_CODES_TO_RETRY;
    private $httpMethodsToRetry = ConfigurationDefaults::HTTP_METHODS_TO_RETRY;
    private $squareVersion = ConfigurationDefaults::SQUARE_VERSION;
    private $additionalHeaders = ConfigurationDefaults::ADDITIONAL_HEADERS;
    private $userAgentDetail = ConfigurationDefaults::USER_AGENT_DETAIL;
    private $environment = ConfigurationDefaults::ENVIRONMENT;
    private $customUrl = ConfigurationDefaults::CUSTOM_URL;
    private $accessToken = ConfigurationDefaults::ACCESS_TOKEN;
    private $bearerAuthManager;
    private $authManagers = [];
    private $httpCallback;

    public function __construct(array $configOptions = null)
    {
        if (isset($configOptions['timeout'])) {
            $this->timeout = $configOptions['timeout'];
        }
        if (isset($configOptions['enableRetries'])) {
            $this->enableRetries = $configOptions['enableRetries'];
        }
        if (isset($configOptions['numberOfRetries'])) {
            $this->numberOfRetries = $configOptions['numberOfRetries'];
        }
        if (isset($configOptions['retryInterval'])) {
            $this->retryInterval = $configOptions['retryInterval'];
        }
        if (isset($configOptions['backOffFactor'])) {
            $this->backOffFactor = $configOptions['backOffFactor'];
        }
        if (isset($configOptions['maximumRetryWaitTime'])) {
            $this->maximumRetryWaitTime = $configOptions['maximumRetryWaitTime'];
        }
        if (isset($configOptions['retryOnTimeout'])) {
            $this->retryOnTimeout = $configOptions['retryOnTimeout'];
        }
        if (isset($configOptions['httpStatusCodesToRetry'])) {
            $this->httpStatusCodesToRetry = $configOptions['httpStatusCodesToRetry'];
        }
        if (isset($configOptions['httpMethodsToRetry'])) {
            $this->httpMethodsToRetry = $configOptions['httpMethodsToRetry'];
        }
        if (isset($configOptions['squareVersion'])) {
            $this->squareVersion = $configOptions['squareVersion'];
        }
        if (isset($configOptions['additionalHeaders'])) {
            ApiHelper::assertHeaders($configOptions['additionalHeaders']);
            $this->additionalHeaders = $configOptions['additionalHeaders'];
        }
        if (isset($configOptions['userAgentDetail'])) {
            $this->assertUserAgentDetail($configOptions['userAgentDetail']);
            $this->userAgentDetail = $configOptions['userAgentDetail'];
        }
        if (isset($configOptions['environment'])) {
            $this->environment = $configOptions['environment'];
        }
        if (isset($configOptions['customUrl'])) {
            $this->customUrl = $configOptions['customUrl'];
        }
        if (isset($configOptions['accessToken'])) {
            $this->accessToken = $configOptions['accessToken'];
        }
        if (isset($configOptions['httpCallback'])) {
            $this->httpCallback = $configOptions['httpCallback'];
        }

        $this->bearerAuthManager = new BearerAuthManager($this->accessToken);
        $this->authManagers['global'] = $this->bearerAuthManager;
    }

    /**
     * Get the client configuration as an associative array
     */
    public function getConfiguration(): array
    {
        $configMap = [];

        if (isset($this->timeout)) {
            $configMap['timeout'] = $this->timeout;
        }
        if (isset($this->enableRetries)) {
            $configMap['enableRetries'] = $this->enableRetries;
        }
        if (isset($this->numberOfRetries)) {
            $configMap['numberOfRetries'] = $this->numberOfRetries;
        }
        if (isset($this->retryInterval)) {
            $configMap['retryInterval'] = $this->retryInterval;
        }
        if (isset($this->backOffFactor)) {
            $configMap['backOffFactor'] = $this->backOffFactor;
        }
        if (isset($this->maximumRetryWaitTime)) {
            $configMap['maximumRetryWaitTime'] = $this->maximumRetryWaitTime;
        }
        if (isset($this->retryOnTimeout)) {
            $configMap['retryOnTimeout'] = $this->retryOnTimeout;
        }
        if (isset($this->httpStatusCodesToRetry)) {
            $configMap['httpStatusCodesToRetry'] = $this->httpStatusCodesToRetry;
        }
        if (isset($this->httpMethodsToRetry)) {
            $configMap['httpMethodsToRetry'] = $this->httpMethodsToRetry;
        }
        if (isset($this->squareVersion)) {
            $configMap['squareVersion'] = $this->squareVersion;
        }
        if (isset($this->additionalHeaders)) {
            $configMap['additionalHeaders'] = $this->additionalHeaders;
        }
        if (isset($this->userAgentDetail)) {
            $configMap['userAgentDetail'] = $this->userAgentDetail;
        }
        if (isset($this->environment)) {
            $configMap['environment'] = $this->environment;
        }
        if (isset($this->customUrl)) {
            $configMap['customUrl'] = $this->customUrl;
        }
        if ($this->bearerAuthManager->getAccessToken() !== null) {
            $configMap['accessToken'] = $this->bearerAuthManager->getAccessToken();
        }
        if (isset($this->httpCallback)) {
            $configMap['httpCallback'] = $this->httpCallback;
        }

        return $configMap;
    }

    /**
     * Clone this client and override given configuration options
     */
    public function withConfiguration(array $configOptions): self
    {
        return new self(\array_merge($this->getConfiguration(), $configOptions));
    }

    public function getTimeout(): int
    {
        return $this->timeout;
    }

    public function shouldEnableRetries(): bool
    {
        return $this->enableRetries;
    }

    public function getNumberOfRetries(): int
    {
        return $this->numberOfRetries;
    }

    public function getRetryInterval(): float
    {
        return $this->retryInterval;
    }

    public function getBackOffFactor(): float
    {
        return $this->backOffFactor;
    }

    public function getMaximumRetryWaitTime(): int
    {
        return $this->maximumRetryWaitTime;
    }

    public function shouldRetryOnTimeout(): bool
    {
        return $this->retryOnTimeout;
    }

    public function getHttpStatusCodesToRetry(): array
    {
        return $this->httpStatusCodesToRetry;
    }

    public function getHttpMethodsToRetry(): array
    {
        return $this->httpMethodsToRetry;
    }

    public function getSquareVersion(): string
    {
        return $this->squareVersion;
    }

    public function getAdditionalHeaders(): array
    {
        return $this->additionalHeaders;
    }

    public function getUserAgentDetail(): string
    {
        return $this->userAgentDetail;
    }

    public function getEnvironment(): string
    {
        return $this->environment;
    }

    public function getCustomUrl(): string
    {
        return $this->customUrl;
    }

    public function getBearerAuthCredentials(): ?BearerAuthCredentials
    {
        return $this->bearerAuthManager;
    }

    /**
     * Get current SDK version
     */
    public function getSdkVersion(): string
    {
        return '20.1.0.20220720';
    }

    /**
     * Checks userAgentDetail's value, and throw exception if exceeding length limit
     *
     * @param string $userAgentDetail user agent detail value to be checked
     *
     * @throws \InvalidArgumentException
     */
    private function assertUserAgentDetail(string $userAgentDetail): void
    {
        if (strlen($userAgentDetail) > 128) {
            throw new \InvalidArgumentException('The length of user-agent detail should not exceed 128 characters.');
        }
    }

    /**
     * Get the base uri for a given server in the current environment
     *
     * @param  string $server Server name
     *
     * @return string         Base URI
     */
    public function getBaseUri(string $server = Server::DEFAULT_): string
    {
        return ApiHelper::appendUrlWithTemplateParameters(
            static::ENVIRONMENT_MAP[$this->environment][$server],
            [
                'custom_url' => $this->customUrl,
            ],
            false
        );
    }

    /**
     * Returns Mobile Authorization Api
     */
    public function getMobileAuthorizationApi(): Apis\MobileAuthorizationApi
    {
        if ($this->mobileAuthorization == null) {
            $this->mobileAuthorization = new Apis\MobileAuthorizationApi(
                $this,
                $this->authManagers,
                $this->httpCallback
            );
        }
        return $this->mobileAuthorization;
    }

    /**
     * Returns O Auth Api
     */
    public function getOAuthApi(): Apis\OAuthApi
    {
        if ($this->oAuth == null) {
            $this->oAuth = new Apis\OAuthApi($this, $this->authManagers, $this->httpCallback);
        }
        return $this->oAuth;
    }

    /**
     * Returns V1 Transactions Api
     */
    public function getV1TransactionsApi(): Apis\V1TransactionsApi
    {
        if ($this->v1Transactions == null) {
            $this->v1Transactions = new Apis\V1TransactionsApi(
                $this,
                $this->authManagers,
                $this->httpCallback
            );
        }
        return $this->v1Transactions;
    }

    /**
     * Returns Apple Pay Api
     */
    public function getApplePayApi(): Apis\ApplePayApi
    {
        if ($this->applePay == null) {
            $this->applePay = new Apis\ApplePayApi($this, $this->authManagers, $this->httpCallback);
        }
        return $this->applePay;
    }

    /**
     * Returns Bank Accounts Api
     */
    public function getBankAccountsApi(): Apis\BankAccountsApi
    {
        if ($this->bankAccounts == null) {
            $this->bankAccounts = new Apis\BankAccountsApi($this, $this->authManagers, $this->httpCallback);
        }
        return $this->bankAccounts;
    }

    /**
     * Returns Bookings Api
     */
    public function getBookingsApi(): Apis\BookingsApi
    {
        if ($this->bookings == null) {
            $this->bookings = new Apis\BookingsApi($this, $this->authManagers, $this->httpCallback);
        }
        return $this->bookings;
    }

    /**
     * Returns Cards Api
     */
    public function getCardsApi(): Apis\CardsApi
    {
        if ($this->cards == null) {
            $this->cards = new Apis\CardsApi($this, $this->authManagers, $this->httpCallback);
        }
        return $this->cards;
    }

    /**
     * Returns Cash Drawers Api
     */
    public function getCashDrawersApi(): Apis\CashDrawersApi
    {
        if ($this->cashDrawers == null) {
            $this->cashDrawers = new Apis\CashDrawersApi($this, $this->authManagers, $this->httpCallback);
        }
        return $this->cashDrawers;
    }

    /**
     * Returns Catalog Api
     */
    public function getCatalogApi(): Apis\CatalogApi
    {
        if ($this->catalog == null) {
            $this->catalog = new Apis\CatalogApi($this, $this->authManagers, $this->httpCallback);
        }
        return $this->catalog;
    }

    /**
     * Returns Customers Api
     */
    public function getCustomersApi(): Apis\CustomersApi
    {
        if ($this->customers == null) {
            $this->customers = new Apis\CustomersApi($this, $this->authManagers, $this->httpCallback);
        }
        return $this->customers;
    }

    /**
     * Returns Customer Custom Attributes Api
     */
    public function getCustomerCustomAttributesApi(): Apis\CustomerCustomAttributesApi
    {
        if ($this->customerCustomAttributes == null) {
            $this->customerCustomAttributes = new Apis\CustomerCustomAttributesApi(
                $this,
                $this->authManagers,
                $this->httpCallback
            );
        }
        return $this->customerCustomAttributes;
    }

    /**
     * Returns Customer Groups Api
     */
    public function getCustomerGroupsApi(): Apis\CustomerGroupsApi
    {
        if ($this->customerGroups == null) {
            $this->customerGroups = new Apis\CustomerGroupsApi(
                $this,
                $this->authManagers,
                $this->httpCallback
            );
        }
        return $this->customerGroups;
    }

    /**
     * Returns Customer Segments Api
     */
    public function getCustomerSegmentsApi(): Apis\CustomerSegmentsApi
    {
        if ($this->customerSegments == null) {
            $this->customerSegments = new Apis\CustomerSegmentsApi(
                $this,
                $this->authManagers,
                $this->httpCallback
            );
        }
        return $this->customerSegments;
    }

    /**
     * Returns Devices Api
     */
    public function getDevicesApi(): Apis\DevicesApi
    {
        if ($this->devices == null) {
            $this->devices = new Apis\DevicesApi($this, $this->authManagers, $this->httpCallback);
        }
        return $this->devices;
    }

    /**
     * Returns Disputes Api
     */
    public function getDisputesApi(): Apis\DisputesApi
    {
        if ($this->disputes == null) {
            $this->disputes = new Apis\DisputesApi($this, $this->authManagers, $this->httpCallback);
        }
        return $this->disputes;
    }

    /**
     * Returns Employees Api
     */
    public function getEmployeesApi(): Apis\EmployeesApi
    {
        if ($this->employees == null) {
            $this->employees = new Apis\EmployeesApi($this, $this->authManagers, $this->httpCallback);
        }
        return $this->employees;
    }

    /**
     * Returns Gift Cards Api
     */
    public function getGiftCardsApi(): Apis\GiftCardsApi
    {
        if ($this->giftCards == null) {
            $this->giftCards = new Apis\GiftCardsApi($this, $this->authManagers, $this->httpCallback);
        }
        return $this->giftCards;
    }

    /**
     * Returns Gift Card Activities Api
     */
    public function getGiftCardActivitiesApi(): Apis\GiftCardActivitiesApi
    {
        if ($this->giftCardActivities == null) {
            $this->giftCardActivities = new Apis\GiftCardActivitiesApi(
                $this,
                $this->authManagers,
                $this->httpCallback
            );
        }
        return $this->giftCardActivities;
    }

    /**
     * Returns Inventory Api
     */
    public function getInventoryApi(): Apis\InventoryApi
    {
        if ($this->inventory == null) {
            $this->inventory = new Apis\InventoryApi($this, $this->authManagers, $this->httpCallback);
        }
        return $this->inventory;
    }

    /**
     * Returns Invoices Api
     */
    public function getInvoicesApi(): Apis\InvoicesApi
    {
        if ($this->invoices == null) {
            $this->invoices = new Apis\InvoicesApi($this, $this->authManagers, $this->httpCallback);
        }
        return $this->invoices;
    }

    /**
     * Returns Labor Api
     */
    public function getLaborApi(): Apis\LaborApi
    {
        if ($this->labor == null) {
            $this->labor = new Apis\LaborApi($this, $this->authManagers, $this->httpCallback);
        }
        return $this->labor;
    }

    /**
     * Returns Locations Api
     */
    public function getLocationsApi(): Apis\LocationsApi
    {
        if ($this->locations == null) {
            $this->locations = new Apis\LocationsApi($this, $this->authManagers, $this->httpCallback);
        }
        return $this->locations;
    }

    /**
     * Returns Checkout Api
     */
    public function getCheckoutApi(): Apis\CheckoutApi
    {
        if ($this->checkout == null) {
            $this->checkout = new Apis\CheckoutApi($this, $this->authManagers, $this->httpCallback);
        }
        return $this->checkout;
    }

    /**
     * Returns Transactions Api
     */
    public function getTransactionsApi(): Apis\TransactionsApi
    {
        if ($this->transactions == null) {
            $this->transactions = new Apis\TransactionsApi($this, $this->authManagers, $this->httpCallback);
        }
        return $this->transactions;
    }

    /**
     * Returns Loyalty Api
     */
    public function getLoyaltyApi(): Apis\LoyaltyApi
    {
        if ($this->loyalty == null) {
            $this->loyalty = new Apis\LoyaltyApi($this, $this->authManagers, $this->httpCallback);
        }
        return $this->loyalty;
    }

    /**
     * Returns Merchants Api
     */
    public function getMerchantsApi(): Apis\MerchantsApi
    {
        if ($this->merchants == null) {
            $this->merchants = new Apis\MerchantsApi($this, $this->authManagers, $this->httpCallback);
        }
        return $this->merchants;
    }

    /**
     * Returns Orders Api
     */
    public function getOrdersApi(): Apis\OrdersApi
    {
        if ($this->orders == null) {
            $this->orders = new Apis\OrdersApi($this, $this->authManagers, $this->httpCallback);
        }
        return $this->orders;
    }

    /**
     * Returns Payments Api
     */
    public function getPaymentsApi(): Apis\PaymentsApi
    {
        if ($this->payments == null) {
            $this->payments = new Apis\PaymentsApi($this, $this->authManagers, $this->httpCallback);
        }
        return $this->payments;
    }

    /**
     * Returns Payouts Api
     */
    public function getPayoutsApi(): Apis\PayoutsApi
    {
        if ($this->payouts == null) {
            $this->payouts = new Apis\PayoutsApi($this, $this->authManagers, $this->httpCallback);
        }
        return $this->payouts;
    }

    /**
     * Returns Refunds Api
     */
    public function getRefundsApi(): Apis\RefundsApi
    {
        if ($this->refunds == null) {
            $this->refunds = new Apis\RefundsApi($this, $this->authManagers, $this->httpCallback);
        }
        return $this->refunds;
    }

    /**
     * Returns Sites Api
     */
    public function getSitesApi(): Apis\SitesApi
    {
        if ($this->sites == null) {
            $this->sites = new Apis\SitesApi($this, $this->authManagers, $this->httpCallback);
        }
        return $this->sites;
    }

    /**
     * Returns Snippets Api
     */
    public function getSnippetsApi(): Apis\SnippetsApi
    {
        if ($this->snippets == null) {
            $this->snippets = new Apis\SnippetsApi($this, $this->authManagers, $this->httpCallback);
        }
        return $this->snippets;
    }

    /**
     * Returns Subscriptions Api
     */
    public function getSubscriptionsApi(): Apis\SubscriptionsApi
    {
        if ($this->subscriptions == null) {
            $this->subscriptions = new Apis\SubscriptionsApi(
                $this,
                $this->authManagers,
                $this->httpCallback
            );
        }
        return $this->subscriptions;
    }

    /**
     * Returns Team Api
     */
    public function getTeamApi(): Apis\TeamApi
    {
        if ($this->team == null) {
            $this->team = new Apis\TeamApi($this, $this->authManagers, $this->httpCallback);
        }
        return $this->team;
    }

    /**
     * Returns Terminal Api
     */
    public function getTerminalApi(): Apis\TerminalApi
    {
        if ($this->terminal == null) {
            $this->terminal = new Apis\TerminalApi($this, $this->authManagers, $this->httpCallback);
        }
        return $this->terminal;
    }

    /**
     * Returns Vendors Api
     */
    public function getVendorsApi(): Apis\VendorsApi
    {
        if ($this->vendors == null) {
            $this->vendors = new Apis\VendorsApi($this, $this->authManagers, $this->httpCallback);
        }
        return $this->vendors;
    }

    /**
     * A map of all baseurls used in different environments and servers
     *
     * @var array
     */
    private const ENVIRONMENT_MAP = [
        Environment::PRODUCTION => [
            Server::DEFAULT_ => 'https://connect.squareup.com',
        ],
        Environment::SANDBOX => [
            Server::DEFAULT_ => 'https://connect.squareupsandbox.com',
        ],
        Environment::CUSTOM => [
            Server::DEFAULT_ => '{custom_url}',
        ],
    ];
}
