<?php

namespace Inttegro\Chime;

/**
 * Classification for the generated markup.
 *
 * Use enum cases in typed PHP code and `->value` when building a native
 * request array. Each case maps exactly to the documented API string.
 */
enum EmailSchemaKind: string
{
    /**
     * Selects the `gmail_view_action` API value for chime email schema kind.
     *
     * Wire value: `gmail_view_action`.
     */
    case GmailViewAction = 'gmail_view_action';

    /**
     * Selects the `schema_org_order` API value for chime email schema kind.
     *
     * Wire value: `schema_org_order`.
     */
    case SchemaOrgOrder = 'schema_org_order';

    /**
     * Selects the `schema_org_invoice` API value for chime email schema kind.
     *
     * Wire value: `schema_org_invoice`.
     */
    case SchemaOrgInvoice = 'schema_org_invoice';
}
