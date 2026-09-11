<?php

namespace Inttegro\Price;

use Inttegro\Money\AmountParams;

/**
 * A typed inline price supplied directly inside another request.
 *
 * This immutable value inherits its hydration and wire-serialization behavior from its typed parent
 * class.
 */
final class InlineParams extends AmountParams {}
