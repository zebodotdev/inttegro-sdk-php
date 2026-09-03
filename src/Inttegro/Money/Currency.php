<?php

namespace Inttegro\Money;

/** Currency codes accepted by Inttegro amount values. */
enum Currency: string
{
    case GHS = 'ghs';
    case USD = 'usd';
    case GBP = 'gbp';
    case EUR = 'eur';
    case CNY = 'cny';
}
