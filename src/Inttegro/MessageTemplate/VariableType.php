<?php

namespace Inttegro\MessageTemplate;

/**
 * Allowed wire values for message template variable type.
 *
 * Use enum cases in typed PHP code and `->value` when building a native
 * request array. Each case maps exactly to the documented API string.
 */
enum VariableType: string
{
    /**
     * Selects the `string` API value for message template variable type.
     *
     * Wire value: `string`.
     */
    case StringValue = 'string';

    /**
     * Selects the `number` API value for message template variable type.
     *
     * Wire value: `number`.
     */
    case Number = 'number';

    /**
     * Selects the `integer` API value for message template variable type.
     *
     * Wire value: `integer`.
     */
    case Integer = 'integer';

    /**
     * Selects the `boolean` API value for message template variable type.
     *
     * Wire value: `boolean`.
     */
    case Boolean = 'boolean';

    /**
     * Selects the `url` API value for message template variable type.
     *
     * Wire value: `url`.
     */
    case Url = 'url';

    /**
     * Selects the `email` API value for message template variable type.
     *
     * Wire value: `email`.
     */
    case Email = 'email';

    /**
     * Selects the `phone` API value for message template variable type.
     *
     * Wire value: `phone`.
     */
    case Phone = 'phone';

    /**
     * Selects the `date` API value for message template variable type.
     *
     * Wire value: `date`.
     */
    case Date = 'date';

    /**
     * Selects the `datetime` API value for message template variable type.
     *
     * Wire value: `datetime`.
     */
    case Datetime = 'datetime';

    /**
     * Selects the `array` API value for message template variable type.
     *
     * Wire value: `array`.
     */
    case ArrayValue = 'array';
}
