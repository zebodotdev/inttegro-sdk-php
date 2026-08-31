<?php

namespace Commerce\Resources;

use Commerce\HttpClient;

/**
 * Balance transactions resource for payment- and refund-sourced merchant balance entries.
 *
 * Every transaction has type `payment` or `refund`. The type describes its semantic
 * source, not accounting direction, and exactly one matching payment_id or refund_id.
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
     * Retrieve one transaction with required id, type, order_id, amount, and created_at.
     * When type is payment the response has payment_id; when refund it has refund_id.
     */
    public function lookup(string $transactionId): \Commerce\ResponseObject
    {
        return $this->http->post('/balance_transactions/lookup', ['transaction_id' => $transactionId]);
    }

    /**
     * Retrieve a paginated list of balance transactions.
     *
     * Returns transactions sorted by created_at in descending order (most recent first).
     * Required transaction fields are id, type, order_id, amount, and created_at. Optional
     * payout_id, available_at, claimed_at, and paid_at are included when applicable.
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
     * $page = $result->page;
     * echo "Page {$page['number']} contains {$page['size']} transactions\n";
     *
     * foreach ($page['transactions'] as $txn) {
     *     $sourceId = $txn['type'] === 'payment' ? $txn['payment_id'] : $txn['refund_id'];
     *     echo "Transaction {$txn['id']} ({$txn['type']} {$sourceId}): "
     *         . "{$txn['amount']['value']} {$txn['amount']['currency']}\n";
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
