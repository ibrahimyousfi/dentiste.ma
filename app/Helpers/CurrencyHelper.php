<?php

if (!function_exists('format_currency')) {
    /**
     * Format an amount using the organization's preferred currency.
     *
     * @param float $amount
     * @return string
     */
    function format_currency($amount)
    {
        $currency = 'USD';
        
        if (auth()->check() && auth()->user()->organization) {
            $currency = auth()->user()->organization->currency ?? 'USD';
        }

        $symbols = [
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            'MAD' => 'MAD',
            'CAD' => 'CA$',
            'AUD' => 'A$',
            'AED' => 'AED',
            'SAR' => 'SAR',
        ];

        $symbol = $symbols[$currency] ?? $currency;

        // For MAD, AED, SAR etc, standard convention is often to put the symbol after the amount
        $suffixCurrencies = ['MAD', 'AED', 'SAR'];

        if (in_array($currency, $suffixCurrencies)) {
            return number_format($amount, 2) . ' ' . $symbol;
        }

        return $symbol . number_format($amount, 2);
    }
}
