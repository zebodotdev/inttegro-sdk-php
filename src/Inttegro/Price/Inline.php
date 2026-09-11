<?php

namespace Inttegro\Price;

use Inttegro\Money\Amount;

/**
 * An inline amount returned where the API embeds a one-off price rather than a catalog price.
 *
 * This immutable value inherits its hydration and wire-serialization behavior from its typed parent
 * class.
 */
final class Inline extends Amount {}
