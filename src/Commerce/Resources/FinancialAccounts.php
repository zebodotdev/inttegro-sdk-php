<?php

namespace Commerce\Resources;

use Commerce\HttpClient;

/**
 * Financial accounts resource for managing payout destinations.
 *
 * Financial accounts represent where your Commerce balance gets paid out. Create mobile money,
 * bank_account, or dosh_account accounts, configure them for push (payouts) or pull (charges) operations,
 * and connect them to your application for automatic settlements.
 *
 * @see https://studio.inttegro.com/financial-accounts for detailed guides
 */
class FinancialAccounts
{
    private HttpClient $http;

    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * Create a new financial account for receiving payouts.
     *
     * Creates a wallet (mobile money), bank_account, or dosh_account account. Configure whether the account
     * supports push operations (receiving payouts), pull operations (being charged), or both.
     * Accounts must be verified before use.
     *
     * @param array $payload Account creation parameters
     *   - label: string - Account label (5-40 characters, required)
     *   - type: string - Account type: 'wallet', 'bank_account', or 'dosh_account' (required)
     *   - reference: string - External reference ID (5-40 characters, required)
     *   - currency: string - Account currency, currently only 'ghs' supported (required)
     *   - description: string - Optional description (0-200 characters)
     *   - pull_configuration: array - Settings for charging this account
     *   - push_configuration: array - Settings for sending payouts to this account
     *   - custom_data: array - Optional key-value metadata (string-to-string)
     *   - owner: array - Account owner information (required)
     *     - name: string - Owner full name
     *     - address: array - Owner address (name, line_1, city, region, country)
     *   - bank_account: array - Bank account configuration (required when type is 'bank_account')
     *     - type: string - 'ghana_bank_account'
     *     - ghana_bank_account: array
     *       - bank_name: string - Bank name
     *       - branch: string - Branch name or identifier
     *       - number: string - Bank account number
     *       - sort_code: string - Required if swift_code is not provided
     *       - swift_code: string - Required if sort_code is not provided
     *       - holder: array
     *         - name: string - Account holder full name
     *         - address: array
     *           - name: string - Address label
     *           - line_1: string - Address line 1
     *           - city: string - City or town
     *           - region: string - Region or state
     *           - country: string - Country code or name
     *
     * @return \Commerce\ResponseObject Created financial account
     *
     * @example Create mobile money account for payouts
     * ```php
     * $result = $client->financialAccounts->create([
     *     'label' => 'MTN Mobile Money',
     *     'type' => 'wallet',
     *     'reference' => 'mtn-primary-2025',
     *     'currency' => 'ghs',
     *     'description' => 'Primary MTN MoMo account for payouts',
     *     'wallet' => [
     *         'type' => 'mobile_money',
     *         'mobile_money' => [
     *             'network' => 'mtn',
     *             'account_number' => '0541234567'
     *         ]
     *     ],
     *     'push_configuration' => [
     *         'enabled' => true
     *     ]
     * ]);
     *
     * $account = $result->data['financial_account'];
     * echo "Account created: {$account['id']}\n";
     * echo "Status: {$account['status']}\n";
     * ```
     *
     * @see https://studio.inttegro.com/set-up-financial-account for account setup guide
     */
    public function create(array $payload): \Commerce\ResponseObject
    {
        return $this->http->post('/financial_accounts/create', $payload);
    }

    /**
     * Retrieve details of an existing financial account.
     *
     * Returns full account information including type, currency, configuration, verification
     * status, and masked account details. Use this to display account information to users
     * or check account status before operations.
     *
     * @param string $accountId Unique identifier of the financial account to retrieve (required)
     *
     * @return \Commerce\ResponseObject Complete financial account object
     *
     * @example Lookup a financial account
     * ```php
     * $result = $client->financialAccounts->lookup(
     *     'fa_abc123xyz'
     * );
     *
     * $account = $result->data['financial_account'];
     * echo "Label: {$account['label']}\n";
     * echo "Type: {$account['type']}\n";
     * echo "Currency: {$account['currency']}\n";
     * echo "Status: {$account['status']}\n";
     * ```
     *
     * @see https://studio.inttegro.com/financial-accounts for financial account overview
     */
    public function lookup(string $accountId): \Commerce\ResponseObject
    {
        return $this->http->post('/financial_accounts/lookup', ['account_id' => $accountId]);
    }

    /**
     * Connect a financial account for payouts.
     *
     * Creates and connects a new financial account. This endpoint is an alias for create()
     * and accepts the same payload fields.
     *
     * @param array $payload Connection parameters (same as create)
     *   - label: string - Account label (5-40 characters, required)
     *   - type: string - Account type: 'wallet', 'bank_account', or 'dosh_account' (required)
     *   - reference: string - External reference ID (5-40 characters, required)
     *   - currency: string - Account currency, currently only 'ghs' supported (required)
     *   - description: string - Optional description (0-200 characters)
     *   - pull_configuration: array - Settings for charging this account
     *   - pull_configuration.mandate: array - Optional mandate parameters (created automatically)
     *   - push_configuration: array - Settings for sending payouts to this account
     *   - custom_data: array - Optional key-value metadata (string-to-string)
     *   - owner: array - Account owner information (required)
     *     - name: string - Owner full name
     *     - address: array - Owner address (name, line_1, city, region, country)
     *
     * @return \Commerce\ResponseObject Connected financial account
     *
     * @example Connect a mobile money account
     * ```php
     * $result = $client->financialAccounts->connect([
     *     'label' => 'MTN Mobile Money',
     *     'type' => 'wallet',
     *     'reference' => 'mtn-primary-2025',
     *     'currency' => 'ghs',
     *     'wallet' => [
     *         'type' => 'mobile_money',
     *         'mobile_money' => [
     *             'account_number' => '0541234567',
     *             'network' => 'mtn'
     *         ]
     *     ],
     *     'push_configuration' => ['enabled' => true]
     * ]);
     *
     * $account = $result->data['financial_account'];
     * echo "Account connected and ready for payouts\n";
     * ```
     *
     * @see https://studio.inttegro.com/set-up-financial-account for connection guide
     */
    public function connect(array $payload): \Commerce\ResponseObject
    {
        return $this->http->post('/financial_accounts/connect', $payload);
    }

    /**
     * Archive a financial account, preventing it from receiving payouts or being charged.
     *
     * Archived accounts are hidden from active account lists but remain in your account history.
     * Use this when an account is no longer valid or needed. Archiving is reversible—you can
     * create a new account with the same details if needed.
     *
     * @param array $payload Archive parameters
     *   - account_id: string - Financial account to archive (required)
     *   - Additional parameters may be accepted
     *
     * @return \Commerce\ResponseObject Archived financial account
     *
     * @example Archive a financial account
     * ```php
     * $result = $client->financialAccounts->archive([
     *     'account_id' => 'fa_abc123xyz'
     * ]);
     *
     * echo "Account archived\n";
     * ```
     *
     * @see https://studio.inttegro.com/financial-accounts for account management
     */
    public function archive(array $payload): \Commerce\ResponseObject
    {
        return $this->http->post('/financial_accounts/archive', $payload);
    }

    /**
     * Retrieve a paginated list of financial accounts.
     *
     * Returns accounts associated with your application. Use this to display available payout
     * destinations to users or manage account inventory programmatically.
     *
     * @param array $payload Pagination parameters (optional)
     *   - Pagination and filtering options (specific parameters depend on implementation)
     *
     * @return \Commerce\ResponseObject Paginated list of financial accounts
     *
     * @example Get financial accounts
     * ```php
     * $result = $client->financialAccounts->page();
     *
     * $accounts = $result->data['financial_accounts'] ?? [];
     * foreach ($accounts as $account) {
     *     echo "{$account['label']} ({$account['type']}): {$account['currency']}\n";
     * }
     * ```
     *
     * @see https://studio.inttegro.com/financial-accounts for account overview
     * @see https://studio.inttegro.com/pagination for pagination guide
     */
    public function page(array $payload = []): \Commerce\ResponseObject
    {
        return $this->http->post('/financial_accounts/page', $payload);
    }

    /**
     * Verify a financial account to enable payout operations.
     *
     * Initiates or completes the verification process for a financial account. Verification
     * confirms account ownership and enables the account to receive payouts. The specific
     * verification process depends on the account type.
     *
     * @param array $payload Verification parameters
     *   - account_id: string - Financial account to verify (required)
     *   - Verification-specific parameters depend on account type
     *
     * @return \Commerce\ResponseObject Verified financial account
     *
     * @example Verify a financial account
     * ```php
     * $result = $client->financialAccounts->verify([
     *     'account_id' => 'fa_abc123xyz'
     * ]);
     *
     * $account = $result->data['financial_account'];
     * if ($account['status'] === 'verified') {
     *     echo "Account verified and ready for use\n";
     * }
     * ```
     *
     * @see https://studio.inttegro.com/set-up-financial-account for verification guide
     */
    public function verify(array $payload): \Commerce\ResponseObject
    {
        return $this->http->post('/financial_accounts/verify', $payload);
    }

    /**
     * Update a financial account (POST /financial_accounts/update).
     *
     * All fields except account_id are optional. custom_data merges with existing data.
     *
     * @param array $payload Update parameters including account_id
     *
     * @return \Commerce\ResponseObject Updated financial account
     */
    public function update(array $payload): \Commerce\ResponseObject
    {
        return $this->http->post('/financial_accounts/update', $payload);
    }

    /** Enable push configuration for payouts. */
    public function enablePush(string $accountId): \Commerce\ResponseObject
    {
        return $this->http->post('/financial_accounts/enable_push', ['account_id' => $accountId]);
    }

    /**
     * Disable push configuration for payouts.
     *
     * Accepts either a financial account ID string or a payload with optional
     * unset_as_payout_destination.
     */
    public function disablePush($accountIdOrPayload): \Commerce\ResponseObject
    {
        $payload = is_array($accountIdOrPayload)
            ? $accountIdOrPayload
            : ['account_id' => $accountIdOrPayload];

        return $this->http->post('/financial_accounts/disable_push', $payload);
    }

    /** Enable pull configuration for charges (creates mandate). */
    public function enablePull(string $accountId): \Commerce\ResponseObject
    {
        return $this->http->post('/financial_accounts/enable_pull', ['account_id' => $accountId]);
    }

    /** Disable pull configuration for charges. */
    public function disablePull(string $accountId): \Commerce\ResponseObject
    {
        return $this->http->post('/financial_accounts/disable_pull', ['account_id' => $accountId]);
    }

    /**
     * Disconnect a financial account.
     *
     * Accepts either a financial account ID string or a payload with optional
     * unset_as_payout_destination.
     */
    public function disconnect($accountIdOrPayload): \Commerce\ResponseObject
    {
        $payload = is_array($accountIdOrPayload)
            ? $accountIdOrPayload
            : ['account_id' => $accountIdOrPayload];

        return $this->http->post('/financial_accounts/disconnect', $payload);
    }

    /** Reconnect a previously disconnected financial account. */
    public function reconnect(string $accountId): \Commerce\ResponseObject
    {
        return $this->http->post('/financial_accounts/reconnect', ['account_id' => $accountId]);
    }
}
