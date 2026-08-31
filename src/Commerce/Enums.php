<?php

namespace Commerce\Enums;

// Backed enums for every string enum published by the Inttegro API. Backed enum
// cases encode to their wire values when included in JSON request payloads.

enum AppManagementRole: string { case ParentApp = 'parent'; case Child = 'child'; }
enum AppCredentialOwner: string { case Child = 'child'; case ParentApp = 'parent'; }
enum AppRelationshipKind: string { case Placement = 'placement'; }
enum AppRelationshipStatus: string { case Active = 'active'; case Inactive = 'inactive'; case Suspended = 'suspended'; case Revoked = 'revoked'; }
enum SecretKeyTokenType: string { case Bearer = 'bearer'; }
enum SecretKeyStatus: string { case Active = 'active'; case Revoked = 'revoked'; case Expired = 'expired'; }
enum SecretKeyAuthResult: string { case Succeeded = 'succeeded'; case Failed = 'failed'; }

enum FileStatus: string { case Uploading = 'uploading'; case Processing = 'processing'; case Available = 'available'; case Failed = 'failed'; case Deleted = 'deleted'; }
enum FileDisposition: string { case Attachment = 'attachment'; case Inline = 'inline'; }
enum FileDelivery: string { case Stream = 'stream'; case Redirect = 'redirect'; }
enum FileScanStatus: string { case Pending = 'pending'; case Passed = 'passed'; case Failed = 'failed'; case Skipped = 'skipped'; }
enum FileSourceType: string { case Direct = 'direct'; case UploadRequest = 'upload_request'; case Service = 'service'; }
enum FileStorageEncoding: string { case Identity = 'identity'; case Brotli = 'br'; }
enum FileLinkStatus: string { case Active = 'active'; case Revoked = 'revoked'; case Expired = 'expired'; case Disabled = 'disabled'; }
enum FileLinkKind: string { case PublicLink = 'public'; }
enum FileLinkDeliveryMode: string { case Redirect = 'redirect'; case Download = 'download'; case Inline = 'inline'; }
enum UploadRequestStatus: string { case Pending = 'pending'; case Uploading = 'uploading'; case Fulfilled = 'fulfilled'; case Expired = 'expired'; case Canceled = 'canceled'; case Failed = 'failed'; }
enum UploadReviewDecision: string { case Approved = 'approved'; case Rejected = 'rejected'; }
enum UploadReviewType: string { case Automatic = 'automatic'; case Manual = 'manual'; }

enum PaymentNextActionType: string { case ConfirmPayment = 'confirm_payment'; case Execute = 'execute'; case Redirect = 'redirect'; case Authorize = 'authorize'; case None = 'none'; }
enum PaymentConfirmationChannel: string { case Sms = 'sms'; case Email = 'email'; case Push = 'push'; }
enum PaymentMethodType: string { case MobileMoney = 'mobile_money'; case BankAccount = 'bank_account'; case Card = 'card'; case Motito = 'motito'; }
enum MobileMoneyNetwork: string { case Airtel = 'airtel'; case Mtn = 'mtn'; case Telecel = 'telecel'; case Vodafone = 'vodafone'; }

enum ProductType: string { case Physical = 'physical'; case Digital = 'digital'; case Service = 'service'; case Voucher = 'voucher'; case Custom = 'custom'; case Cause = 'cause'; }
enum ProductShipmentType: string { case Delivery = 'delivery'; case Download = 'download'; case Render = 'render'; case Service = 'service'; case Stream = 'stream'; }
enum ProductShipmentInputType: string { case Delivery = 'delivery'; case Download = 'download'; case Render = 'render'; case Stream = 'stream'; }
enum LineItemType: string { case Product = 'product'; case Fee = 'fee'; case Shipping = 'shipping'; }
enum PurchaseIntentStatus: string { case Active = 'active'; case Expired = 'expired'; case Inactive = 'inactive'; case Used = 'used'; }
enum PurchaseIntentActivityType: string { case ExpiredViewed = 'expired_viewed'; case OrderCreated = 'order_created'; case PaymentFailed = 'payment_failed'; case PaymentStarted = 'payment_started'; case Viewed = 'viewed'; }

enum FinancialAccountType: string { case Wallet = 'wallet'; case BankAccount = 'bank_account'; case DoshAccount = 'dosh_account'; }
enum WalletType: string { case MobileMoney = 'mobile_money'; }
enum BankAccountType: string { case GhanaBankAccount = 'ghana_bank_account'; }

enum MessageTemplateChannel: string { case Sms = 'sms'; case Email = 'email'; }
enum MessageTemplateStatus: string { case Draft = 'draft'; case Published = 'published'; case Archived = 'archived'; }
enum MessageTemplateVariableType: string { case StringValue = 'string'; case Number = 'number'; case Integer = 'integer'; case Boolean = 'boolean'; case Url = 'url'; case Email = 'email'; case Phone = 'phone'; case Date = 'date'; case Datetime = 'datetime'; case ArrayValue = 'array'; }
enum MessageTemplateVariableItemType: string { case StringValue = 'string'; case Number = 'number'; case Integer = 'integer'; case Boolean = 'boolean'; case Url = 'url'; case Email = 'email'; case Phone = 'phone'; case Date = 'date'; case Datetime = 'datetime'; }
enum ContentSafetyStatus: string { case Allowed = 'allowed'; case Rejected = 'rejected'; case Quarantined = 'quarantined'; }

enum OrderDocumentKind: string { case Invoice = 'invoice'; case Receipt = 'receipt'; }
enum DeliveryChannel: string { case Email = 'email'; case Sms = 'sms'; }
enum CheckoutOrderStatus: string { case Preparing = 'preparing'; case RequiresPayment = 'requires_payment'; case Completed = 'completed'; case Canceled = 'canceled'; case Expired = 'expired'; }
enum OrderStatus: string { case Preparing = 'preparing'; case RequiresPayment = 'requires_payment'; case Paid = 'paid'; case Completed = 'completed'; case Canceled = 'canceled'; case Expired = 'expired'; case Unknown = 'unknown'; }
enum OrderPaymentStatus: string { case Initiated = 'initiated'; case RequiresAction = 'requires_action'; case Overdue = 'overdue'; case Executed = 'executed'; case Paid = 'paid'; case Canceled = 'canceled'; case Expired = 'expired'; case Failed = 'failed'; case Unknown = 'unknown'; }
enum PaymentAttemptStatus: string { case Initiated = 'initiated'; case Executed = 'executed'; case Succeeded = 'succeeded'; case Canceled = 'canceled'; case Expired = 'expired'; case Failed = 'failed'; case Unknown = 'unknown'; }
enum CheckoutPaymentStatus: string { case RequiresAction = 'requires_action'; case Processing = 'processing'; case Succeeded = 'succeeded'; case Failed = 'failed'; case Cancelled = 'cancelled'; }
enum PaymentResponseStatus: string { case Pending = 'pending'; case RequiresConfirmation = 'requires_confirmation'; case Processing = 'processing'; case Succeeded = 'succeeded'; case Failed = 'failed'; }
enum OrderCreatedFromResourceType: string { case PurchaseIntent = 'purchase_intent'; }

enum RefundReason: string { case RequestedByCustomer = 'requested_by_customer'; case Duplicate = 'duplicate'; case Fraudulent = 'fraudulent'; case OrderCanceled = 'order_canceled'; case ItemReturned = 'item_returned'; case ItemDamaged = 'item_damaged'; case ItemNotReceived = 'item_not_received'; case ItemNotAsDescribed = 'item_not_as_described'; case Custom = 'custom'; }
enum RefundStatus: string { case Canceled = 'canceled'; case Failed = 'failed'; case Pending = 'pending'; case Processing = 'processing'; case Succeeded = 'succeeded'; }
enum BalanceTransactionType: string { case Payment = 'payment'; case Refund = 'refund'; }
enum PayoutStatus: string { case Initialized = 'initialized'; case Scheduled = 'scheduled'; case Processing = 'processing'; case Executing = 'executing'; case Succeeded = 'succeeded'; case Invalid = 'invalid'; case Canceled = 'canceled'; }

enum ChimeRecipientType: string { case Phone = 'phone'; case Email = 'email'; }
enum ChimeTransport: string { case Sms = 'sms'; case Email = 'email'; }
enum ChimeEmailSchemaKind: string { case GmailViewAction = 'gmail_view_action'; case SchemaOrgOrder = 'schema_org_order'; case SchemaOrgInvoice = 'schema_org_invoice'; }

enum OTPAlphabetType: string { case Numeric = 'numeric'; case Alpha = 'alpha'; case Alphanumeric = 'alphanumeric'; }
enum OTPStatus: string { case Canceled = 'canceled'; case Expired = 'expired'; case Pending = 'pending'; case PendingDelivery = 'pending_delivery'; case PendingVerification = 'pending_verification'; case Verified = 'verified'; }
enum OTPTransmissionStatus: string { case Delivered = 'delivered'; case Failed = 'failed'; case Submitted = 'submitted'; }
enum OTPVerificationVerdict: string { case Fail = 'fail'; case Pass = 'pass'; }
