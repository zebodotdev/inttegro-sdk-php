<?php

namespace Inttegro;

use OpenTelemetry\API\Trace\TracerProviderInterface;
use OpenTelemetry\Context\Propagation\TextMapPropagatorInterface;

use Inttegro\Resources\BalanceTransactions;
use Inttegro\Resources\Broadcasts;
use Inttegro\Resources\MessageTemplates;
use Inttegro\Resources\Chimes;
use Inttegro\Resources\Customers;
use Inttegro\Resources\FinancialAccounts;
use Inttegro\Resources\FileReferences;
use Inttegro\Resources\Files;
use Inttegro\Resources\FileLinks;
use Inttegro\Resources\Keys;
use Inttegro\Resources\Orders;
use Inttegro\Resources\Otp;
use Inttegro\Resources\PaymentMethods;
use Inttegro\Resources\Payouts;
use Inttegro\Resources\Products;
use Inttegro\Resources\PurchaseIntents;
use Inttegro\Resources\Prices;
use Inttegro\Resources\Refunds;
use Inttegro\Resources\Schedules;
use Inttegro\Resources\Spec;
use Inttegro\Resources\Balances;
use Inttegro\Resources\UploadRequests;
use Inttegro\Resources\Apps;

/**
 * Authenticated entry point for every Inttegro API resource.
 *
 * Construct one client with a server-side secret key, then use its typed resource properties for
 * operations. The client owns a shared HTTP transport so timeout, telemetry, error reporting, and
 * test-adapter configuration apply consistently to every request.
 */
class Client
{
    /** Order creation, payment, document, fulfillment, and lifecycle operations. */
    public Orders $orders;
    /** Payment-method tokenization, verification, settings, and lifecycle operations. */
    public PaymentMethods $paymentMethods;
    /** Payout settings, scheduling, lookup, cancellation, and pagination operations. */
    public Payouts $payouts;
    /** Balance-ledger lookup and pagination operations. */
    public BalanceTransactions $balanceTransactions;
    /** Financial-account creation, verification, connection, and lifecycle operations. */
    public FinancialAccounts $financialAccounts;
    /** File-reference reconciliation operations. */
    public FileReferences $fileReferences;
    /** File creation, lookup, download, pagination, and deletion operations. */
    public Files $files;
    /** Public file-link creation, lookup, revocation, and download operations. */
    public FileLinks $fileLinks;
    /** Application secret-key generation, lookup, rotation, revocation, and usage operations. */
    public Keys $keys;
    /** Customer creation, lookup, update, and pagination operations. */
    public Customers $customers;
    /** Product catalog and publication operations. */
    public Products $products;
    /** Purchase-intent creation, lookup, update, cancellation, and pagination operations. */
    public PurchaseIntents $purchaseIntents;
    /** Catalog-price creation, lookup, update, activation, and pagination operations. */
    public Prices $prices;
    /** Refund creation, lookup, cancellation, and pagination operations. */
    public Refunds $refunds;
    /** Notification send, lookup, scheduling, broadcast, and pagination operations. */
    public Chimes $chimes;
    /** Scheduled-notification lookup and cancellation operations. */
    public Schedules $schedules;
    /** Broadcast lookup and cancellation operations. */
    public Broadcasts $broadcasts;
    /** Reusable message-template and preview operations. */
    public MessageTemplates $messageTemplates;
    /** One-time-password initiation, verification, lookup, and cancellation operations. */
    public Otp $otp;
    /** Application creation, lookup, and update operations. */
    public Apps $apps;
    /** Country and payment-rail specification operations. */
    public Spec $spec;
    /** Current application-balance lookup operations. */
    public Balances $balances;
    /** Managed upload-request creation, review, fulfillment, and lifecycle operations. */
    public UploadRequests $uploadRequests;

    private HttpClient $http;

    /**
     * Creates a client and binds every resource to one authenticated transport.
     *
     * Keep `apiKey` in a server-side secret store. The SDK never configures or exports telemetry by
     * itself; optional OpenTelemetry and error-reporting collaborators remain application-owned.
     *
     * @param string $apiKey Required Inttegro secret key. Never expose it to browser or mobile code.
     * @param string $baseUrl API origin; normally leave this at the production default.
     * @param int $timeout Request timeout in seconds.
     * @param mixed $adapter Optional transport adapter used primarily for deterministic tests.
     * @param bool $telemetryEnabled Whether to create vendor-neutral OpenTelemetry spans.
     * @param TracerProviderInterface|null $tracerProvider Application-owned tracer provider.
     * @param TextMapPropagatorInterface|null $propagator Application-owned trace propagator.
     * @param callable(ErrorReport):void|null $errorReporter Privacy-safe terminal-failure callback.
     * @param string $errorReportingPolicy Either `unexpected` or `all`.
     * @throws \InvalidArgumentException When the API key is empty.
     */
    public function __construct(
        string $apiKey,
        string $baseUrl = 'https://api.inttegro.com',
        int $timeout = 30,
        $adapter = null,
        bool $telemetryEnabled = true,
        ?TracerProviderInterface $tracerProvider = null,
        ?TextMapPropagatorInterface $propagator = null,
        ?callable $errorReporter = null,
        string $errorReportingPolicy = 'unexpected'
    ) {
        $this->http = new HttpClient(
            $apiKey,
            $baseUrl,
            $timeout,
            $adapter,
            $telemetryEnabled,
            $tracerProvider,
            $propagator,
            $errorReporter,
            $errorReportingPolicy
        );

        $this->orders = new Orders($this->http);
        $this->paymentMethods = new PaymentMethods($this->http);
        $this->payouts = new Payouts($this->http);
        $this->balanceTransactions = new BalanceTransactions($this->http);
        $this->financialAccounts = new FinancialAccounts($this->http);
        $this->fileReferences = new FileReferences($this->http);
        $this->files = new Files($this->http);
        $this->fileLinks = new FileLinks($this->http);
        $this->keys = new Keys($this->http);
        $this->customers = new Customers($this->http);
        $this->products = new Products($this->http);
        $this->purchaseIntents = new PurchaseIntents($this->http);
        $this->prices = new Prices($this->http);
        $this->refunds = new Refunds($this->http);
        $this->chimes = new Chimes($this->http);
        $this->schedules = new Schedules($this->http);
        $this->broadcasts = new Broadcasts($this->http);
        $this->messageTemplates = new MessageTemplates($this->http);
        $this->otp = new Otp($this->http);
        $this->apps = new Apps($this->http);
        $this->spec = new Spec($this->http);
        $this->balances = new Balances($this->http);
        $this->uploadRequests = new UploadRequests($this->http);
    }
}
