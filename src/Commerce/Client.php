<?php

namespace Commerce;

use Commerce\Resources\BalanceTransactions;
use Commerce\Resources\Chimes;
use Commerce\Resources\FinancialAccounts;
use Commerce\Resources\Orders;
use Commerce\Resources\Otp;
use Commerce\Resources\PaymentMethods;
use Commerce\Resources\Payouts;
use Commerce\Resources\Platform;
use Commerce\Resources\Spec;

class Client
{
    public Orders $orders;
    public PaymentMethods $paymentMethods;
    public Payouts $payouts;
    public BalanceTransactions $balanceTransactions;
    public FinancialAccounts $financialAccounts;
    public Chimes $chimes;
    public Otp $otp;
    public Platform $platform;
    public Spec $spec;

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
        $this->chimes = new Chimes($this->http);
        $this->otp = new Otp($this->http);
        $this->platform = new Platform($this->http);
        $this->spec = new Spec($this->http);
    }
}
