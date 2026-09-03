<?php

namespace Inttegro\Resources;

use Inttegro\HttpClient;

/**
 * Payouts resource for managing automatic settlements and balance withdrawals.
 *
 * Payouts transfer funds from your Inttegro balance to configured financial accounts.
 * Control payout schedules, set currency-specific destinations, and enable foreign exchange conversion.
 *
 * @see https://studio.inttegro.com/payouts for detailed guides
 */
class Payouts
{
    private HttpClient $http;

    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * Configure which financial account receives payouts for each currency.
     *
     * Maps currency codes to financial account IDs. Each account must support push operations
     * and match the currency it's assigned to. Only balance transactions that have aged at least
     * 168 hours (7 days) are included in payouts.
     *
     * @param array $destinations Map of currency codes to financial account IDs
     *   Example: ['ghs' => 'fa_abc123', 'usd' => 'fa_xyz789']
     *
     * @return \Inttegro\PayoutSettingsMutation Updated payout settings
     *
     * @example Set payout destinations
     * ```php
     * $settings = $client->payouts->setDestinations([
     *     'ghs' => 'fa_mtnmomo_account',
     *     'usd' => 'fa_bank_account'
     * ]);
     *
     * foreach ($settings->destinations ?? [] as $currency => $accountId) {
     *     echo "Payouts in $currency go to $accountId\n";
     * }
     * ```
     *
     * @see https://studio.inttegro.com/manage-payout-destinations for payout destination guide
     */
    public function setDestinations(array $destinations): \Inttegro\PayoutSettingsMutation
    {
        return $this->http->postResource('/payouts/set_destinations', \Inttegro\PayoutSettingsMutation::class, 'settings', ['destinations' => $destinations]);
    }

    /**
     * Retrieve current payout configuration including schedule and destination accounts.
     *
     * Returns the payout schedule (automatic or manual) and the financial accounts configured
     * for each currency. Use this to display current settings to users or verify configuration.
     *
     * @return \Inttegro\PayoutSettingsLookup Payout settings with schedule and destinations
     *
     * @example Get payout settings
     * ```php
     * $settings = $client->payouts->settings();
     * echo "Schedule: {$settings->schedule?->name}\n";
     * echo "Type: {$settings->schedule?->type}\n";
     * ```
     *
     * @see https://studio.inttegro.com/payouts for payout overview
     */
    public function settings(): \Inttegro\PayoutSettingsLookup
    {
        return $this->http->postResource('/payouts/settings', \Inttegro\PayoutSettingsLookup::class, 'settings', []);
    }

    /**
     * Switch payout schedule to manual mode, stopping automatic weekly transfers.
     *
     * When automatic payouts are disabled, you control when funds are transferred to your
     * financial accounts. Use the schedule endpoint to trigger payouts on-demand. Useful for
     * marketplace platforms or when you need explicit control over cash flow timing.
     *
     * @return \Inttegro\PayoutSettingsMutation Updated payout settings with manual schedule
     *
     * @example Disable automatic payouts
     * ```php
     * $settings = $client->payouts->disableAutomatic();
     * if ($settings->schedule?->type === 'manual') {
     *     echo "Automatic payouts disabled. You now control payout timing.\n";
     * }
     * ```
     *
     * @see https://studio.inttegro.com/disable-automatic-payouts for manual payout guide
     */
    public function disableAutomatic(): \Inttegro\PayoutSettingsMutation
    {
        return $this->http->postResource('/payouts/disable', \Inttegro\PayoutSettingsMutation::class, 'settings', []);
    }

    /** Enable automatic payouts. */
    public function enableAutomatic(): \Inttegro\PayoutSettingsMutation
    {
        return $this->http->postResource('/payouts/enable', \Inttegro\PayoutSettingsMutation::class, 'settings', []);
    }

    /**
     * Enable foreign exchange conversion for multi-currency payouts.
     *
     * When FX is enabled, you can receive payouts in a different currency than your balance
     * currency. Inttegro converts funds at market rates during payout execution.
     *
     * @return \Inttegro\PayoutSettingsLookup Updated payout settings
     *
     * @example Enable FX payouts
     * ```php
     * $result = $client->payouts->enableFx();
     * echo "FX conversion enabled for payouts\n";
     * ```
     *
     * @see https://studio.inttegro.com/enable-fx-payouts for FX payout guide
     */
    public function enableFx(): \Inttegro\PayoutSettingsLookup
    {
        return $this->http->postResource('/payouts/enable_fx', \Inttegro\PayoutSettingsLookup::class, 'settings', []);
    }

    /**
     * Disable foreign exchange conversion for payouts.
     *
     * After disabling FX, payouts will only be sent in currencies matching your balance currencies.
     * Any financial accounts configured for non-matching currencies will not receive payouts.
     *
     * @return \Inttegro\PayoutSettingsLookup Updated payout settings
     *
     * @example Disable FX payouts
     * ```php
     * $result = $client->payouts->disableFx();
     * echo "FX conversion disabled. Payouts will match balance currencies.\n";
     * ```
     *
     * @see https://studio.inttegro.com/payouts-fx-conversion for FX details
     */
    public function disableFx(): \Inttegro\PayoutSettingsLookup
    {
        return $this->http->postResource('/payouts/disable_fx', \Inttegro\PayoutSettingsLookup::class, 'settings', []);
    }

    /**
     * Retrieve a paginated list of payout history.
     *
     * Returns payouts sorted by initiated_at in descending order (most recent first).
     * Each payout includes amount, currency, destination account, status, and execution timestamps.
     *
     * @param array $payload Pagination parameters (optional)
     *   - page_number: int - 1-based page index (1-10, default: 1)
     *   - page_size: int - Results per page (1-256, default varies)
     *
     * @return \Inttegro\PayoutPage Paginated payout list with page details
     *
     * @example Get recent payouts
     * ```php
     * $page = $client->payouts->page([
     *     'page_number' => 1,
     *     'page_size' => 20
     * ]);
     *
     * echo "Page {$page->number} contains {$page->size} payouts\n";
     *
     * foreach ($page->payouts ?? [] as $payout) {
     *     echo "Payout {$payout->id}: {$payout->amount?->value} {$payout->amount?->currency}\n";
     * }
     * ```
     *
     * @see https://studio.inttegro.com/pagination for pagination guide
     * @see https://studio.inttegro.com/payouts for payout overview
     */
    public function page(array $payload = []): \Inttegro\PayoutPage
    {
        return $this->http->postResource('/payouts/page', \Inttegro\PayoutPage::class, 'page', $payload);
    }

    /** Schedule a payout to a financial account. */
    public function schedule(array $payload): \Inttegro\Payout
    {
        return $this->http->postResource('/payouts/schedule', \Inttegro\Payout::class, 'payout', $payload);
    }

    /** Lookup a payout by ID. */
    public function lookup(string $payoutId): \Inttegro\Payout
    {
        return $this->http->postResource('/payouts/lookup', \Inttegro\Payout::class, 'payout', ['payout_id' => $payoutId]);
    }

    /**
     * Cancel a scheduled payout before execution.
     *
     * Only payouts with `scheduled` status and future execution windows can be canceled.
     *
     * @param string $payoutId Scheduled payout ID
     *
     * @return \Inttegro\Payout Canceled payout payload
     */
    public function cancel(string $payoutId): \Inttegro\Payout
    {
        return $this->http->postResource('/payouts/cancel', \Inttegro\Payout::class, 'payout', ['payout_id' => $payoutId]);
    }
}
