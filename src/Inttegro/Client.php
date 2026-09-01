<?php

namespace Inttegro;

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

class Client
{
    public Orders $orders;
    public PaymentMethods $paymentMethods;
    public Payouts $payouts;
    public BalanceTransactions $balanceTransactions;
    public FinancialAccounts $financialAccounts;
    public FileReferences $fileReferences;
    public Files $files;
    public FileLinks $fileLinks;
    public Keys $keys;
    public Customers $customers;
    public Products $products;
    public PurchaseIntents $purchaseIntents;
    public Prices $prices;
    public Refunds $refunds;
    public Chimes $chimes;
    public Schedules $schedules;
    public Broadcasts $broadcasts;
    public MessageTemplates $messageTemplates;
    public Otp $otp;
    public Apps $apps;
    public Spec $spec;
    public Balances $balances;
    public UploadRequests $uploadRequests;

    private HttpClient $http;

    public function __construct(
        string $apiKey,
        string $baseUrl = 'https://api.inttegro.com',
        int $timeout = 30,
        $adapter = null
    ) {
        $this->http = new HttpClient($apiKey, $baseUrl, $timeout, $adapter);

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
