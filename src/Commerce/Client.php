<?php

namespace Commerce;

use Commerce\Resources\BalanceTransactions;
use Commerce\Resources\Broadcasts;
use Commerce\Resources\MessageTemplates;
use Commerce\Resources\Chimes;
use Commerce\Resources\Customers;
use Commerce\Resources\FinancialAccounts;
use Commerce\Resources\Files;
use Commerce\Resources\FileLinks;
use Commerce\Resources\Orders;
use Commerce\Resources\Otp;
use Commerce\Resources\PaymentMethods;
use Commerce\Resources\Payouts;
use Commerce\Resources\Platform;
use Commerce\Resources\Products;
use Commerce\Resources\Prices;
use Commerce\Resources\Schedules;
use Commerce\Resources\Spec;
use Commerce\Resources\Balances;
use Commerce\Resources\UploadRequests;

class Client
{
    public Orders $orders;
    public PaymentMethods $paymentMethods;
    public Payouts $payouts;
    public BalanceTransactions $balanceTransactions;
    public FinancialAccounts $financialAccounts;
    public Files $files;
    public FileLinks $fileLinks;
    public Customers $customers;
    public Products $products;
    public Prices $prices;
    public Chimes $chimes;
    public Schedules $schedules;
    public Broadcasts $broadcasts;
    public MessageTemplates $messageTemplates;
    public Otp $otp;
    public Platform $platform;
    public Spec $spec;
    public Balances $balances;
    public UploadRequests $uploadRequests;

    private HttpClient $http;

    public function __construct(
        string $apiKey,
        string $baseUrl = 'https://api.zebo.dev',
        int $timeout = 30,
        $adapter = null
    ) {
        $this->http = new HttpClient($apiKey, $baseUrl, $timeout, $adapter);

        $this->orders = new Orders($this->http);
        $this->paymentMethods = new PaymentMethods($this->http);
        $this->payouts = new Payouts($this->http);
        $this->balanceTransactions = new BalanceTransactions($this->http);
        $this->financialAccounts = new FinancialAccounts($this->http);
        $this->files = new Files($this->http);
        $this->fileLinks = new FileLinks($this->http);
        $this->customers = new Customers($this->http);
        $this->products = new Products($this->http);
        $this->prices = new Prices($this->http);
        $this->chimes = new Chimes($this->http);
        $this->schedules = new Schedules($this->http);
        $this->broadcasts = new Broadcasts($this->http);
        $this->messageTemplates = new MessageTemplates($this->http);
        $this->otp = new Otp($this->http);
        $this->platform = new Platform($this->http);
        $this->spec = new Spec($this->http);
        $this->balances = new Balances($this->http);
        $this->uploadRequests = new UploadRequests($this->http);
    }
}
