<?php

namespace Commerce\Resources;

use Commerce\HttpClient;

/**
 * Balance transactions resource for tracking balance movements and payout eligibility.
 *
 * Balance transactions record every change to your Commerce balance, including charges,
 * refunds, fees, and payouts. Each transaction shows amounts, currency, source, and aging
 * status for payout eligibility.
 *
 * @see https://studio.inttegro.com/balance-transactions for detailed guide
 */
class BalanceTransactions
{
    private HttpClient $http;

    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * Retrieve a paginated list of balance transactions.
     *
     * Returns transactions sorted by created_at in descending order (most recent first).
     * Transactions show gross amount, fees, net amount, source (order/refund/payout), and
     * payout eligibility. Transactions must age 168 hours (7 days) before becoming payout-eligible.
     *
     * @param array $payload Pagination parameters (optional)
     *   - page_number: int - 0-based page index (0-10, default: 0)
     *   - page_size: int - Results per page (1-256, default varies)
     *
     * @return \Commerce\ResponseObject Paginated transaction list with page details
     *
     * @example Get recent balance transactions
     * ```php
     * $result = $client->balanceTransactions->page([
     *     'page_number' => 0,
     *     'page_size' => 25
     * ]);
     *
     * $page = $result->data['page'];
     * echo "Page {$page['number']} contains {$page['size']} transactions\n";
     *
     * foreach ($page['transactions'] as $txn) {
     *     $net = $txn['net'];
     *     echo "Transaction {$txn['id']}: {$net['value']} {$net['currency']}\n";
     *     echo "  Source: {$txn['source']['type']}\n";
     *     echo "  Payout eligible: " . ($txn['available_for_payout'] ? 'yes' : 'no') . "\n";
     * }
     * ```
     *
     * @see https://studio.inttegro.com/balance-transactions for balance transaction guide
     * @see https://studio.inttegro.com/pagination for pagination guide
     */
    public function page(array $payload = []): \Commerce\ResponseObject
    {
        return $this->http->post('/balance_transactions/page', $payload);
    }
}
