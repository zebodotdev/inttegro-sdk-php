<?php

namespace Inttegro\Resources;

use Inttegro\HttpClient;

/**
 * Spec resource for retrieving Inttegro platform specifications.
 *
 * Specifications provide details about supported countries, currencies, payment methods,
 * and other platform capabilities. Use specs to build dynamic forms, validate inputs,
 * and adapt your integration to different markets.
 *
 * @see https://studio.inttegro.com/specifications for spec guides
 */
class Spec
{
    private HttpClient $http;

    public function __construct(HttpClient $http)
    {
        $this->http = $http;
    }

    /**
     * Retrieve specifications for all supported countries.
     *
     * Returns detailed information about each country Inttegro operates in, including:
     * - Supported currencies and payment methods
     * - Available payout schedules
     * - Legal entity types for businesses
     * - Financial account types (mobile money issuers, bank requirements)
     * - Required ID document types for verification
     *
     * Use this to build country-specific onboarding flows, validate inputs based on
     * market capabilities, and display appropriate options to users.
     *
     * This is a public endpoint that does not require authentication.
     *
     * @return \Inttegro\ResponseObject Country specifications
     *
     * @example Get country specifications
     * ```php
     * $result = $client->spec->countries();
     *
     * $countries = $result->data['countries'];
     * foreach ($countries as $country) {
     *     echo "{$country['name']} ({$country['code']}):\n";
     *     echo "  Currencies: " . implode(', ', $country['currencies']) . "\n";
     *     echo "  Payment methods: " . implode(', ', $country['payment_methods']) . "\n";
     *
     *     if (isset($country['mobile_money_issuers'])) {
     *         echo "  Mobile money: " . implode(', ', $country['mobile_money_issuers']) . "\n";
     *     }
     * }
     * ```
     *
     * @see https://studio.inttegro.com/country-specifications for spec details
     */
    public function countries(): \Inttegro\ResponseObject
    {
        return $this->http->post('/spec/countries', []);
    }
}
