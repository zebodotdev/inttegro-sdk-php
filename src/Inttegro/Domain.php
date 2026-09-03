<?php

namespace Inttegro;

use ArrayAccess;
use JsonSerializable;
use LogicException;

/** Immutable base for Inttegro domain values. */
abstract class DomainValue implements ArrayAccess, JsonSerializable
{
    /** @param array<string, mixed> $data */
    abstract public static function fromArray(array $data): static;

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        $result = [];
        foreach (get_object_vars($this) as $name => $value) {
            $result[self::snake($name)] = self::export($value);
        }
        return $result;
    }

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }

    public function __get(string $name): mixed
    {
        $camel = self::camel($name);
        return property_exists($this, $camel) ? $this->{$camel} : null;
    }

    public function __isset(string $name): bool
    {
        $camel = self::camel($name);
        return property_exists($this, $camel) && $this->{$camel} !== null;
    }

    public function offsetExists(mixed $offset): bool
    {
        return is_string($offset) && isset($this->{$offset});
    }

    public function offsetGet(mixed $offset): mixed
    {
        return is_string($offset) ? $this->{$offset} : null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        throw new LogicException('Inttegro domain values are immutable.');
    }

    public function offsetUnset(mixed $offset): void
    {
        throw new LogicException('Inttegro domain values are immutable.');
    }

    private static function camel(string $value): string
    {
        return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $value))));
    }

    private static function snake(string $value): string
    {
        return strtolower((string) preg_replace('/(?<!^)[A-Z]/', '_$0', $value));
    }

    private static function export(mixed $value): mixed
    {
        if ($value instanceof self) {
            return $value->toArray();
        }
        if (is_array($value)) {
            return array_map([self::class, 'export'], $value);
        }
        return $value;
    }
}

/** @internal */
final class ValueHydrator
{
    /** @return ($nullable is true ? string|null : string) */
    public static function string(mixed $value, bool $nullable): ?string
    {
        return $value === null && $nullable ? null : (string) ($value ?? '');
    }

    /** @return ($nullable is true ? int|null : int) */
    public static function int(mixed $value, bool $nullable): ?int
    {
        return $value === null && $nullable ? null : (int) ($value ?? 0);
    }

    /** @return ($nullable is true ? float|null : float) */
    public static function float(mixed $value, bool $nullable): ?float
    {
        return $value === null && $nullable ? null : (float) ($value ?? 0.0);
    }

    /** @return ($nullable is true ? bool|null : bool) */
    public static function bool(mixed $value, bool $nullable): ?bool
    {
        return $value === null && $nullable ? null : (bool) ($value ?? false);
    }

    /** @return ($nullable is true ? array<mixed>|null : array<mixed>) */
    public static function array(mixed $value, bool $nullable): ?array
    {
        return $value === null && $nullable ? null : (is_array($value) ? $value : []);
    }

    /**
     * @template T of DomainValue
     * @param non-empty-list<class-string<T>> $classes
     * @return ($nullable is true ? T|null : T)
     */
    public static function object(mixed $value, array $classes, bool $nullable): ?DomainValue
    {
        if ($value === null && $nullable) {
            return null;
        }
        $data = is_array($value) ? $value : [];
        $class = self::classFor($data, $classes);
        return $class::fromArray($data);
    }

    /**
     * @template T of DomainValue
     * @param non-empty-list<class-string<T>> $classes
     * @return list<T>
     */
    public static function objects(mixed $value, array $classes): array
    {
        if (!is_array($value)) {
            return [];
        }
        return array_map(
            static fn(mixed $item): DomainValue => self::object(is_array($item) ? $item : [], $classes, false),
            array_values($value),
        );
    }

    /**
     * @template T of DomainValue
     * @param non-empty-list<class-string<T>> $classes
     * @return array<string, T>
     */
    public static function objectMap(mixed $value, array $classes): array
    {
        if (!is_array($value)) {
            return [];
        }
        return array_map(
            static fn(mixed $item): DomainValue => self::object(is_array($item) ? $item : [], $classes, false),
            $value,
        );
    }

    /**
     * @param array<string, mixed> $data
     * @param list<class-string<DomainValue>> $classes
     * @return class-string<DomainValue>
     */
    private static function classFor(array $data, array $classes): string
    {
        $kind = strtolower((string) ($data['type'] ?? ''));
        if ($kind !== '') {
            foreach ($classes as $class) {
                $short = strtolower((new \ReflectionClass($class))->getShortName());
                if (str_contains($short, str_replace('_', '', $kind))) {
                    return $class;
                }
            }
        }
        return $classes[0] ?? GenericValue::class;
    }
}

/** Domain value used only where the API schema intentionally permits arbitrary object data. */
final class GenericValue extends DomainValue
{
    /** @param array<string, mixed> $data */
    public function __construct(private readonly array $data) {}

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return $this->data;
    }

    public function __get(string $name): mixed
    {
        return $this->data[$name] ?? null;
    }

    public function __isset(string $name): bool
    {
        return isset($this->data[$name]);
    }
}

final class Application extends DomainValue
{
    public readonly string $id;
    public readonly string $name;
    public readonly ?string $alias;
    public readonly ?string $description;
    public readonly string $createdAt;
    public readonly ?string $updatedAt;
    public readonly ?string $archivedAt;
    public readonly ?ApplicationSecretKey $secretKey;
    public readonly ?ApplicationRelationship $relationship;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->id = ValueHydrator::string($data['id'] ?? null, false);
        $this->name = ValueHydrator::string($data['name'] ?? null, false);
        $this->alias = ValueHydrator::string($data['alias'] ?? null, true);
        $this->description = ValueHydrator::string($data['description'] ?? null, true);
        $this->createdAt = ValueHydrator::string($data['created_at'] ?? null, false);
        $this->updatedAt = ValueHydrator::string($data['updated_at'] ?? null, true);
        $this->archivedAt = ValueHydrator::string($data['archived_at'] ?? null, true);
        $this->secretKey = ValueHydrator::object($data['secret_key'] ?? null, [ApplicationSecretKey::class], true);
        $this->relationship = ValueHydrator::object($data['relationship'] ?? null, [ApplicationRelationship::class], true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class ApplicationRelationship extends DomainValue
{
    public readonly string $id;
    public readonly string $kind;
    public readonly string $policyVersion;
    public readonly string $status;
    public readonly string $actorAppId;
    public readonly string $creatorAppId;
    public readonly string $placementParentAppId;
    public readonly string $subjectAppId;
    public readonly string $childAppId;
    public readonly string $childStanding;
    public readonly ApplicationRelationshipPolicy $relationshipPolicy;
    public readonly bool $retainedCreatorAuthorityExists;
    public readonly string $createdAt;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->id = ValueHydrator::string($data['id'] ?? null, false);
        $this->kind = ValueHydrator::string($data['kind'] ?? null, false);
        $this->policyVersion = ValueHydrator::string($data['policy_version'] ?? null, false);
        $this->status = ValueHydrator::string($data['status'] ?? null, false);
        $this->actorAppId = ValueHydrator::string($data['actor_app_id'] ?? null, false);
        $this->creatorAppId = ValueHydrator::string($data['creator_app_id'] ?? null, false);
        $this->placementParentAppId = ValueHydrator::string($data['placement_parent_app_id'] ?? null, false);
        $this->subjectAppId = ValueHydrator::string($data['subject_app_id'] ?? null, false);
        $this->childAppId = ValueHydrator::string($data['child_app_id'] ?? null, false);
        $this->childStanding = ValueHydrator::string($data['child_standing'] ?? null, false);
        $this->relationshipPolicy = ValueHydrator::object($data['relationship_policy'] ?? null, [ApplicationRelationshipPolicy::class], false);
        $this->retainedCreatorAuthorityExists = ValueHydrator::bool($data['retained_creator_authority_exists'] ?? null, false);
        $this->createdAt = ValueHydrator::string($data['created_at'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class ApplicationRelationshipPolicy extends DomainValue
{
    public readonly string $childStanding;
    public readonly string $management;
    public readonly string $credentials;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->childStanding = ValueHydrator::string($data['child_standing'] ?? null, false);
        $this->management = ValueHydrator::string($data['management'] ?? null, false);
        $this->credentials = ValueHydrator::string($data['credentials'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class ApplicationSecretKey extends DomainValue
{
    public readonly ?string $id;
    public readonly ?string $tokenType;
    public readonly ?string $issuedAt;
    public readonly ?string $token;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->id = ValueHydrator::string($data['id'] ?? null, true);
        $this->tokenType = ValueHydrator::string($data['token_type'] ?? null, true);
        $this->issuedAt = ValueHydrator::string($data['issued_at'] ?? null, true);
        $this->token = ValueHydrator::string($data['token'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class BalanceTransaction extends DomainValue
{
    public readonly BalanceTransactionAmount $amount;
    public readonly ?string $availableAt;
    public readonly ?string $claimedAt;
    public readonly string $createdAt;
    public readonly string $id;
    public readonly string $orderId;
    public readonly ?string $paidAt;
    public readonly ?string $paymentId;
    public readonly ?string $payoutId;
    public readonly ?string $refundId;
    public readonly string $type;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->amount = ValueHydrator::object($data['amount'] ?? null, [BalanceTransactionAmount::class], false);
        $this->availableAt = ValueHydrator::string($data['available_at'] ?? null, true);
        $this->claimedAt = ValueHydrator::string($data['claimed_at'] ?? null, true);
        $this->createdAt = ValueHydrator::string($data['created_at'] ?? null, false);
        $this->id = ValueHydrator::string($data['id'] ?? null, false);
        $this->orderId = ValueHydrator::string($data['order_id'] ?? null, false);
        $this->paidAt = ValueHydrator::string($data['paid_at'] ?? null, true);
        $this->paymentId = ValueHydrator::string($data['payment_id'] ?? null, true);
        $this->payoutId = ValueHydrator::string($data['payout_id'] ?? null, true);
        $this->refundId = ValueHydrator::string($data['refund_id'] ?? null, true);
        $this->type = ValueHydrator::string($data['type'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class BalanceTransactionAmount extends DomainValue
{
    public readonly string $currency;
    public readonly int $value;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->currency = ValueHydrator::string($data['currency'] ?? null, false);
        $this->value = ValueHydrator::int($data['value'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class BalanceTransactionPage extends DomainValue
{
    public readonly int $number;
    public readonly int $size;
    /** @var list<BalanceTransaction>|null */
    public readonly ?array $transactions;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->number = ValueHydrator::int($data['number'] ?? null, false);
        $this->size = ValueHydrator::int($data['size'] ?? null, false);
        $this->transactions = ValueHydrator::objects($data['transactions'] ?? null, [BalanceTransaction::class]);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class BalanceValue extends DomainValue
{
    public readonly int $amount;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->amount = ValueHydrator::int($data['amount'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class BroadcastCancelDetail extends DomainValue
{
    /** @var list<string>|null */
    public readonly ?array $chimeIds;
    public readonly string $content;
    public readonly string $createdAt;
    /** @var list<string>|null */
    public readonly ?array $customerIds;
    public readonly ?ChimeEmailMessage $email;
    /** @var list<BroadcastError>|null */
    public readonly ?array $errors;
    public readonly ?string $executedAt;
    public readonly string $id;
    public readonly ?string $idempotencyKey;
    public readonly ?string $purpose;
    /** @var list<string> */
    public readonly array $recipients;
    public readonly string $sendAfter;
    public readonly string $senderId;
    public readonly ?string $canceledAt;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->chimeIds = ValueHydrator::array($data['chime_ids'] ?? null, true);
        $this->content = ValueHydrator::string($data['content'] ?? null, false);
        $this->createdAt = ValueHydrator::string($data['created_at'] ?? null, false);
        $this->customerIds = ValueHydrator::array($data['customer_ids'] ?? null, true);
        $this->email = ValueHydrator::object($data['email'] ?? null, [ChimeEmailMessage::class], true);
        $this->errors = ValueHydrator::objects($data['errors'] ?? null, [BroadcastError::class]);
        $this->executedAt = ValueHydrator::string($data['executed_at'] ?? null, true);
        $this->id = ValueHydrator::string($data['id'] ?? null, false);
        $this->idempotencyKey = ValueHydrator::string($data['idempotency_key'] ?? null, true);
        $this->purpose = ValueHydrator::string($data['purpose'] ?? null, true);
        $this->recipients = ValueHydrator::array($data['recipients'] ?? null, false);
        $this->sendAfter = ValueHydrator::string($data['send_after'] ?? null, false);
        $this->senderId = ValueHydrator::string($data['sender_id'] ?? null, false);
        $this->canceledAt = ValueHydrator::string($data['canceled_at'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class BroadcastCreationDetail extends DomainValue
{
    public readonly string $content;
    public readonly string $createdAt;
    /** @var list<string>|null */
    public readonly ?array $customerIds;
    public readonly ?ChimeEmailMessage $email;
    public readonly string $id;
    public readonly ?string $idempotencyKey;
    public readonly ?string $purpose;
    /** @var list<string> */
    public readonly array $recipients;
    public readonly string $sendAfter;
    public readonly string $senderId;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->content = ValueHydrator::string($data['content'] ?? null, false);
        $this->createdAt = ValueHydrator::string($data['created_at'] ?? null, false);
        $this->customerIds = ValueHydrator::array($data['customer_ids'] ?? null, true);
        $this->email = ValueHydrator::object($data['email'] ?? null, [ChimeEmailMessage::class], true);
        $this->id = ValueHydrator::string($data['id'] ?? null, false);
        $this->idempotencyKey = ValueHydrator::string($data['idempotency_key'] ?? null, true);
        $this->purpose = ValueHydrator::string($data['purpose'] ?? null, true);
        $this->recipients = ValueHydrator::array($data['recipients'] ?? null, false);
        $this->sendAfter = ValueHydrator::string($data['send_after'] ?? null, false);
        $this->senderId = ValueHydrator::string($data['sender_id'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class BroadcastDetail extends DomainValue
{
    /** @var list<string>|null */
    public readonly ?array $chimeIds;
    public readonly string $content;
    public readonly string $createdAt;
    /** @var list<string>|null */
    public readonly ?array $customerIds;
    public readonly ?ChimeEmailMessage $email;
    /** @var list<BroadcastError>|null */
    public readonly ?array $errors;
    public readonly ?string $executedAt;
    public readonly string $id;
    public readonly ?string $idempotencyKey;
    public readonly ?string $purpose;
    /** @var list<string> */
    public readonly array $recipients;
    public readonly string $sendAfter;
    public readonly string $senderId;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->chimeIds = ValueHydrator::array($data['chime_ids'] ?? null, true);
        $this->content = ValueHydrator::string($data['content'] ?? null, false);
        $this->createdAt = ValueHydrator::string($data['created_at'] ?? null, false);
        $this->customerIds = ValueHydrator::array($data['customer_ids'] ?? null, true);
        $this->email = ValueHydrator::object($data['email'] ?? null, [ChimeEmailMessage::class], true);
        $this->errors = ValueHydrator::objects($data['errors'] ?? null, [BroadcastError::class]);
        $this->executedAt = ValueHydrator::string($data['executed_at'] ?? null, true);
        $this->id = ValueHydrator::string($data['id'] ?? null, false);
        $this->idempotencyKey = ValueHydrator::string($data['idempotency_key'] ?? null, true);
        $this->purpose = ValueHydrator::string($data['purpose'] ?? null, true);
        $this->recipients = ValueHydrator::array($data['recipients'] ?? null, false);
        $this->sendAfter = ValueHydrator::string($data['send_after'] ?? null, false);
        $this->senderId = ValueHydrator::string($data['sender_id'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class BroadcastError extends DomainValue
{
    public readonly ?string $recipient;
    public readonly ?string $fixCode;
    public readonly ?string $type;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->recipient = ValueHydrator::string($data['recipient'] ?? null, true);
        $this->fixCode = ValueHydrator::string($data['fix_code'] ?? null, true);
        $this->type = ValueHydrator::string($data['type'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class Chime extends DomainValue
{
    public readonly string $createdAt;
    /** @var array<string, string>|null */
    public readonly ?array $customData;
    public readonly ?string $customerId;
    public readonly ?ChimeEmailMessage $email;
    public readonly string $fullMessage;
    public readonly string $id;
    public readonly ?string $idempotencyKey;
    public readonly ?string $purpose;
    public readonly ChimeRecipient $recipient;
    public readonly string $senderId;
    public readonly ?ChimeTransmission $transmission;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->createdAt = ValueHydrator::string($data['created_at'] ?? null, false);
        $this->customData = ValueHydrator::array($data['custom_data'] ?? null, true);
        $this->customerId = ValueHydrator::string($data['customer_id'] ?? null, true);
        $this->email = ValueHydrator::object($data['email'] ?? null, [ChimeEmailMessage::class], true);
        $this->fullMessage = ValueHydrator::string($data['full_message'] ?? null, false);
        $this->id = ValueHydrator::string($data['id'] ?? null, false);
        $this->idempotencyKey = ValueHydrator::string($data['idempotency_key'] ?? null, true);
        $this->purpose = ValueHydrator::string($data['purpose'] ?? null, true);
        $this->recipient = ValueHydrator::object($data['recipient'] ?? null, [ChimeRecipient::class], false);
        $this->senderId = ValueHydrator::string($data['sender_id'] ?? null, false);
        $this->transmission = ValueHydrator::object($data['transmission'] ?? null, [ChimeTransmission::class], true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class ChimeEmailEvent extends DomainValue
{
    public readonly ?string $bounceSubType;
    public readonly ?string $bounceType;
    public readonly ?string $complaintSubType;
    public readonly string $id;
    public readonly string $occurredAt;
    public readonly string $provider;
    public readonly string $providerMessageId;
    public readonly ?string $reason;
    public readonly ?string $reasonCode;
    public readonly ?string $recipient;
    public readonly ?string $source;
    public readonly ?bool $suppressRecipient;
    public readonly ?bool $temporary;
    public readonly string $type;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->bounceSubType = ValueHydrator::string($data['bounce_sub_type'] ?? null, true);
        $this->bounceType = ValueHydrator::string($data['bounce_type'] ?? null, true);
        $this->complaintSubType = ValueHydrator::string($data['complaint_sub_type'] ?? null, true);
        $this->id = ValueHydrator::string($data['id'] ?? null, false);
        $this->occurredAt = ValueHydrator::string($data['occurred_at'] ?? null, false);
        $this->provider = ValueHydrator::string($data['provider'] ?? null, false);
        $this->providerMessageId = ValueHydrator::string($data['provider_message_id'] ?? null, false);
        $this->reason = ValueHydrator::string($data['reason'] ?? null, true);
        $this->reasonCode = ValueHydrator::string($data['reason_code'] ?? null, true);
        $this->recipient = ValueHydrator::string($data['recipient'] ?? null, true);
        $this->source = ValueHydrator::string($data['source'] ?? null, true);
        $this->suppressRecipient = ValueHydrator::bool($data['suppress_recipient'] ?? null, true);
        $this->temporary = ValueHydrator::bool($data['temporary'] ?? null, true);
        $this->type = ValueHydrator::string($data['type'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class ChimeEmailMailbox extends DomainValue
{
    public readonly ?string $name;
    public readonly ?string $address;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->name = ValueHydrator::string($data['name'] ?? null, true);
        $this->address = ValueHydrator::string($data['address'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class ChimeEmailMessage extends DomainValue
{
    public readonly ?string $subject;
    public readonly ?string $text;
    public readonly ?string $html;
    public readonly ?ChimeEmailMailbox $from;
    public readonly ?ChimeEmailMailbox $replyTo;
    /** @var array<string, string>|null */
    public readonly ?array $headers;
    public readonly ?ChimeEmailSafetyResult $safety;
    public readonly ?ChimeEmailSchemaMarkup $schema;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->subject = ValueHydrator::string($data['subject'] ?? null, true);
        $this->text = ValueHydrator::string($data['text'] ?? null, true);
        $this->html = ValueHydrator::string($data['html'] ?? null, true);
        $this->from = ValueHydrator::object($data['from_'] ?? null, [ChimeEmailMailbox::class], true);
        $this->replyTo = ValueHydrator::object($data['reply_to'] ?? null, [ChimeEmailMailbox::class], true);
        $this->headers = ValueHydrator::array($data['headers'] ?? null, true);
        $this->safety = ValueHydrator::object($data['safety'] ?? null, [ChimeEmailSafetyResult::class], true);
        $this->schema = ValueHydrator::object($data['schema'] ?? null, [ChimeEmailSchemaMarkup::class], true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class ChimeEmailSafetyResult extends DomainValue
{
    public readonly ?string $status;
    /** @var list<string>|null */
    public readonly ?array $reasonCodes;
    public readonly ?string $sanitizedHtml;
    public readonly ?string $normalizedText;
    /** @var list<ChimeEmailScannedLink>|null */
    public readonly ?array $links;
    public readonly ?string $scanner;
    public readonly ?string $contentHash;
    public readonly ?string $quarantineNotes;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->status = ValueHydrator::string($data['status'] ?? null, true);
        $this->reasonCodes = ValueHydrator::array($data['reason_codes'] ?? null, true);
        $this->sanitizedHtml = ValueHydrator::string($data['sanitized_html'] ?? null, true);
        $this->normalizedText = ValueHydrator::string($data['normalized_text'] ?? null, true);
        $this->links = ValueHydrator::objects($data['links'] ?? null, [ChimeEmailScannedLink::class]);
        $this->scanner = ValueHydrator::string($data['scanner'] ?? null, true);
        $this->contentHash = ValueHydrator::string($data['content_hash'] ?? null, true);
        $this->quarantineNotes = ValueHydrator::string($data['quarantine_notes'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class ChimeEmailScannedLink extends DomainValue
{
    public readonly ?string $raw;
    public readonly ?string $scheme;
    public readonly ?string $host;
    public readonly ?string $status;
    public readonly ?string $reason;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->raw = ValueHydrator::string($data['raw'] ?? null, true);
        $this->scheme = ValueHydrator::string($data['scheme'] ?? null, true);
        $this->host = ValueHydrator::string($data['host'] ?? null, true);
        $this->status = ValueHydrator::string($data['status'] ?? null, true);
        $this->reason = ValueHydrator::string($data['reason'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class ChimeEmailSchemaMarkup extends DomainValue
{
    public readonly ?string $kind;
    /** @var array<string, mixed>|null */
    public readonly ?array $jsonLd;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->kind = ValueHydrator::string($data['kind'] ?? null, true);
        $this->jsonLd = ValueHydrator::array($data['json_ld'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class ChimePage extends DomainValue
{
    public readonly int $number;
    public readonly int $size;
    /** @var list<Chime> */
    public readonly array $chimes;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->number = ValueHydrator::int($data['number'] ?? null, false);
        $this->size = ValueHydrator::int($data['size'] ?? null, false);
        $this->chimes = ValueHydrator::objects($data['chimes'] ?? null, [Chime::class]);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class ChimeRecipient extends DomainValue
{
    public readonly string $type;
    public readonly ?string $name;
    public readonly ?ChimeRecipientPhone $phone;
    public readonly ?ChimeRecipientEmail $email;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->type = ValueHydrator::string($data['type'] ?? null, false);
        $this->name = ValueHydrator::string($data['name'] ?? null, true);
        $this->phone = ValueHydrator::object($data['phone'] ?? null, [ChimeRecipientPhone::class], true);
        $this->email = ValueHydrator::object($data['email'] ?? null, [ChimeRecipientEmail::class], true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class ChimeRecipientEmail extends DomainValue
{
    public readonly string $address;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->address = ValueHydrator::string($data['address'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class ChimeRecipientPhone extends DomainValue
{
    public readonly string $number;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->number = ValueHydrator::string($data['number'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class ChimeTransmission extends DomainValue
{
    public readonly string $address;
    public readonly string $createdAt;
    public readonly ?string $deliveredAt;
    /** @var list<ChimeEmailEvent>|null */
    public readonly ?array $emailEvents;
    public readonly ?string $emailFailureCode;
    public readonly ?string $emailFailureReason;
    public readonly ?string $emailStatus;
    public readonly ?string $error;
    public readonly ?string $failedAt;
    public readonly string $gateway;
    public readonly ?string $gatewayMessageId;
    public readonly string $id;
    public readonly string $initializedAt;
    public readonly ?string $lastEmailEventAt;
    public readonly string $mechanism;
    public readonly ?string $sentAt;
    public readonly ?string $sentVia;
    public readonly string $status;
    public readonly ?string $suppressedAt;
    public readonly ?string $suppressionReason;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->address = ValueHydrator::string($data['address'] ?? null, false);
        $this->createdAt = ValueHydrator::string($data['created_at'] ?? null, false);
        $this->deliveredAt = ValueHydrator::string($data['delivered_at'] ?? null, true);
        $this->emailEvents = ValueHydrator::objects($data['email_events'] ?? null, [ChimeEmailEvent::class]);
        $this->emailFailureCode = ValueHydrator::string($data['email_failure_code'] ?? null, true);
        $this->emailFailureReason = ValueHydrator::string($data['email_failure_reason'] ?? null, true);
        $this->emailStatus = ValueHydrator::string($data['email_status'] ?? null, true);
        $this->error = ValueHydrator::string($data['error'] ?? null, true);
        $this->failedAt = ValueHydrator::string($data['failed_at'] ?? null, true);
        $this->gateway = ValueHydrator::string($data['gateway'] ?? null, false);
        $this->gatewayMessageId = ValueHydrator::string($data['gateway_message_id'] ?? null, true);
        $this->id = ValueHydrator::string($data['id'] ?? null, false);
        $this->initializedAt = ValueHydrator::string($data['initialized_at'] ?? null, false);
        $this->lastEmailEventAt = ValueHydrator::string($data['last_email_event_at'] ?? null, true);
        $this->mechanism = ValueHydrator::string($data['mechanism'] ?? null, false);
        $this->sentAt = ValueHydrator::string($data['sent_at'] ?? null, true);
        $this->sentVia = ValueHydrator::string($data['sent_via'] ?? null, true);
        $this->status = ValueHydrator::string($data['status'] ?? null, false);
        $this->suppressedAt = ValueHydrator::string($data['suppressed_at'] ?? null, true);
        $this->suppressionReason = ValueHydrator::string($data['suppression_reason'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class CountryBank extends DomainValue
{
    public readonly string $id;
    public readonly string $name;
    public readonly ?string $swiftCode;
    public readonly ?string $sortCodePrefix;
    /** @var list<CountryBankBranch> */
    public readonly array $branches;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->id = ValueHydrator::string($data['id'] ?? null, false);
        $this->name = ValueHydrator::string($data['name'] ?? null, false);
        $this->swiftCode = ValueHydrator::string($data['swift_code'] ?? null, true);
        $this->sortCodePrefix = ValueHydrator::string($data['sort_code_prefix'] ?? null, true);
        $this->branches = ValueHydrator::objects($data['branches'] ?? null, [CountryBankBranch::class]);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class CountryBankBranch extends DomainValue
{
    public readonly string $id;
    public readonly string $name;
    public readonly string $sortCode;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->id = ValueHydrator::string($data['id'] ?? null, false);
        $this->name = ValueHydrator::string($data['name'] ?? null, false);
        $this->sortCode = ValueHydrator::string($data['sort_code'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class CountryBankDirectory extends DomainValue
{
    public readonly string $bankAccountType;
    public readonly string $codeScheme;
    /** @var list<CountryBank> */
    public readonly array $items;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->bankAccountType = ValueHydrator::string($data['bank_account_type'] ?? null, false);
        $this->codeScheme = ValueHydrator::string($data['code_scheme'] ?? null, false);
        $this->items = ValueHydrator::objects($data['items'] ?? null, [CountryBank::class]);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class CountrySpecification extends DomainValue
{
    public readonly string $countryCode;
    public readonly string $countryName;
    /** @var list<string> */
    public readonly array $currencies;
    /** @var list<string> */
    public readonly array $paymentMethods;
    /** @var list<string> */
    public readonly array $payoutSchedules;
    /** @var list<string> */
    public readonly array $btAgingSpecs;
    /** @var list<string> */
    public readonly array $legalEntityTypes;
    /** @var list<string> */
    public readonly array $financialAccountTypes;
    /** @var list<string> */
    public readonly array $idDocumentTypes;
    public readonly ?CountryBankDirectory $banks;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->countryCode = ValueHydrator::string($data['country_code'] ?? null, false);
        $this->countryName = ValueHydrator::string($data['country_name'] ?? null, false);
        $this->currencies = ValueHydrator::array($data['currencies'] ?? null, false);
        $this->paymentMethods = ValueHydrator::array($data['payment_methods'] ?? null, false);
        $this->payoutSchedules = ValueHydrator::array($data['payout_schedules'] ?? null, false);
        $this->btAgingSpecs = ValueHydrator::array($data['bt_aging_specs'] ?? null, false);
        $this->legalEntityTypes = ValueHydrator::array($data['legal_entity_types'] ?? null, false);
        $this->financialAccountTypes = ValueHydrator::array($data['financial_account_types'] ?? null, false);
        $this->idDocumentTypes = ValueHydrator::array($data['id_document_types'] ?? null, false);
        $this->banks = ValueHydrator::object($data['banks'] ?? null, [CountryBankDirectory::class], true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class CurrencyBalanceSnapshot extends DomainValue
{
    public readonly BalanceValue $available;
    public readonly string $includesTransactionsBefore;
    public readonly BalanceValue $pending;
    public readonly CurrencyBalanceSnapshotRefund $refund;
    public readonly CurrencyBalanceSnapshotReserved $reserved;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->available = ValueHydrator::object($data['available'] ?? null, [BalanceValue::class], false);
        $this->includesTransactionsBefore = ValueHydrator::string($data['includes_transactions_before'] ?? null, false);
        $this->pending = ValueHydrator::object($data['pending'] ?? null, [BalanceValue::class], false);
        $this->refund = ValueHydrator::object($data['refund'] ?? null, [CurrencyBalanceSnapshotRefund::class], false);
        $this->reserved = ValueHydrator::object($data['reserved'] ?? null, [CurrencyBalanceSnapshotReserved::class], false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class CurrencyBalanceSnapshotRefund extends DomainValue
{
    public readonly int $amount;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->amount = ValueHydrator::int($data['amount'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class CurrencyBalanceSnapshotReserved extends DomainValue
{
    public readonly int $amount;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->amount = ValueHydrator::int($data['amount'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class Customer extends DomainValue
{
    /** @var array<string, CustomerBalanceValue> */
    public readonly array $balance;
    public readonly ?CustomerAddress $billingAddress;
    public readonly string $createdAt;
    /** @var array<string, string>|null */
    public readonly ?array $customData;
    public readonly ?string $emailAddress;
    public readonly bool $guest;
    public readonly string $id;
    public readonly string $name;
    public readonly ?string $phoneNumber;
    public readonly ?string $reference;
    public readonly ?CustomerAddress $shippingAddress;
    public readonly ?string $suffix;
    public readonly ?string $title;
    public readonly ?string $updatedAt;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->balance = ValueHydrator::objectMap($data['balance'] ?? null, [CustomerBalanceValue::class]);
        $this->billingAddress = ValueHydrator::object($data['billing_address'] ?? null, [CustomerAddress::class], true);
        $this->createdAt = ValueHydrator::string($data['created_at'] ?? null, false);
        $this->customData = ValueHydrator::array($data['custom_data'] ?? null, true);
        $this->emailAddress = ValueHydrator::string($data['email_address'] ?? null, true);
        $this->guest = ValueHydrator::bool($data['guest'] ?? null, false);
        $this->id = ValueHydrator::string($data['id'] ?? null, false);
        $this->name = ValueHydrator::string($data['name'] ?? null, false);
        $this->phoneNumber = ValueHydrator::string($data['phone_number'] ?? null, true);
        $this->reference = ValueHydrator::string($data['reference'] ?? null, true);
        $this->shippingAddress = ValueHydrator::object($data['shipping_address'] ?? null, [CustomerAddress::class], true);
        $this->suffix = ValueHydrator::string($data['suffix'] ?? null, true);
        $this->title = ValueHydrator::string($data['title'] ?? null, true);
        $this->updatedAt = ValueHydrator::string($data['updated_at'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class CustomerAddress extends DomainValue
{
    public readonly ?string $city;
    public readonly string $country;
    public readonly ?string $line1;
    public readonly ?string $line2;
    public readonly ?string $name;
    public readonly ?string $phoneNumber;
    public readonly ?string $postCode;
    public readonly ?string $region;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->city = ValueHydrator::string($data['city'] ?? null, true);
        $this->country = ValueHydrator::string($data['country'] ?? null, false);
        $this->line1 = ValueHydrator::string($data['line1'] ?? null, true);
        $this->line2 = ValueHydrator::string($data['line2'] ?? null, true);
        $this->name = ValueHydrator::string($data['name'] ?? null, true);
        $this->phoneNumber = ValueHydrator::string($data['phone_number'] ?? null, true);
        $this->postCode = ValueHydrator::string($data['post_code'] ?? null, true);
        $this->region = ValueHydrator::string($data['region'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class CustomerBalanceValue extends DomainValue
{
    public readonly string $asOf;
    public readonly Money $available;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->asOf = ValueHydrator::string($data['as_of'] ?? null, false);
        $this->available = ValueHydrator::object($data['available'] ?? null, [Money::class], false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class CustomerPage extends DomainValue
{
    /** @var list<Customer> */
    public readonly array $customers;
    public readonly int $number;
    public readonly int $size;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->customers = ValueHydrator::objects($data['customers'] ?? null, [Customer::class]);
        $this->number = ValueHydrator::int($data['number'] ?? null, false);
        $this->size = ValueHydrator::int($data['size'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class Error extends DomainValue
{
    public readonly ?string $message;
    public readonly ?string $fixCode;
    public readonly ?string $detail;
    public readonly ?string $cause;
    public readonly string $type;
    public readonly string $code;
    public readonly string $url;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->message = ValueHydrator::string($data['message'] ?? null, true);
        $this->fixCode = ValueHydrator::string($data['fix_code'] ?? null, true);
        $this->detail = ValueHydrator::string($data['detail'] ?? null, true);
        $this->cause = ValueHydrator::string($data['cause'] ?? null, true);
        $this->type = ValueHydrator::string($data['type'] ?? null, false);
        $this->code = ValueHydrator::string($data['code'] ?? null, false);
        $this->url = ValueHydrator::string($data['url'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class File extends DomainValue
{
    public readonly string $id;
    public readonly string $purpose;
    public readonly string $status;
    public readonly string $scanStatus;
    public readonly ?string $name;
    public readonly ?string $filename;
    public readonly string $contentType;
    public readonly int $size;
    public readonly string $checksumSha256;
    public readonly FileActor $createdBy;
    public readonly FileSource $source;
    public readonly ?FileMedia $media;
    public readonly PublicFileStorage $storage;
    public readonly ?FileDeliveryDetails $delivery;
    public readonly ?FileLatestError $latestError;
    /** @var array<string, string>|null */
    public readonly ?array $customData;
    /** @var array<string, string>|null */
    public readonly ?array $metadata;
    public readonly string $createdAt;
    public readonly string $updatedAt;
    public readonly ?string $availableAt;
    public readonly ?string $expiresAt;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->id = ValueHydrator::string($data['id'] ?? null, false);
        $this->purpose = ValueHydrator::string($data['purpose'] ?? null, false);
        $this->status = ValueHydrator::string($data['status'] ?? null, false);
        $this->scanStatus = ValueHydrator::string($data['scan_status'] ?? null, false);
        $this->name = ValueHydrator::string($data['name'] ?? null, true);
        $this->filename = ValueHydrator::string($data['filename'] ?? null, true);
        $this->contentType = ValueHydrator::string($data['content_type'] ?? null, false);
        $this->size = ValueHydrator::int($data['size'] ?? null, false);
        $this->checksumSha256 = ValueHydrator::string($data['checksum_sha256'] ?? null, false);
        $this->createdBy = ValueHydrator::object($data['created_by'] ?? null, [FileActor::class], false);
        $this->source = ValueHydrator::object($data['source'] ?? null, [FileSource::class], false);
        $this->media = ValueHydrator::object($data['media'] ?? null, [FileMedia::class], true);
        $this->storage = ValueHydrator::object($data['storage'] ?? null, [PublicFileStorage::class], false);
        $this->delivery = ValueHydrator::object($data['delivery'] ?? null, [FileDeliveryDetails::class], true);
        $this->latestError = ValueHydrator::object($data['latest_error'] ?? null, [FileLatestError::class], true);
        $this->customData = ValueHydrator::array($data['custom_data'] ?? null, true);
        $this->metadata = ValueHydrator::array($data['metadata'] ?? null, true);
        $this->createdAt = ValueHydrator::string($data['created_at'] ?? null, false);
        $this->updatedAt = ValueHydrator::string($data['updated_at'] ?? null, false);
        $this->availableAt = ValueHydrator::string($data['available_at'] ?? null, true);
        $this->expiresAt = ValueHydrator::string($data['expires_at'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class FileActor extends DomainValue
{
    public readonly string $type;
    public readonly ?string $id;
    public readonly ?string $name;
    public readonly ?string $email;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->type = ValueHydrator::string($data['type'] ?? null, false);
        $this->id = ValueHydrator::string($data['id'] ?? null, true);
        $this->name = ValueHydrator::string($data['name'] ?? null, true);
        $this->email = ValueHydrator::string($data['email'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class FileDeliveryDetails extends DomainValue
{
    public readonly ?string $publicUrl;
    public readonly ?string $cacheControl;
    public readonly ?string $contentType;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->publicUrl = ValueHydrator::string($data['public_url'] ?? null, true);
        $this->cacheControl = ValueHydrator::string($data['cache_control'] ?? null, true);
        $this->contentType = ValueHydrator::string($data['content_type'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class FileLatestError extends DomainValue
{
    public readonly ?string $code;
    public readonly ?string $message;
    public readonly ?bool $retryable;
    public readonly ?string $at;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->code = ValueHydrator::string($data['code'] ?? null, true);
        $this->message = ValueHydrator::string($data['message'] ?? null, true);
        $this->retryable = ValueHydrator::bool($data['retryable'] ?? null, true);
        $this->at = ValueHydrator::string($data['at'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class FileLink extends DomainValue
{
    public readonly string $id;
    public readonly string $kind;
    public readonly string $fileId;
    public readonly string $purpose;
    public readonly string $status;
    public readonly bool $active;
    public readonly FileLinkDelivery $delivery;
    public readonly FileLinkAccess $access;
    public readonly FileLinkActor $createdBy;
    public readonly ?FileLinkActor $revokedBy;
    /** @var array<string, string>|null */
    public readonly ?array $customData;
    /** @var array<string, string>|null */
    public readonly ?array $metadata;
    public readonly string $createdAt;
    public readonly string $updatedAt;
    public readonly string $expiresAt;
    public readonly ?string $revokedAt;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->id = ValueHydrator::string($data['id'] ?? null, false);
        $this->kind = ValueHydrator::string($data['kind'] ?? null, false);
        $this->fileId = ValueHydrator::string($data['file_id'] ?? null, false);
        $this->purpose = ValueHydrator::string($data['purpose'] ?? null, false);
        $this->status = ValueHydrator::string($data['status'] ?? null, false);
        $this->active = ValueHydrator::bool($data['active'] ?? null, false);
        $this->delivery = ValueHydrator::object($data['delivery'] ?? null, [FileLinkDelivery::class], false);
        $this->access = ValueHydrator::object($data['access'] ?? null, [FileLinkAccess::class], false);
        $this->createdBy = ValueHydrator::object($data['created_by'] ?? null, [FileLinkActor::class], false);
        $this->revokedBy = ValueHydrator::object($data['revoked_by'] ?? null, [FileLinkActor::class], true);
        $this->customData = ValueHydrator::array($data['custom_data'] ?? null, true);
        $this->metadata = ValueHydrator::array($data['metadata'] ?? null, true);
        $this->createdAt = ValueHydrator::string($data['created_at'] ?? null, false);
        $this->updatedAt = ValueHydrator::string($data['updated_at'] ?? null, false);
        $this->expiresAt = ValueHydrator::string($data['expires_at'] ?? null, false);
        $this->revokedAt = ValueHydrator::string($data['revoked_at'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class FileLinkAccess extends DomainValue
{
    public readonly ?int $maxAccesses;
    public readonly ?int $accessCount;
    public readonly ?string $lastAccessedAt;
    public readonly ?bool $allowDownload;
    /** @var list<string>|null */
    public readonly ?array $allowedOrigins;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->maxAccesses = ValueHydrator::int($data['max_accesses'] ?? null, true);
        $this->accessCount = ValueHydrator::int($data['access_count'] ?? null, true);
        $this->lastAccessedAt = ValueHydrator::string($data['last_accessed_at'] ?? null, true);
        $this->allowDownload = ValueHydrator::bool($data['allow_download'] ?? null, true);
        $this->allowedOrigins = ValueHydrator::array($data['allowed_origins'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class FileLinkActor extends DomainValue
{
    public readonly ?string $email;
    public readonly ?string $id;
    public readonly ?string $name;
    public readonly string $type;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->email = ValueHydrator::string($data['email'] ?? null, true);
        $this->id = ValueHydrator::string($data['id'] ?? null, true);
        $this->name = ValueHydrator::string($data['name'] ?? null, true);
        $this->type = ValueHydrator::string($data['type'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class FileLinkCreation extends DomainValue
{
    public readonly FileLink $fileLink;
    public readonly string $url;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->fileLink = ValueHydrator::object($data['file_link'] ?? null, [FileLink::class], false);
        $this->url = ValueHydrator::string($data['url'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class FileLinkDelivery extends DomainValue
{
    public readonly ?string $mode;
    public readonly ?string $filename;
    public readonly ?string $contentType;
    public readonly ?string $disposition;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->mode = ValueHydrator::string($data['mode'] ?? null, true);
        $this->filename = ValueHydrator::string($data['filename'] ?? null, true);
        $this->contentType = ValueHydrator::string($data['content_type'] ?? null, true);
        $this->disposition = ValueHydrator::string($data['disposition'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class FileLinkPage extends DomainValue
{
    public readonly int $number;
    public readonly int $size;
    /** @var list<FileLink> */
    public readonly array $fileLinks;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->number = ValueHydrator::int($data['number'] ?? null, false);
        $this->size = ValueHydrator::int($data['size'] ?? null, false);
        $this->fileLinks = ValueHydrator::objects($data['file_links'] ?? null, [FileLink::class]);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class FileMedia extends DomainValue
{
    public readonly ?string $kind;
    public readonly ?int $width;
    public readonly ?int $height;
    public readonly ?int $durationMs;
    public readonly ?int $pageCount;
    public readonly ?int $frameCount;
    public readonly ?string $colorSpace;
    public readonly ?bool $hasAlpha;
    public readonly ?string $codec;
    public readonly ?string $aspectRatio;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->kind = ValueHydrator::string($data['kind'] ?? null, true);
        $this->width = ValueHydrator::int($data['width'] ?? null, true);
        $this->height = ValueHydrator::int($data['height'] ?? null, true);
        $this->durationMs = ValueHydrator::int($data['duration_ms'] ?? null, true);
        $this->pageCount = ValueHydrator::int($data['page_count'] ?? null, true);
        $this->frameCount = ValueHydrator::int($data['frame_count'] ?? null, true);
        $this->colorSpace = ValueHydrator::string($data['color_space'] ?? null, true);
        $this->hasAlpha = ValueHydrator::bool($data['has_alpha'] ?? null, true);
        $this->codec = ValueHydrator::string($data['codec'] ?? null, true);
        $this->aspectRatio = ValueHydrator::string($data['aspect_ratio'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class FilePage extends DomainValue
{
    public readonly int $number;
    public readonly int $size;
    /** @var list<File> */
    public readonly array $files;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->number = ValueHydrator::int($data['number'] ?? null, false);
        $this->size = ValueHydrator::int($data['size'] ?? null, false);
        $this->files = ValueHydrator::objects($data['files'] ?? null, [File::class]);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class FileParty extends DomainValue
{
    public readonly ?string $type;
    public readonly ?string $id;
    public readonly ?string $name;
    public readonly ?string $email;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->type = ValueHydrator::string($data['type'] ?? null, true);
        $this->id = ValueHydrator::string($data['id'] ?? null, true);
        $this->name = ValueHydrator::string($data['name'] ?? null, true);
        $this->email = ValueHydrator::string($data['email'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class FileReferenceReconciliation extends DomainValue
{
    public readonly bool $reconciled;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->reconciled = ValueHydrator::bool($data['reconciled'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class FileResource extends DomainValue
{
    public readonly ?string $type;
    public readonly ?string $id;
    public readonly ?string $name;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->type = ValueHydrator::string($data['type'] ?? null, true);
        $this->id = ValueHydrator::string($data['id'] ?? null, true);
        $this->name = ValueHydrator::string($data['name'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class FileSource extends DomainValue
{
    public readonly ?string $type;
    public readonly ?string $service;
    public readonly ?string $uploadRequestId;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->type = ValueHydrator::string($data['type'] ?? null, true);
        $this->service = ValueHydrator::string($data['service'] ?? null, true);
        $this->uploadRequestId = ValueHydrator::string($data['upload_request_id'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class FileUploadReceipt extends DomainValue
{
    public readonly string $contentType;
    public readonly string $createdAt;
    public readonly ?string $filename;
    public readonly string $id;
    public readonly ?string $name;
    public readonly int $size;
    public readonly string $status;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->contentType = ValueHydrator::string($data['content_type'] ?? null, false);
        $this->createdAt = ValueHydrator::string($data['created_at'] ?? null, false);
        $this->filename = ValueHydrator::string($data['filename'] ?? null, true);
        $this->id = ValueHydrator::string($data['id'] ?? null, false);
        $this->name = ValueHydrator::string($data['name'] ?? null, true);
        $this->size = ValueHydrator::int($data['size'] ?? null, false);
        $this->status = ValueHydrator::string($data['status'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class FinancialAccount extends DomainValue
{
    public readonly ?string $appCustomerLocalFingerprint;
    public readonly ?string $appLocalFingerprint;
    public readonly ?string $archivedAt;
    public readonly string $createdAt;
    public readonly string $currency;
    /** @var array<string, string>|null */
    public readonly ?array $customData;
    public readonly ?string $description;
    public readonly string $id;
    public readonly ?FinancialInstitution $institution;
    public readonly ?string $label;
    public readonly ?FinancialAccountPullConfiguration $pullConfiguration;
    public readonly ?FinancialAccountPushConfiguration $pushConfiguration;
    public readonly ?string $reference;
    public readonly ?ResourceSupply $supplied;
    public readonly string $type;
    public readonly ?string $universalFingerprint;
    /** @var array<string, mixed>|null */
    public readonly ?array $verification;
    public readonly ?FinancialAccountBank $bankAccount;
    public readonly ?string $disconnectedAt;
    /** @var array<string, mixed>|null */
    public readonly ?array $doshAccount;
    public readonly ?FinancialAccountOwner $owner;
    public readonly ?FinancialAccountWallet $wallet;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->appCustomerLocalFingerprint = ValueHydrator::string($data['app_customer_local_fingerprint'] ?? null, true);
        $this->appLocalFingerprint = ValueHydrator::string($data['app_local_fingerprint'] ?? null, true);
        $this->archivedAt = ValueHydrator::string($data['archived_at'] ?? null, true);
        $this->createdAt = ValueHydrator::string($data['created_at'] ?? null, false);
        $this->currency = ValueHydrator::string($data['currency'] ?? null, false);
        $this->customData = ValueHydrator::array($data['custom_data'] ?? null, true);
        $this->description = ValueHydrator::string($data['description'] ?? null, true);
        $this->id = ValueHydrator::string($data['id'] ?? null, false);
        $this->institution = ValueHydrator::object($data['institution'] ?? null, [FinancialInstitution::class], true);
        $this->label = ValueHydrator::string($data['label'] ?? null, true);
        $this->pullConfiguration = ValueHydrator::object($data['pull_configuration'] ?? null, [FinancialAccountPullConfiguration::class], true);
        $this->pushConfiguration = ValueHydrator::object($data['push_configuration'] ?? null, [FinancialAccountPushConfiguration::class], true);
        $this->reference = ValueHydrator::string($data['reference'] ?? null, true);
        $this->supplied = ValueHydrator::object($data['supplied'] ?? null, [ResourceSupply::class], true);
        $this->type = ValueHydrator::string($data['type'] ?? null, false);
        $this->universalFingerprint = ValueHydrator::string($data['universal_fingerprint'] ?? null, true);
        $this->verification = ValueHydrator::array($data['verification'] ?? null, true);
        $this->bankAccount = ValueHydrator::object($data['bank_account'] ?? null, [FinancialAccountBank::class], true);
        $this->disconnectedAt = ValueHydrator::string($data['disconnected_at'] ?? null, true);
        $this->doshAccount = ValueHydrator::array($data['dosh_account'] ?? null, true);
        $this->owner = ValueHydrator::object($data['owner'] ?? null, [FinancialAccountOwner::class], true);
        $this->wallet = ValueHydrator::object($data['wallet'] ?? null, [FinancialAccountWallet::class], true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class FinancialAccountAddress extends DomainValue
{
    public readonly string $city;
    public readonly string $country;
    public readonly string $line1;
    public readonly ?string $line2;
    public readonly ?string $name;
    public readonly ?string $phone;
    public readonly ?string $postCode;
    public readonly string $region;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->city = ValueHydrator::string($data['city'] ?? null, false);
        $this->country = ValueHydrator::string($data['country'] ?? null, false);
        $this->line1 = ValueHydrator::string($data['line_1'] ?? null, false);
        $this->line2 = ValueHydrator::string($data['line_2'] ?? null, true);
        $this->name = ValueHydrator::string($data['name'] ?? null, true);
        $this->phone = ValueHydrator::string($data['phone'] ?? null, true);
        $this->postCode = ValueHydrator::string($data['post_code'] ?? null, true);
        $this->region = ValueHydrator::string($data['region'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class FinancialAccountBank extends DomainValue
{
    public readonly string $type;
    public readonly ?GhanaBankAccount $ghanaBankAccount;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->type = ValueHydrator::string($data['type'] ?? null, false);
        $this->ghanaBankAccount = ValueHydrator::object($data['ghana_bank_account'] ?? null, [GhanaBankAccount::class], true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class FinancialAccountOwner extends DomainValue
{
    public readonly FinancialAccountAddress $address;
    public readonly string $name;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->address = ValueHydrator::object($data['address'] ?? null, [FinancialAccountAddress::class], false);
        $this->name = ValueHydrator::string($data['name'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class FinancialAccountPage extends DomainValue
{
    /** @var list<FinancialAccount> */
    public readonly array $accounts;
    public readonly int $number;
    public readonly int $size;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->accounts = ValueHydrator::objects($data['accounts'] ?? null, [FinancialAccount::class]);
        $this->number = ValueHydrator::int($data['number'] ?? null, false);
        $this->size = ValueHydrator::int($data['size'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class FinancialAccountPullConfiguration extends DomainValue
{
    public readonly string $enabledAt;
    public readonly FinancialAccountPullConfigurationMandate $mandate;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->enabledAt = ValueHydrator::string($data['enabled_at'] ?? null, false);
        $this->mandate = ValueHydrator::object($data['mandate'] ?? null, [FinancialAccountPullConfigurationMandate::class], false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class FinancialAccountPullConfigurationMandate extends DomainValue
{
    public readonly string $createdAt;
    public readonly string $id;
    public readonly string $ipAddress;
    public readonly string $userAgent;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->createdAt = ValueHydrator::string($data['created_at'] ?? null, false);
        $this->id = ValueHydrator::string($data['id'] ?? null, false);
        $this->ipAddress = ValueHydrator::string($data['ip_address'] ?? null, false);
        $this->userAgent = ValueHydrator::string($data['user_agent'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class FinancialAccountPushConfiguration extends DomainValue
{
    public readonly string $enabledAt;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->enabledAt = ValueHydrator::string($data['enabled_at'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class FinancialAccountWallet extends DomainValue
{
    public readonly string $id;
    public readonly string $type;
    public readonly ?FinancialAccountWalletMobileMoney $mobileMoney;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->id = ValueHydrator::string($data['id'] ?? null, false);
        $this->type = ValueHydrator::string($data['type'] ?? null, false);
        $this->mobileMoney = ValueHydrator::object($data['mobile_money'] ?? null, [FinancialAccountWalletMobileMoney::class], true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class FinancialAccountWalletMobileMoney extends DomainValue
{
    public readonly string $accountNumber;
    public readonly string $network;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->accountNumber = ValueHydrator::string($data['account_number'] ?? null, false);
        $this->network = ValueHydrator::string($data['network'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class FinancialInstitution extends DomainValue
{
    public readonly ?FinancialInstitutionBank $bank;
    public readonly string $country;
    public readonly string $id;
    public readonly ?FinancialInstitutionMobileMoneyProvider $mobileMoneyProvider;
    public readonly string $name;
    public readonly string $type;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->bank = ValueHydrator::object($data['bank'] ?? null, [FinancialInstitutionBank::class], true);
        $this->country = ValueHydrator::string($data['country'] ?? null, false);
        $this->id = ValueHydrator::string($data['id'] ?? null, false);
        $this->mobileMoneyProvider = ValueHydrator::object($data['mobile_money_provider'] ?? null, [FinancialInstitutionMobileMoneyProvider::class], true);
        $this->name = ValueHydrator::string($data['name'] ?? null, false);
        $this->type = ValueHydrator::string($data['type'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class FinancialInstitutionBank extends DomainValue
{
    public readonly string $bankAccountType;
    public readonly ?FinancialInstitutionBankBranch $branch;
    public readonly string $codeScheme;
    public readonly ?string $sortCodePrefix;
    public readonly ?string $swiftCode;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->bankAccountType = ValueHydrator::string($data['bank_account_type'] ?? null, false);
        $this->branch = ValueHydrator::object($data['branch'] ?? null, [FinancialInstitutionBankBranch::class], true);
        $this->codeScheme = ValueHydrator::string($data['code_scheme'] ?? null, false);
        $this->sortCodePrefix = ValueHydrator::string($data['sort_code_prefix'] ?? null, true);
        $this->swiftCode = ValueHydrator::string($data['swift_code'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class FinancialInstitutionBankBranch extends DomainValue
{
    public readonly string $id;
    public readonly string $name;
    public readonly string $sortCode;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->id = ValueHydrator::string($data['id'] ?? null, false);
        $this->name = ValueHydrator::string($data['name'] ?? null, false);
        $this->sortCode = ValueHydrator::string($data['sort_code'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class FinancialInstitutionMobileMoneyProvider extends DomainValue
{
    public readonly string $provider;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->provider = ValueHydrator::string($data['provider'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class GeneratedSecretKey extends DomainValue
{
    public readonly string $id;
    public readonly ?string $label;
    public readonly string $tokenType;
    public readonly string $issuedAt;
    public readonly string $token;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->id = ValueHydrator::string($data['id'] ?? null, false);
        $this->label = ValueHydrator::string($data['label'] ?? null, true);
        $this->tokenType = ValueHydrator::string($data['token_type'] ?? null, false);
        $this->issuedAt = ValueHydrator::string($data['issued_at'] ?? null, false);
        $this->token = ValueHydrator::string($data['token'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class GhanaBankAccount extends DomainValue
{
    public readonly ?string $branch;
    public readonly FinancialAccountOwner $holder;
    public readonly ?string $name;
    public readonly string $number;
    public readonly ?string $sortCode;
    public readonly ?string $swiftCode;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->branch = ValueHydrator::string($data['branch'] ?? null, true);
        $this->holder = ValueHydrator::object($data['holder'] ?? null, [FinancialAccountOwner::class], false);
        $this->name = ValueHydrator::string($data['name'] ?? null, true);
        $this->number = ValueHydrator::string($data['number'] ?? null, false);
        $this->sortCode = ValueHydrator::string($data['sort_code'] ?? null, true);
        $this->swiftCode = ValueHydrator::string($data['swift_code'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class InvoiceSettings extends DomainValue
{
    public readonly ?string $number;
    public readonly ?string $memo;
    public readonly ?string $footer;
    /** @var array<string, string>|null */
    public readonly ?array $customData;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->number = ValueHydrator::string($data['number'] ?? null, true);
        $this->memo = ValueHydrator::string($data['memo'] ?? null, true);
        $this->footer = ValueHydrator::string($data['footer'] ?? null, true);
        $this->customData = ValueHydrator::array($data['custom_data'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class MessageTemplate extends DomainValue
{
    public readonly string $id;
    public readonly string $name;
    public readonly ?string $about;
    public readonly string $channel;
    public readonly string $purpose;
    public readonly string $locale;
    public readonly string $status;
    public readonly int $version;
    public readonly ?int $publishedVersion;
    public readonly int $draftVersion;
    public readonly bool $hasUnpublishedChanges;
    /** @var list<MessageTemplateVariable>|null */
    public readonly ?array $variables;
    public readonly ?MessageTemplateSMSContent $sms;
    public readonly ?MessageTemplateEmailContent $email;
    public readonly ?GenericValue $attachments;
    public readonly string $createdAt;
    public readonly string $updatedAt;
    public readonly ?string $publishedAt;
    public readonly ?string $archivedAt;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->id = ValueHydrator::string($data['id'] ?? null, false);
        $this->name = ValueHydrator::string($data['name'] ?? null, false);
        $this->about = ValueHydrator::string($data['about'] ?? null, true);
        $this->channel = ValueHydrator::string($data['channel'] ?? null, false);
        $this->purpose = ValueHydrator::string($data['purpose'] ?? null, false);
        $this->locale = ValueHydrator::string($data['locale'] ?? null, false);
        $this->status = ValueHydrator::string($data['status'] ?? null, false);
        $this->version = ValueHydrator::int($data['version'] ?? null, false);
        $this->publishedVersion = ValueHydrator::int($data['published_version'] ?? null, true);
        $this->draftVersion = ValueHydrator::int($data['draft_version'] ?? null, false);
        $this->hasUnpublishedChanges = ValueHydrator::bool($data['has_unpublished_changes'] ?? null, false);
        $this->variables = ValueHydrator::objects($data['variables'] ?? null, [MessageTemplateVariable::class]);
        $this->sms = ValueHydrator::object($data['sms'] ?? null, [MessageTemplateSMSContent::class], true);
        $this->email = ValueHydrator::object($data['email'] ?? null, [MessageTemplateEmailContent::class], true);
        $this->attachments = ValueHydrator::object($data['attachments'] ?? null, [GenericValue::class], true);
        $this->createdAt = ValueHydrator::string($data['created_at'] ?? null, false);
        $this->updatedAt = ValueHydrator::string($data['updated_at'] ?? null, false);
        $this->publishedAt = ValueHydrator::string($data['published_at'] ?? null, true);
        $this->archivedAt = ValueHydrator::string($data['archived_at'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class MessageTemplateEmailContent extends DomainValue
{
    public readonly string $subject;
    public readonly string $html;
    public readonly ?MessageTemplateMailbox $from;
    public readonly ?MessageTemplateMailbox $replyTo;
    /** @var array<string, string>|null */
    public readonly ?array $headers;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->subject = ValueHydrator::string($data['subject'] ?? null, false);
        $this->html = ValueHydrator::string($data['html'] ?? null, false);
        $this->from = ValueHydrator::object($data['from_'] ?? null, [MessageTemplateMailbox::class], true);
        $this->replyTo = ValueHydrator::object($data['reply_to'] ?? null, [MessageTemplateMailbox::class], true);
        $this->headers = ValueHydrator::array($data['headers'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class MessageTemplateMailbox extends DomainValue
{
    public readonly string $address;
    public readonly ?string $name;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->address = ValueHydrator::string($data['address'] ?? null, false);
        $this->name = ValueHydrator::string($data['name'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class MessageTemplatePreview extends DomainValue
{
    public readonly MessageTemplate $messageTemplate;
    public readonly RenderedMessageTemplate $rendered;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->messageTemplate = ValueHydrator::object($data['message_template'] ?? null, [MessageTemplate::class], false);
        $this->rendered = ValueHydrator::object($data['rendered'] ?? null, [RenderedMessageTemplate::class], false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class MessageTemplateSMSContent extends DomainValue
{
    public readonly string $messageTemplate;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->messageTemplate = ValueHydrator::string($data['message_template'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class MessageTemplateSafetyResult extends DomainValue
{
    public readonly string $contentHash;
    /** @var list<MessageTemplateScannedLink>|null */
    public readonly ?array $links;
    public readonly string $normalizedText;
    public readonly ?string $quarantineNotes;
    /** @var list<string>|null */
    public readonly ?array $reasonCodes;
    public readonly ?string $sanitizedHtml;
    public readonly string $scanner;
    public readonly string $status;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->contentHash = ValueHydrator::string($data['content_hash'] ?? null, false);
        $this->links = ValueHydrator::objects($data['links'] ?? null, [MessageTemplateScannedLink::class]);
        $this->normalizedText = ValueHydrator::string($data['normalized_text'] ?? null, false);
        $this->quarantineNotes = ValueHydrator::string($data['quarantine_notes'] ?? null, true);
        $this->reasonCodes = ValueHydrator::array($data['reason_codes'] ?? null, true);
        $this->sanitizedHtml = ValueHydrator::string($data['sanitized_html'] ?? null, true);
        $this->scanner = ValueHydrator::string($data['scanner'] ?? null, false);
        $this->status = ValueHydrator::string($data['status'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class MessageTemplateScannedLink extends DomainValue
{
    public readonly ?string $host;
    public readonly string $raw;
    public readonly ?string $reason;
    public readonly string $scheme;
    public readonly string $status;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->host = ValueHydrator::string($data['host'] ?? null, true);
        $this->raw = ValueHydrator::string($data['raw'] ?? null, false);
        $this->reason = ValueHydrator::string($data['reason'] ?? null, true);
        $this->scheme = ValueHydrator::string($data['scheme'] ?? null, false);
        $this->status = ValueHydrator::string($data['status'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class MessageTemplateVariable extends DomainValue
{
    public readonly ?string $about;
    public readonly mixed $default;
    /** @var list<MessageTemplateVariableItem>|null */
    public readonly ?array $items;
    public readonly string $name;
    public readonly bool $required;
    public readonly string $type;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->about = ValueHydrator::string($data['about'] ?? null, true);
        $this->default = $data['default'] ?? null;
        $this->items = ValueHydrator::objects($data['items'] ?? null, [MessageTemplateVariableItem::class]);
        $this->name = ValueHydrator::string($data['name'] ?? null, false);
        $this->required = ValueHydrator::bool($data['required'] ?? null, false);
        $this->type = ValueHydrator::string($data['type'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class MessageTemplateVariableItem extends DomainValue
{
    public readonly ?string $about;
    public readonly mixed $default;
    public readonly string $name;
    public readonly bool $required;
    public readonly string $type;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->about = ValueHydrator::string($data['about'] ?? null, true);
        $this->default = $data['default'] ?? null;
        $this->name = ValueHydrator::string($data['name'] ?? null, false);
        $this->required = ValueHydrator::bool($data['required'] ?? null, false);
        $this->type = ValueHydrator::string($data['type'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class MessageTemplatesPage extends DomainValue
{
    public readonly int $number;
    public readonly int $size;
    /** @var list<MessageTemplate> */
    public readonly array $messageTemplates;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->number = ValueHydrator::int($data['number'] ?? null, false);
        $this->size = ValueHydrator::int($data['size'] ?? null, false);
        $this->messageTemplates = ValueHydrator::objects($data['message_templates'] ?? null, [MessageTemplate::class]);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class Money extends DomainValue
{
    public readonly string $currency;
    public readonly int $value;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->currency = ValueHydrator::string($data['currency'] ?? null, false);
        $this->value = ValueHydrator::int($data['value'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class OTPTransaction extends DomainValue
{
    public readonly ?string $cancelReason;
    public readonly ?string $canceledAt;
    public readonly string $expiresAt;
    public readonly string $fullMessage;
    public readonly string $id;
    public readonly string $initiatedAt;
    public readonly string $status;
    public readonly ?OTPTransmission $transmission;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->cancelReason = ValueHydrator::string($data['cancel_reason'] ?? null, true);
        $this->canceledAt = ValueHydrator::string($data['canceled_at'] ?? null, true);
        $this->expiresAt = ValueHydrator::string($data['expires_at'] ?? null, false);
        $this->fullMessage = ValueHydrator::string($data['full_message'] ?? null, false);
        $this->id = ValueHydrator::string($data['id'] ?? null, false);
        $this->initiatedAt = ValueHydrator::string($data['initiated_at'] ?? null, false);
        $this->status = ValueHydrator::string($data['status'] ?? null, false);
        $this->transmission = ValueHydrator::object($data['transmission'] ?? null, [OTPTransmission::class], true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class OTPTransmission extends DomainValue
{
    public readonly string $recipient;
    public readonly string $senderId;
    public readonly ?string $sentAt;
    public readonly ?string $sentVia;
    public readonly ?string $status;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->recipient = ValueHydrator::string($data['recipient'] ?? null, false);
        $this->senderId = ValueHydrator::string($data['sender_id'] ?? null, false);
        $this->sentAt = ValueHydrator::string($data['sent_at'] ?? null, true);
        $this->sentVia = ValueHydrator::string($data['sent_via'] ?? null, true);
        $this->status = ValueHydrator::string($data['status'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class OTPVerification extends DomainValue
{
    public readonly OTPTransaction $transaction;
    public readonly OTPVerificationAttempt $verificationAttempt;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->transaction = ValueHydrator::object($data['transaction'] ?? null, [OTPTransaction::class], false);
        $this->verificationAttempt = ValueHydrator::object($data['verification_attempt'] ?? null, [OTPVerificationAttempt::class], false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class OTPVerificationAttempt extends DomainValue
{
    public readonly string $attemptedAt;
    public readonly string $id;
    public readonly string $presentedToken;
    public readonly string $recipient;
    public readonly OTPVerificationAttemptResult $result;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->attemptedAt = ValueHydrator::string($data['attempted_at'] ?? null, false);
        $this->id = ValueHydrator::string($data['id'] ?? null, false);
        $this->presentedToken = ValueHydrator::string($data['presented_token'] ?? null, false);
        $this->recipient = ValueHydrator::string($data['recipient'] ?? null, false);
        $this->result = ValueHydrator::object($data['result'] ?? null, [OTPVerificationAttemptResult::class], false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class OTPVerificationAttemptResult extends DomainValue
{
    public readonly ?string $detail;
    public readonly string $verdict;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->detail = ValueHydrator::string($data['detail'] ?? null, true);
        $this->verdict = ValueHydrator::string($data['verdict'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class Order extends DomainValue
{
    public readonly ?string $canceledAt;
    public readonly ?OrderCheckoutSettings $checkoutSettings;
    public readonly ?string $completedAt;
    public readonly ?OrderCreatedFrom $createdFrom;
    /** @var array<string, string>|null */
    public readonly ?array $customData;
    public readonly OrderCustomer $customer;
    public readonly ?string $expiresAt;
    public readonly string $id;
    public readonly string $initiatedAt;
    public readonly ?OrderInvoice $invoice;
    public readonly ?string $number;
    public readonly ?string $receiptNumber;
    /** @var list<Refund>|null */
    public readonly ?array $refunds;
    public readonly ?InvoiceSettings $invoiceSettings;
    public readonly string $status;
    public readonly ?string $sealedAt;
    public readonly ?OrderLineItemGroup $lineItemGroup;
    public readonly ?OrderPayment $payment;
    public readonly ?string $paidAt;
    public readonly ?string $paymentDueAt;
    /** @var array<string, mixed>|null */
    public readonly ?array $payoutSettings;
    public readonly ?string $reference;
    /** @var array<string, mixed>|null */
    public readonly ?array $shipping;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->canceledAt = ValueHydrator::string($data['canceled_at'] ?? null, true);
        $this->checkoutSettings = ValueHydrator::object($data['checkout_settings'] ?? null, [OrderCheckoutSettings::class], true);
        $this->completedAt = ValueHydrator::string($data['completed_at'] ?? null, true);
        $this->createdFrom = ValueHydrator::object($data['created_from'] ?? null, [OrderCreatedFrom::class], true);
        $this->customData = ValueHydrator::array($data['custom_data'] ?? null, true);
        $this->customer = ValueHydrator::object($data['customer'] ?? null, [OrderCustomer::class], false);
        $this->expiresAt = ValueHydrator::string($data['expires_at'] ?? null, true);
        $this->id = ValueHydrator::string($data['id'] ?? null, false);
        $this->initiatedAt = ValueHydrator::string($data['initiated_at'] ?? null, false);
        $this->invoice = ValueHydrator::object($data['invoice'] ?? null, [OrderInvoice::class], true);
        $this->number = ValueHydrator::string($data['number'] ?? null, true);
        $this->receiptNumber = ValueHydrator::string($data['receipt_number'] ?? null, true);
        $this->refunds = ValueHydrator::objects($data['refunds'] ?? null, [Refund::class]);
        $this->invoiceSettings = ValueHydrator::object($data['invoice_settings'] ?? null, [InvoiceSettings::class], true);
        $this->status = ValueHydrator::string($data['status'] ?? null, false);
        $this->sealedAt = ValueHydrator::string($data['sealed_at'] ?? null, true);
        $this->lineItemGroup = ValueHydrator::object($data['line_item_group'] ?? null, [OrderLineItemGroup::class], true);
        $this->payment = ValueHydrator::object($data['payment'] ?? null, [OrderPayment::class], true);
        $this->paidAt = ValueHydrator::string($data['paid_at'] ?? null, true);
        $this->paymentDueAt = ValueHydrator::string($data['payment_due_at'] ?? null, true);
        $this->payoutSettings = ValueHydrator::array($data['payout_settings'] ?? null, true);
        $this->reference = ValueHydrator::string($data['reference'] ?? null, true);
        $this->shipping = ValueHydrator::array($data['shipping'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class OrderAddress extends DomainValue
{
    public readonly ?string $name;
    public readonly ?string $phoneNumber;
    public readonly ?string $line1;
    public readonly ?string $line2;
    public readonly ?string $city;
    public readonly ?string $region;
    public readonly ?string $postCode;
    public readonly string $country;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->name = ValueHydrator::string($data['name'] ?? null, true);
        $this->phoneNumber = ValueHydrator::string($data['phone_number'] ?? null, true);
        $this->line1 = ValueHydrator::string($data['line1'] ?? null, true);
        $this->line2 = ValueHydrator::string($data['line2'] ?? null, true);
        $this->city = ValueHydrator::string($data['city'] ?? null, true);
        $this->region = ValueHydrator::string($data['region'] ?? null, true);
        $this->postCode = ValueHydrator::string($data['post_code'] ?? null, true);
        $this->country = ValueHydrator::string($data['country'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class OrderCheckoutSettings extends DomainValue
{
    public readonly ?string $redirectUrl;
    public readonly ?string $cancelUrl;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->redirectUrl = ValueHydrator::string($data['redirect_url'] ?? null, true);
        $this->cancelUrl = ValueHydrator::string($data['cancel_url'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class OrderCreatedFrom extends DomainValue
{
    public readonly ?string $source;
    public readonly ?string $resourceType;
    public readonly ?string $resourceId;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->source = ValueHydrator::string($data['source'] ?? null, true);
        $this->resourceType = ValueHydrator::string($data['resource_type'] ?? null, true);
        $this->resourceId = ValueHydrator::string($data['resource_id'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class OrderCustomer extends DomainValue
{
    public readonly string $id;
    public readonly bool $guest;
    public readonly string $name;
    public readonly ?string $emailAddress;
    public readonly ?string $phoneNumber;
    public readonly ?OrderAddress $billingAddress;
    public readonly ?OrderAddress $shippingAddress;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->id = ValueHydrator::string($data['id'] ?? null, false);
        $this->guest = ValueHydrator::bool($data['guest'] ?? null, false);
        $this->name = ValueHydrator::string($data['name'] ?? null, false);
        $this->emailAddress = ValueHydrator::string($data['email_address'] ?? null, true);
        $this->phoneNumber = ValueHydrator::string($data['phone_number'] ?? null, true);
        $this->billingAddress = ValueHydrator::object($data['billing_address'] ?? null, [OrderAddress::class], true);
        $this->shippingAddress = ValueHydrator::object($data['shipping_address'] ?? null, [OrderAddress::class], true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class OrderDocumentDelivery extends DomainValue
{
    /** @var list<OrderDocumentDeliveryAttempt>|null */
    public readonly ?array $deliveries;
    public readonly ?string $documentKind;
    public readonly ?string $documentUrl;
    /** @var list<string>|null */
    public readonly ?array $failedChannels;
    /** @var list<OrderDocumentDeliveryFailure>|null */
    public readonly ?array $failures;
    /** @var list<string>|null */
    public readonly ?array $sentChannels;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->deliveries = ValueHydrator::objects($data['deliveries'] ?? null, [OrderDocumentDeliveryAttempt::class]);
        $this->documentKind = ValueHydrator::string($data['document_kind'] ?? null, true);
        $this->documentUrl = ValueHydrator::string($data['document_url'] ?? null, true);
        $this->failedChannels = ValueHydrator::array($data['failed_channels'] ?? null, true);
        $this->failures = ValueHydrator::objects($data['failures'] ?? null, [OrderDocumentDeliveryFailure::class]);
        $this->sentChannels = ValueHydrator::array($data['sent_channels'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class OrderDocumentDeliveryAttempt extends DomainValue
{
    public readonly ?string $channel;
    public readonly ?string $chimeId;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->channel = ValueHydrator::string($data['channel'] ?? null, true);
        $this->chimeId = ValueHydrator::string($data['chime_id'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class OrderDocumentDeliveryFailure extends DomainValue
{
    public readonly ?string $channel;
    public readonly ?string $error;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->channel = ValueHydrator::string($data['channel'] ?? null, true);
        $this->error = ValueHydrator::string($data['error'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class OrderDocumentDeliveryResult extends DomainValue
{
    public readonly ?OrderDocumentDelivery $delivery;
    public readonly ?Error $error;
    public readonly ?Order $order;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->delivery = ValueHydrator::object($data['delivery'] ?? null, [OrderDocumentDelivery::class], true);
        $this->error = ValueHydrator::object($data['error'] ?? null, [Error::class], true);
        $this->order = ValueHydrator::object($data['order'] ?? null, [Order::class], true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class OrderDocumentFormat extends DomainValue
{
    public readonly string $url;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->url = ValueHydrator::string($data['url'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class OrderFeeLineItem extends DomainValue
{
    public readonly string $type;
    public readonly OrderFeeLineItemFee $fee;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->type = ValueHydrator::string($data['type'] ?? null, false);
        $this->fee = ValueHydrator::object($data['fee'] ?? null, [OrderFeeLineItemFee::class], false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class OrderFeeLineItemFee extends DomainValue
{
    public readonly string $id;
    public readonly ?string $description;
    public readonly ?string $taxCode;
    public readonly Money $amount;
    public readonly string $label;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->id = ValueHydrator::string($data['id'] ?? null, false);
        $this->description = ValueHydrator::string($data['description'] ?? null, true);
        $this->taxCode = ValueHydrator::string($data['tax_code'] ?? null, true);
        $this->amount = ValueHydrator::object($data['amount'] ?? null, [Money::class], false);
        $this->label = ValueHydrator::string($data['label'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class OrderInvoice extends DomainValue
{
    public readonly ?string $number;
    public readonly ?OrderInvoiceFormat $format;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->number = ValueHydrator::string($data['number'] ?? null, true);
        $this->format = ValueHydrator::object($data['format'] ?? null, [OrderInvoiceFormat::class], true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class OrderInvoiceFormat extends DomainValue
{
    public readonly OrderDocumentFormat $web;
    public readonly OrderDocumentFormat $pdf;
    public readonly ?OrderDocumentFormat $receipt;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->web = ValueHydrator::object($data['web'] ?? null, [OrderDocumentFormat::class], false);
        $this->pdf = ValueHydrator::object($data['pdf'] ?? null, [OrderDocumentFormat::class], false);
        $this->receipt = ValueHydrator::object($data['receipt'] ?? null, [OrderDocumentFormat::class], true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class OrderLineItemGroup extends DomainValue
{
    /** @var list<OrderProductLineItem|OrderFeeLineItem|OrderShippingLineItem> */
    public readonly array $lineItems;
    public readonly Money $total;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->lineItems = ValueHydrator::objects($data['line_items'] ?? null, [OrderProductLineItem::class, OrderFeeLineItem::class, OrderShippingLineItem::class]);
        $this->total = ValueHydrator::object($data['total'] ?? null, [Money::class], false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class OrderPage extends DomainValue
{
    public readonly ?int $number;
    public readonly ?int $size;
    /** @var list<Order>|null */
    public readonly ?array $orders;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->number = ValueHydrator::int($data['number'] ?? null, true);
        $this->size = ValueHydrator::int($data['size'] ?? null, true);
        $this->orders = ValueHydrator::objects($data['orders'] ?? null, [Order::class]);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class OrderPayment extends DomainValue
{
    public readonly string $id;
    public readonly string $status;
    public readonly string $statementDescriptor;
    public readonly Money $amount;
    public readonly ?BalanceTransaction $balanceTransaction;
    public readonly ?OrderPaymentMethod $paymentMethod;
    public readonly ?OrderPaymentLatestAttempt $latestAttempt;
    public readonly ?PaymentNextAction $nextAction;
    public readonly string $initiatedAt;
    public readonly ?string $executedAt;
    public readonly ?string $paidAt;
    public readonly ?string $canceledAt;
    public readonly ?string $dueAt;
    public readonly ?string $expiredAt;
    public readonly ?string $failedAt;
    public readonly ?bool $paidOffline;
    /** @var list<string>|null */
    public readonly ?array $paymentMethodTypes;
    public readonly ?OrderPaymentPayoutConfiguration $payoutConfiguration;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->id = ValueHydrator::string($data['id'] ?? null, false);
        $this->status = ValueHydrator::string($data['status'] ?? null, false);
        $this->statementDescriptor = ValueHydrator::string($data['statement_descriptor'] ?? null, false);
        $this->amount = ValueHydrator::object($data['amount'] ?? null, [Money::class], false);
        $this->balanceTransaction = ValueHydrator::object($data['balance_transaction'] ?? null, [BalanceTransaction::class], true);
        $this->paymentMethod = ValueHydrator::object($data['payment_method'] ?? null, [OrderPaymentMethod::class], true);
        $this->latestAttempt = ValueHydrator::object($data['latest_attempt'] ?? null, [OrderPaymentLatestAttempt::class], true);
        $this->nextAction = ValueHydrator::object($data['next_action'] ?? null, [PaymentNextAction::class], true);
        $this->initiatedAt = ValueHydrator::string($data['initiated_at'] ?? null, false);
        $this->executedAt = ValueHydrator::string($data['executed_at'] ?? null, true);
        $this->paidAt = ValueHydrator::string($data['paid_at'] ?? null, true);
        $this->canceledAt = ValueHydrator::string($data['canceled_at'] ?? null, true);
        $this->dueAt = ValueHydrator::string($data['due_at'] ?? null, true);
        $this->expiredAt = ValueHydrator::string($data['expired_at'] ?? null, true);
        $this->failedAt = ValueHydrator::string($data['failed_at'] ?? null, true);
        $this->paidOffline = ValueHydrator::bool($data['paid_offline'] ?? null, true);
        $this->paymentMethodTypes = ValueHydrator::array($data['payment_method_types'] ?? null, true);
        $this->payoutConfiguration = ValueHydrator::object($data['payout_configuration'] ?? null, [OrderPaymentPayoutConfiguration::class], true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class OrderPaymentLatestAttempt extends DomainValue
{
    public readonly ?string $paymentMethodType;
    public readonly ?string $paymentMethodId;
    public readonly ?string $reference;
    public readonly ?string $status;
    public readonly ?string $initiatedAt;
    public readonly ?string $succeededAt;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->paymentMethodType = ValueHydrator::string($data['payment_method_type'] ?? null, true);
        $this->paymentMethodId = ValueHydrator::string($data['payment_method_id'] ?? null, true);
        $this->reference = ValueHydrator::string($data['reference'] ?? null, true);
        $this->status = ValueHydrator::string($data['status'] ?? null, true);
        $this->initiatedAt = ValueHydrator::string($data['initiated_at'] ?? null, true);
        $this->succeededAt = ValueHydrator::string($data['succeeded_at'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class OrderPaymentMethod extends DomainValue
{
    public readonly string $id;
    public readonly ?OrderPaymentMethodBankAccount $bankAccount;
    /** @var array<string, mixed>|null */
    public readonly ?array $card;
    public readonly string $createdAt;
    public readonly string $customerId;
    public readonly ?OrderPaymentMethodMobileMoney $mobileMoney;
    public readonly ?OrderPaymentMethodOwner $owner;
    public readonly string $type;
    public readonly bool $verified;
    public readonly ?string $verifiedAt;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->id = ValueHydrator::string($data['id'] ?? null, false);
        $this->bankAccount = ValueHydrator::object($data['bank_account'] ?? null, [OrderPaymentMethodBankAccount::class], true);
        $this->card = ValueHydrator::array($data['card'] ?? null, true);
        $this->createdAt = ValueHydrator::string($data['created_at'] ?? null, false);
        $this->customerId = ValueHydrator::string($data['customer_id'] ?? null, false);
        $this->mobileMoney = ValueHydrator::object($data['mobile_money'] ?? null, [OrderPaymentMethodMobileMoney::class], true);
        $this->owner = ValueHydrator::object($data['owner'] ?? null, [OrderPaymentMethodOwner::class], true);
        $this->type = ValueHydrator::string($data['type'] ?? null, false);
        $this->verified = ValueHydrator::bool($data['verified'] ?? null, false);
        $this->verifiedAt = ValueHydrator::string($data['verified_at'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class OrderPaymentMethodBankAccount extends DomainValue
{
    public readonly string $type;
    public readonly ?OrderPaymentMethodBankAccountGhanaBankAccount $ghanaBankAccount;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->type = ValueHydrator::string($data['type'] ?? null, false);
        $this->ghanaBankAccount = ValueHydrator::object($data['ghana_bank_account'] ?? null, [OrderPaymentMethodBankAccountGhanaBankAccount::class], true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class OrderPaymentMethodBankAccountGhanaBankAccount extends DomainValue
{
    public readonly string $accountNumber;
    public readonly ?string $branch;
    public readonly ?string $name;
    public readonly ?string $sortCode;
    public readonly ?string $swiftCode;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->accountNumber = ValueHydrator::string($data['account_number'] ?? null, false);
        $this->branch = ValueHydrator::string($data['branch'] ?? null, true);
        $this->name = ValueHydrator::string($data['name'] ?? null, true);
        $this->sortCode = ValueHydrator::string($data['sort_code'] ?? null, true);
        $this->swiftCode = ValueHydrator::string($data['swift_code'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class OrderPaymentMethodMobileMoney extends DomainValue
{
    public readonly string $network;
    public readonly string $accountNumber;
    public readonly string $last4;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->network = ValueHydrator::string($data['network'] ?? null, false);
        $this->accountNumber = ValueHydrator::string($data['account_number'] ?? null, false);
        $this->last4 = ValueHydrator::string($data['last4'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class OrderPaymentMethodOwner extends DomainValue
{
    public readonly string $name;
    public readonly ?OrderAddress $address;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->name = ValueHydrator::string($data['name'] ?? null, false);
        $this->address = ValueHydrator::object($data['address'] ?? null, [OrderAddress::class], true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class OrderPaymentPayoutConfiguration extends DomainValue
{
    public readonly ?bool $enableFx;
    public readonly ?OrderPaymentPayoutConfigurationDestination $destination;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->enableFx = ValueHydrator::bool($data['enable_fx'] ?? null, true);
        $this->destination = ValueHydrator::object($data['destination'] ?? null, [OrderPaymentPayoutConfigurationDestination::class], true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class OrderPaymentPayoutConfigurationDestination extends DomainValue
{
    public readonly ?string $financialAccountId;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->financialAccountId = ValueHydrator::string($data['financial_account_id'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class OrderProductLineItem extends DomainValue
{
    public readonly string $type;
    public readonly OrderProductLineItemProduct $product;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->type = ValueHydrator::string($data['type'] ?? null, false);
        $this->product = ValueHydrator::object($data['product'] ?? null, [OrderProductLineItemProduct::class], false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class OrderProductLineItemProduct extends DomainValue
{
    public readonly string $id;
    public readonly ?string $productId;
    public readonly ?string $priceId;
    public readonly ?string $reference;
    public readonly ?string $about;
    /** @var array<string, string>|null */
    public readonly ?array $customData;
    public readonly ?string $taxCode;
    public readonly string $name;
    public readonly ?string $category;
    public readonly ?string $type;
    public readonly Money $price;
    public readonly int $quantity;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->id = ValueHydrator::string($data['id'] ?? null, false);
        $this->productId = ValueHydrator::string($data['product_id'] ?? null, true);
        $this->priceId = ValueHydrator::string($data['price_id'] ?? null, true);
        $this->reference = ValueHydrator::string($data['reference'] ?? null, true);
        $this->about = ValueHydrator::string($data['about'] ?? null, true);
        $this->customData = ValueHydrator::array($data['custom_data'] ?? null, true);
        $this->taxCode = ValueHydrator::string($data['tax_code'] ?? null, true);
        $this->name = ValueHydrator::string($data['name'] ?? null, false);
        $this->category = ValueHydrator::string($data['category'] ?? null, true);
        $this->type = ValueHydrator::string($data['type'] ?? null, true);
        $this->price = ValueHydrator::object($data['price'] ?? null, [Money::class], false);
        $this->quantity = ValueHydrator::int($data['quantity'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class OrderShippingLineItem extends DomainValue
{
    public readonly string $type;
    public readonly OrderShippingLineItemShipping $shipping;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->type = ValueHydrator::string($data['type'] ?? null, false);
        $this->shipping = ValueHydrator::object($data['shipping'] ?? null, [OrderShippingLineItemShipping::class], false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class OrderShippingLineItemShipping extends DomainValue
{
    public readonly string $id;
    public readonly ?string $taxCode;
    public readonly ?string $label;
    public readonly Money $fee;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->id = ValueHydrator::string($data['id'] ?? null, false);
        $this->taxCode = ValueHydrator::string($data['tax_code'] ?? null, true);
        $this->label = ValueHydrator::string($data['label'] ?? null, true);
        $this->fee = ValueHydrator::object($data['fee'] ?? null, [Money::class], false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class PaymentMethod extends DomainValue
{
    public readonly bool $active;
    public readonly ?string $appCustomerLocalFingerprint;
    public readonly ?string $appLocalFingerprint;
    public readonly ?string $archivedAt;
    public readonly ?PaymentMethodBankAccount $bankAccount;
    public readonly string $createdAt;
    /** @var array<string, string>|null */
    public readonly ?array $customData;
    public readonly string $customerId;
    public readonly ?bool $ephemeral;
    public readonly ?string $expiresOn;
    public readonly string $id;
    public readonly ?PaymentMethodMobileMoney $mobileMoney;
    public readonly ?PaymentMethodOwner $owner;
    public readonly string $type;
    public readonly ?PaymentMethodSupplied $supplied;
    public readonly ?string $universalFingerprint;
    public readonly ?PaymentMethodVerification $verification;
    public readonly ?string $verifiedAt;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->active = ValueHydrator::bool($data['active'] ?? null, false);
        $this->appCustomerLocalFingerprint = ValueHydrator::string($data['app_customer_local_fingerprint'] ?? null, true);
        $this->appLocalFingerprint = ValueHydrator::string($data['app_local_fingerprint'] ?? null, true);
        $this->archivedAt = ValueHydrator::string($data['archived_at'] ?? null, true);
        $this->bankAccount = ValueHydrator::object($data['bank_account'] ?? null, [PaymentMethodBankAccount::class], true);
        $this->createdAt = ValueHydrator::string($data['created_at'] ?? null, false);
        $this->customData = ValueHydrator::array($data['custom_data'] ?? null, true);
        $this->customerId = ValueHydrator::string($data['customer_id'] ?? null, false);
        $this->ephemeral = ValueHydrator::bool($data['ephemeral'] ?? null, true);
        $this->expiresOn = ValueHydrator::string($data['expires_on'] ?? null, true);
        $this->id = ValueHydrator::string($data['id'] ?? null, false);
        $this->mobileMoney = ValueHydrator::object($data['mobile_money'] ?? null, [PaymentMethodMobileMoney::class], true);
        $this->owner = ValueHydrator::object($data['owner'] ?? null, [PaymentMethodOwner::class], true);
        $this->type = ValueHydrator::string($data['type'] ?? null, false);
        $this->supplied = ValueHydrator::object($data['supplied'] ?? null, [PaymentMethodSupplied::class], true);
        $this->universalFingerprint = ValueHydrator::string($data['universal_fingerprint'] ?? null, true);
        $this->verification = ValueHydrator::object($data['verification'] ?? null, [PaymentMethodVerification::class], true);
        $this->verifiedAt = ValueHydrator::string($data['verified_at'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class PaymentMethodBankAccount extends DomainValue
{
    public readonly ?PaymentMethodBankAccountGhanaBankAccount $ghanaBankAccount;
    public readonly string $type;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->ghanaBankAccount = ValueHydrator::object($data['ghana_bank_account'] ?? null, [PaymentMethodBankAccountGhanaBankAccount::class], true);
        $this->type = ValueHydrator::string($data['type'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class PaymentMethodBankAccountGhanaBankAccount extends DomainValue
{
    public readonly ?string $branch;
    public readonly ?string $name;
    public readonly string $accountNumber;
    public readonly ?string $sortCode;
    public readonly ?string $swiftCode;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->branch = ValueHydrator::string($data['branch'] ?? null, true);
        $this->name = ValueHydrator::string($data['name'] ?? null, true);
        $this->accountNumber = ValueHydrator::string($data['account_number'] ?? null, false);
        $this->sortCode = ValueHydrator::string($data['sort_code'] ?? null, true);
        $this->swiftCode = ValueHydrator::string($data['swift_code'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class PaymentMethodDeletion extends DomainValue
{
    public readonly bool $deleted;
    public readonly string $paymentMethodId;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->deleted = ValueHydrator::bool($data['deleted'] ?? null, false);
        $this->paymentMethodId = ValueHydrator::string($data['payment_method_id'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class PaymentMethodMobileMoney extends DomainValue
{
    public readonly string $accountNumber;
    public readonly string $last4;
    public readonly string $network;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->accountNumber = ValueHydrator::string($data['account_number'] ?? null, false);
        $this->last4 = ValueHydrator::string($data['last4'] ?? null, false);
        $this->network = ValueHydrator::string($data['network'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class PaymentMethodOwner extends DomainValue
{
    public readonly ?PaymentMethodOwnerAddress $address;
    public readonly string $name;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->address = ValueHydrator::object($data['address'] ?? null, [PaymentMethodOwnerAddress::class], true);
        $this->name = ValueHydrator::string($data['name'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class PaymentMethodOwnerAddress extends DomainValue
{
    public readonly ?string $city;
    public readonly string $country;
    public readonly ?string $line1;
    public readonly ?string $line2;
    public readonly ?string $name;
    public readonly ?string $phoneNumber;
    public readonly ?string $postCode;
    public readonly ?string $region;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->city = ValueHydrator::string($data['city'] ?? null, true);
        $this->country = ValueHydrator::string($data['country'] ?? null, false);
        $this->line1 = ValueHydrator::string($data['line_1'] ?? null, true);
        $this->line2 = ValueHydrator::string($data['line_2'] ?? null, true);
        $this->name = ValueHydrator::string($data['name'] ?? null, true);
        $this->phoneNumber = ValueHydrator::string($data['phone_number'] ?? null, true);
        $this->postCode = ValueHydrator::string($data['post_code'] ?? null, true);
        $this->region = ValueHydrator::string($data['region'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class PaymentMethodPage extends DomainValue
{
    public readonly int $number;
    /** @var list<PaymentMethod> */
    public readonly array $paymentMethods;
    public readonly int $size;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->number = ValueHydrator::int($data['number'] ?? null, false);
        $this->paymentMethods = ValueHydrator::objects($data['payment_methods'] ?? null, [PaymentMethod::class]);
        $this->size = ValueHydrator::int($data['size'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class PaymentMethodSettings extends DomainValue
{
    public readonly ?PaymentMethodTypeSetting $mobileMoney;
    public readonly ?PaymentMethodTypeSetting $bankAccount;
    public readonly ?PaymentMethodTypeSetting $card;
    public readonly ?PaymentMethodTypeSetting $motito;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->mobileMoney = ValueHydrator::object($data['mobile_money'] ?? null, [PaymentMethodTypeSetting::class], true);
        $this->bankAccount = ValueHydrator::object($data['bank_account'] ?? null, [PaymentMethodTypeSetting::class], true);
        $this->card = ValueHydrator::object($data['card'] ?? null, [PaymentMethodTypeSetting::class], true);
        $this->motito = ValueHydrator::object($data['motito'] ?? null, [PaymentMethodTypeSetting::class], true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class PaymentMethodSupplied extends DomainValue
{
    public readonly ?string $attemptId;
    public readonly string $by;
    public readonly ?string $channel;
    public readonly ?string $resourceId;
    public readonly ?string $resourceType;
    public readonly string $suppliedAt;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->attemptId = ValueHydrator::string($data['attempt_id'] ?? null, true);
        $this->by = ValueHydrator::string($data['by'] ?? null, false);
        $this->channel = ValueHydrator::string($data['channel'] ?? null, true);
        $this->resourceId = ValueHydrator::string($data['resource_id'] ?? null, true);
        $this->resourceType = ValueHydrator::string($data['resource_type'] ?? null, true);
        $this->suppliedAt = ValueHydrator::string($data['supplied_at'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class PaymentMethodTypeSetting extends DomainValue
{
    public readonly ?string $type;
    public readonly ?string $name;
    public readonly ?string $description;
    public readonly bool $enabled;
    public readonly bool $confirmsUse;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->type = ValueHydrator::string($data['type'] ?? null, true);
        $this->name = ValueHydrator::string($data['name'] ?? null, true);
        $this->description = ValueHydrator::string($data['description'] ?? null, true);
        $this->enabled = ValueHydrator::bool($data['enabled'] ?? null, false);
        $this->confirmsUse = ValueHydrator::bool($data['confirms_use'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class PaymentMethodVerification extends DomainValue
{
    public readonly ?string $completedAt;
    public readonly string $initiatedAt;
    public readonly ?string $mechanism;
    public readonly string $requestId;
    public readonly string $type;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->completedAt = ValueHydrator::string($data['completed_at'] ?? null, true);
        $this->initiatedAt = ValueHydrator::string($data['initiated_at'] ?? null, false);
        $this->mechanism = ValueHydrator::string($data['mechanism'] ?? null, true);
        $this->requestId = ValueHydrator::string($data['request_id'] ?? null, false);
        $this->type = ValueHydrator::string($data['type'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class PaymentMethodVerificationSession extends DomainValue
{
    public readonly string $paymentMethodId;
    public readonly string $status;
    public readonly ?string $tokenSentAt;
    public readonly ?string $expiresAt;
    /** @var array<string, mixed>|null */
    public readonly ?array $delivery;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->paymentMethodId = ValueHydrator::string($data['payment_method_id'] ?? null, false);
        $this->status = ValueHydrator::string($data['status'] ?? null, false);
        $this->tokenSentAt = ValueHydrator::string($data['token_sent_at'] ?? null, true);
        $this->expiresAt = ValueHydrator::string($data['expires_at'] ?? null, true);
        $this->delivery = ValueHydrator::array($data['delivery'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class PaymentNextAction extends DomainValue
{
    public readonly string $type;
    public readonly ?PaymentNextActionConfirmPayment $confirmPayment;
    /** @var array<string, mixed>|null */
    public readonly ?array $execute;
    public readonly ?PaymentNextActionRedirect $redirect;
    public readonly ?PaymentNextActionAuthorize $authorize;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->type = ValueHydrator::string($data['type'] ?? null, false);
        $this->confirmPayment = ValueHydrator::object($data['confirm_payment'] ?? null, [PaymentNextActionConfirmPayment::class], true);
        $this->execute = ValueHydrator::array($data['execute'] ?? null, true);
        $this->redirect = ValueHydrator::object($data['redirect'] ?? null, [PaymentNextActionRedirect::class], true);
        $this->authorize = ValueHydrator::object($data['authorize'] ?? null, [PaymentNextActionAuthorize::class], true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class PaymentNextActionAuthorize extends DomainValue
{
    public readonly ?string $beneficiary;
    public readonly ?string $scheme;
    public readonly ?string $expiresAt;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->beneficiary = ValueHydrator::string($data['beneficiary'] ?? null, true);
        $this->scheme = ValueHydrator::string($data['scheme'] ?? null, true);
        $this->expiresAt = ValueHydrator::string($data['expires_at'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class PaymentNextActionConfirmPayment extends DomainValue
{
    public readonly ?string $expiresAt;
    public readonly ?string $scheme;
    public readonly ?PaymentNextActionConfirmPaymentRequest $request;
    public readonly ?PaymentNextActionConfirmPaymentAttempt $attempt;
    public readonly ?bool $confirmed;
    public readonly ?string $status;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->expiresAt = ValueHydrator::string($data['expires_at'] ?? null, true);
        $this->scheme = ValueHydrator::string($data['scheme'] ?? null, true);
        $this->request = ValueHydrator::object($data['request'] ?? null, [PaymentNextActionConfirmPaymentRequest::class], true);
        $this->attempt = ValueHydrator::object($data['attempt'] ?? null, [PaymentNextActionConfirmPaymentAttempt::class], true);
        $this->confirmed = ValueHydrator::bool($data['confirmed'] ?? null, true);
        $this->status = ValueHydrator::string($data['status'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class PaymentNextActionConfirmPaymentAttempt extends DomainValue
{
    public readonly ?string $status;
    public readonly ?bool $confirmed;
    public readonly ?string $reason;
    public readonly ?string $token;
    public readonly ?string $executedAt;
    public readonly ?string $createdAt;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->status = ValueHydrator::string($data['status'] ?? null, true);
        $this->confirmed = ValueHydrator::bool($data['confirmed'] ?? null, true);
        $this->reason = ValueHydrator::string($data['reason'] ?? null, true);
        $this->token = ValueHydrator::string($data['token'] ?? null, true);
        $this->executedAt = ValueHydrator::string($data['executed_at'] ?? null, true);
        $this->createdAt = ValueHydrator::string($data['created_at'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class PaymentNextActionConfirmPaymentRequest extends DomainValue
{
    public readonly ?string $id;
    public readonly ?string $recipient;
    public readonly ?string $sentVia;
    public readonly ?int $tokenSize;
    public readonly ?string $senderId;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->id = ValueHydrator::string($data['id'] ?? null, true);
        $this->recipient = ValueHydrator::string($data['recipient'] ?? null, true);
        $this->sentVia = ValueHydrator::string($data['sent_via'] ?? null, true);
        $this->tokenSize = ValueHydrator::int($data['token_size'] ?? null, true);
        $this->senderId = ValueHydrator::string($data['sender_id'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class PaymentNextActionRedirect extends DomainValue
{
    public readonly ?string $redirectUrl;
    public readonly ?string $validUntil;
    public readonly ?PaymentNextActionRedirectLatestVisit $latestVisit;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->redirectUrl = ValueHydrator::string($data['redirect_url'] ?? null, true);
        $this->validUntil = ValueHydrator::string($data['valid_until'] ?? null, true);
        $this->latestVisit = ValueHydrator::object($data['latest_visit'] ?? null, [PaymentNextActionRedirectLatestVisit::class], true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class PaymentNextActionRedirectLatestVisit extends DomainValue
{
    public readonly ?string $userAgent;
    public readonly ?string $ipAddress;
    public readonly ?string $at;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->userAgent = ValueHydrator::string($data['user_agent'] ?? null, true);
        $this->ipAddress = ValueHydrator::string($data['ip_address'] ?? null, true);
        $this->at = ValueHydrator::string($data['at'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class Payout extends DomainValue
{
    public readonly ?Money $amount;
    /** @var list<string>|null */
    public readonly ?array $balanceTransactions;
    public readonly ?string $canceledAt;
    /** @var array<string, string>|null */
    public readonly ?array $customData;
    public readonly string $destinationId;
    public readonly ?PayoutError $error;
    public readonly string $executeAfter;
    public readonly ?string $executedBy;
    public readonly ?string $expectedAt;
    public readonly ?string $failedAt;
    public readonly string $id;
    public readonly string $initiatedAt;
    public readonly ?string $initiatedBy;
    public readonly Money $maxAmount;
    public readonly ?string $reference;
    public readonly ?string $scheduleId;
    public readonly ?string $scheduledAt;
    public readonly ?string $scheduledBy;
    public readonly ?string $sentAt;
    public readonly ?string $sourceId;
    public readonly string $status;
    public readonly ?string $succeededAt;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->amount = ValueHydrator::object($data['amount'] ?? null, [Money::class], true);
        $this->balanceTransactions = ValueHydrator::array($data['balance_transactions'] ?? null, true);
        $this->canceledAt = ValueHydrator::string($data['canceled_at'] ?? null, true);
        $this->customData = ValueHydrator::array($data['custom_data'] ?? null, true);
        $this->destinationId = ValueHydrator::string($data['destination_id'] ?? null, false);
        $this->error = ValueHydrator::object($data['error'] ?? null, [PayoutError::class], true);
        $this->executeAfter = ValueHydrator::string($data['execute_after'] ?? null, false);
        $this->executedBy = ValueHydrator::string($data['executed_by'] ?? null, true);
        $this->expectedAt = ValueHydrator::string($data['expected_at'] ?? null, true);
        $this->failedAt = ValueHydrator::string($data['failed_at'] ?? null, true);
        $this->id = ValueHydrator::string($data['id'] ?? null, false);
        $this->initiatedAt = ValueHydrator::string($data['initiated_at'] ?? null, false);
        $this->initiatedBy = ValueHydrator::string($data['initiated_by'] ?? null, true);
        $this->maxAmount = ValueHydrator::object($data['max_amount'] ?? null, [Money::class], false);
        $this->reference = ValueHydrator::string($data['reference'] ?? null, true);
        $this->scheduleId = ValueHydrator::string($data['schedule_id'] ?? null, true);
        $this->scheduledAt = ValueHydrator::string($data['scheduled_at'] ?? null, true);
        $this->scheduledBy = ValueHydrator::string($data['scheduled_by'] ?? null, true);
        $this->sentAt = ValueHydrator::string($data['sent_at'] ?? null, true);
        $this->sourceId = ValueHydrator::string($data['source_id'] ?? null, true);
        $this->status = ValueHydrator::string($data['status'] ?? null, false);
        $this->succeededAt = ValueHydrator::string($data['succeeded_at'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class PayoutError extends DomainValue
{
    public readonly string $cause;
    public readonly string $message;
    public readonly string $occurredAt;
    public readonly string $type;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->cause = ValueHydrator::string($data['cause'] ?? null, false);
        $this->message = ValueHydrator::string($data['message'] ?? null, false);
        $this->occurredAt = ValueHydrator::string($data['occurred_at'] ?? null, false);
        $this->type = ValueHydrator::string($data['type'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class PayoutPage extends DomainValue
{
    public readonly int $number;
    public readonly int $size;
    /** @var list<Payout>|null */
    public readonly ?array $payouts;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->number = ValueHydrator::int($data['number'] ?? null, false);
        $this->size = ValueHydrator::int($data['size'] ?? null, false);
        $this->payouts = ValueHydrator::objects($data['payouts'] ?? null, [Payout::class]);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class PayoutSettingsLookup extends DomainValue
{
    /** @var array<string, string> */
    public readonly array $destinations;
    public readonly ?bool $fxEnabled;
    public readonly ?PayoutSettingsLookupSchedule $schedule;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->destinations = ValueHydrator::array($data['destinations'] ?? null, false);
        $this->fxEnabled = ValueHydrator::bool($data['fx_enabled'] ?? null, true);
        $this->schedule = ValueHydrator::object($data['schedule'] ?? null, [PayoutSettingsLookupSchedule::class], true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class PayoutSettingsLookupSchedule extends DomainValue
{
    public readonly PayoutSettingsLookupScheduleAgingSpec $agingSpec;
    public readonly string $description;
    public readonly string $interval;
    public readonly string $name;
    public readonly string $scheduleOn;
    public readonly string $type;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->agingSpec = ValueHydrator::object($data['aging_spec'] ?? null, [PayoutSettingsLookupScheduleAgingSpec::class], false);
        $this->description = ValueHydrator::string($data['description'] ?? null, false);
        $this->interval = ValueHydrator::string($data['interval'] ?? null, false);
        $this->name = ValueHydrator::string($data['name'] ?? null, false);
        $this->scheduleOn = ValueHydrator::string($data['schedule_on'] ?? null, false);
        $this->type = ValueHydrator::string($data['type'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class PayoutSettingsLookupScheduleAgingSpec extends DomainValue
{
    public readonly string $abide;
    public readonly string $label;
    public readonly string $tPlus;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->abide = ValueHydrator::string($data['abide'] ?? null, false);
        $this->label = ValueHydrator::string($data['label'] ?? null, false);
        $this->tPlus = ValueHydrator::string($data['t_plus'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class PayoutSettingsMutation extends DomainValue
{
    /** @var array<string, string>|null */
    public readonly ?array $destinations;
    public readonly ?string $id;
    public readonly ?PayoutSettingsMutationSchedule $schedule;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->destinations = ValueHydrator::array($data['destinations'] ?? null, true);
        $this->id = ValueHydrator::string($data['id'] ?? null, true);
        $this->schedule = ValueHydrator::object($data['schedule'] ?? null, [PayoutSettingsMutationSchedule::class], true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class PayoutSettingsMutationSchedule extends DomainValue
{
    public readonly string $description;
    public readonly string $id;
    public readonly string $interval;
    public readonly string $name;
    public readonly string $scheduleOn;
    public readonly PayoutSettingsMutationScheduleSpec $spec;
    public readonly string $type;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->description = ValueHydrator::string($data['description'] ?? null, false);
        $this->id = ValueHydrator::string($data['id'] ?? null, false);
        $this->interval = ValueHydrator::string($data['interval'] ?? null, false);
        $this->name = ValueHydrator::string($data['name'] ?? null, false);
        $this->scheduleOn = ValueHydrator::string($data['schedule_on'] ?? null, false);
        $this->spec = ValueHydrator::object($data['spec'] ?? null, [PayoutSettingsMutationScheduleSpec::class], false);
        $this->type = ValueHydrator::string($data['type'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class PayoutSettingsMutationScheduleSpec extends DomainValue
{
    public readonly string $abide;
    public readonly string $id;
    public readonly string $label;
    public readonly string $tPlus;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->abide = ValueHydrator::string($data['abide'] ?? null, false);
        $this->id = ValueHydrator::string($data['id'] ?? null, false);
        $this->label = ValueHydrator::string($data['label'] ?? null, false);
        $this->tPlus = ValueHydrator::string($data['t_plus'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class Price extends DomainValue
{
    public readonly string $id;
    public readonly ?string $label;
    public readonly ?string $about;
    public readonly bool $active;
    public readonly PriceNominal $nominal;
    public readonly ?PriceEmbeddedProduct $product;
    public readonly string $createdAt;
    public readonly ?string $updatedAt;
    public readonly ?string $archivedAt;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->id = ValueHydrator::string($data['id'] ?? null, false);
        $this->label = ValueHydrator::string($data['label'] ?? null, true);
        $this->about = ValueHydrator::string($data['about'] ?? null, true);
        $this->active = ValueHydrator::bool($data['active'] ?? null, false);
        $this->nominal = ValueHydrator::object($data['nominal'] ?? null, [PriceNominal::class], false);
        $this->product = ValueHydrator::object($data['product'] ?? null, [PriceEmbeddedProduct::class], true);
        $this->createdAt = ValueHydrator::string($data['created_at'] ?? null, false);
        $this->updatedAt = ValueHydrator::string($data['updated_at'] ?? null, true);
        $this->archivedAt = ValueHydrator::string($data['archived_at'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class PriceEmbeddedProduct extends DomainValue
{
    public readonly string $id;
    public readonly ?string $about;
    public readonly bool $active;
    public readonly ?string $archivedAt;
    /** @var list<PriceEmbeddedProductAttributesItem>|null */
    public readonly ?array $attributes;
    public readonly ?string $category;
    public readonly string $createdAt;
    /** @var array<string, string>|null */
    public readonly ?array $customData;
    public readonly ?string $description;
    /** @var array<string, mixed>|null */
    public readonly ?array $dimensions;
    /** @var array<string, mixed>|null */
    public readonly ?array $media;
    public readonly string $name;
    public readonly ?string $publishedAt;
    public readonly ?string $reference;
    /** @var array<string, mixed>|null */
    public readonly ?array $shipment;
    public readonly ?string $taxCode;
    public readonly string $type;
    public readonly ?string $unitDim;
    public readonly ?string $updatedAt;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->id = ValueHydrator::string($data['id'] ?? null, false);
        $this->about = ValueHydrator::string($data['about'] ?? null, true);
        $this->active = ValueHydrator::bool($data['active'] ?? null, false);
        $this->archivedAt = ValueHydrator::string($data['archived_at'] ?? null, true);
        $this->attributes = ValueHydrator::objects($data['attributes'] ?? null, [PriceEmbeddedProductAttributesItem::class]);
        $this->category = ValueHydrator::string($data['category'] ?? null, true);
        $this->createdAt = ValueHydrator::string($data['created_at'] ?? null, false);
        $this->customData = ValueHydrator::array($data['custom_data'] ?? null, true);
        $this->description = ValueHydrator::string($data['description'] ?? null, true);
        $this->dimensions = ValueHydrator::array($data['dimensions'] ?? null, true);
        $this->media = ValueHydrator::array($data['media'] ?? null, true);
        $this->name = ValueHydrator::string($data['name'] ?? null, false);
        $this->publishedAt = ValueHydrator::string($data['published_at'] ?? null, true);
        $this->reference = ValueHydrator::string($data['reference'] ?? null, true);
        $this->shipment = ValueHydrator::array($data['shipment'] ?? null, true);
        $this->taxCode = ValueHydrator::string($data['tax_code'] ?? null, true);
        $this->type = ValueHydrator::string($data['type'] ?? null, false);
        $this->unitDim = ValueHydrator::string($data['unit_dim'] ?? null, true);
        $this->updatedAt = ValueHydrator::string($data['updated_at'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class PriceEmbeddedProductAttributesItem extends DomainValue
{
    public readonly string $name;
    public readonly string $value;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->name = ValueHydrator::string($data['name'] ?? null, false);
        $this->value = ValueHydrator::string($data['value'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class PriceNominal extends DomainValue
{
    public readonly string $currency;
    public readonly int $value;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->currency = ValueHydrator::string($data['currency'] ?? null, false);
        $this->value = ValueHydrator::int($data['value'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class PricePage extends DomainValue
{
    public readonly ?int $number;
    public readonly ?int $size;
    /** @var list<Price>|null */
    public readonly ?array $prices;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->number = ValueHydrator::int($data['number'] ?? null, true);
        $this->size = ValueHydrator::int($data['size'] ?? null, true);
        $this->prices = ValueHydrator::objects($data['prices'] ?? null, [Price::class]);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class Product extends DomainValue
{
    public readonly string $id;
    public readonly string $type;
    public readonly ?string $reference;
    public readonly string $name;
    public readonly ?string $description;
    public readonly ?string $about;
    public readonly ?string $taxCode;
    public readonly ?string $category;
    /** @var list<ProductPriceSummary>|null */
    public readonly ?array $prices;
    public readonly ?ProductShipment $shipment;
    public readonly ?ProductMedia $media;
    /** @var list<ProductAttribute>|null */
    public readonly ?array $attributes;
    public readonly ?ProductDimensions $dimensions;
    /** @var array<string, string>|null */
    public readonly ?array $customData;
    public readonly bool $active;
    public readonly string $createdAt;
    public readonly ?string $updatedAt;
    public readonly ?string $archivedAt;
    public readonly ?string $publishedAt;
    public readonly ?string $unitDim;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->id = ValueHydrator::string($data['id'] ?? null, false);
        $this->type = ValueHydrator::string($data['type'] ?? null, false);
        $this->reference = ValueHydrator::string($data['reference'] ?? null, true);
        $this->name = ValueHydrator::string($data['name'] ?? null, false);
        $this->description = ValueHydrator::string($data['description'] ?? null, true);
        $this->about = ValueHydrator::string($data['about'] ?? null, true);
        $this->taxCode = ValueHydrator::string($data['tax_code'] ?? null, true);
        $this->category = ValueHydrator::string($data['category'] ?? null, true);
        $this->prices = ValueHydrator::objects($data['prices'] ?? null, [ProductPriceSummary::class]);
        $this->shipment = ValueHydrator::object($data['shipment'] ?? null, [ProductShipment::class], true);
        $this->media = ValueHydrator::object($data['media'] ?? null, [ProductMedia::class], true);
        $this->attributes = ValueHydrator::objects($data['attributes'] ?? null, [ProductAttribute::class]);
        $this->dimensions = ValueHydrator::object($data['dimensions'] ?? null, [ProductDimensions::class], true);
        $this->customData = ValueHydrator::array($data['custom_data'] ?? null, true);
        $this->active = ValueHydrator::bool($data['active'] ?? null, false);
        $this->createdAt = ValueHydrator::string($data['created_at'] ?? null, false);
        $this->updatedAt = ValueHydrator::string($data['updated_at'] ?? null, true);
        $this->archivedAt = ValueHydrator::string($data['archived_at'] ?? null, true);
        $this->publishedAt = ValueHydrator::string($data['published_at'] ?? null, true);
        $this->unitDim = ValueHydrator::string($data['unit_dim'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class ProductAttribute extends DomainValue
{
    public readonly string $name;
    public readonly string $value;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->name = ValueHydrator::string($data['name'] ?? null, false);
        $this->value = ValueHydrator::string($data['value'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class ProductDimensions extends DomainValue
{
    public readonly ?ProductDimensionsPhysical $physical;
    public readonly ?ProductDimensionsDigital $digital;
    public readonly ?ProductDimensionsCustom $custom;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->physical = ValueHydrator::object($data['physical'] ?? null, [ProductDimensionsPhysical::class], true);
        $this->digital = ValueHydrator::object($data['digital'] ?? null, [ProductDimensionsDigital::class], true);
        $this->custom = ValueHydrator::object($data['custom'] ?? null, [ProductDimensionsCustom::class], true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class ProductDimensionsCustom extends DomainValue
{
    public readonly ?string $sizeUnit;
    public readonly ?float $size;
    /** @var array<string, string>|null */
    public readonly ?array $details;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->sizeUnit = ValueHydrator::string($data['size_unit'] ?? null, true);
        $this->size = ValueHydrator::float($data['size'] ?? null, true);
        $this->details = ValueHydrator::array($data['details'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class ProductDimensionsDigital extends DomainValue
{
    public readonly ?float $bytes;
    public readonly ?string $sizeUnit;
    public readonly ?float $size;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->bytes = ValueHydrator::float($data['bytes'] ?? null, true);
        $this->sizeUnit = ValueHydrator::string($data['size_unit'] ?? null, true);
        $this->size = ValueHydrator::float($data['size'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class ProductDimensionsPhysical extends DomainValue
{
    public readonly ?string $weightUnit;
    public readonly ?float $weight;
    public readonly ?float $size;
    public readonly ?string $volumeUnit;
    public readonly ?float $volume;
    public readonly ?float $length;
    public readonly ?float $height;
    public readonly ?float $width;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->weightUnit = ValueHydrator::string($data['weight_unit'] ?? null, true);
        $this->weight = ValueHydrator::float($data['weight'] ?? null, true);
        $this->size = ValueHydrator::float($data['size'] ?? null, true);
        $this->volumeUnit = ValueHydrator::string($data['volume_unit'] ?? null, true);
        $this->volume = ValueHydrator::float($data['volume'] ?? null, true);
        $this->length = ValueHydrator::float($data['length'] ?? null, true);
        $this->height = ValueHydrator::float($data['height'] ?? null, true);
        $this->width = ValueHydrator::float($data['width'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class ProductMedia extends DomainValue
{
    public readonly ?string $heroImage;
    public readonly ?string $thumbnail;
    public readonly ?string $webPageUrl;
    public readonly ?string $brandLogo;
    public readonly ?string $infographic;
    public readonly ?string $promoVideo;
    public readonly ?string $demoVideo;
    /** @var list<string>|null */
    public readonly ?array $gallery;
    /** @var list<string>|null */
    public readonly ?array $downloads;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->heroImage = ValueHydrator::string($data['hero_image'] ?? null, true);
        $this->thumbnail = ValueHydrator::string($data['thumbnail'] ?? null, true);
        $this->webPageUrl = ValueHydrator::string($data['web_page_url'] ?? null, true);
        $this->brandLogo = ValueHydrator::string($data['brand_logo'] ?? null, true);
        $this->infographic = ValueHydrator::string($data['infographic'] ?? null, true);
        $this->promoVideo = ValueHydrator::string($data['promo_video'] ?? null, true);
        $this->demoVideo = ValueHydrator::string($data['demo_video'] ?? null, true);
        $this->gallery = ValueHydrator::array($data['gallery'] ?? null, true);
        $this->downloads = ValueHydrator::array($data['downloads'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class ProductPage extends DomainValue
{
    public readonly ?int $number;
    public readonly ?int $size;
    /** @var list<Product>|null */
    public readonly ?array $products;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->number = ValueHydrator::int($data['number'] ?? null, true);
        $this->size = ValueHydrator::int($data['size'] ?? null, true);
        $this->products = ValueHydrator::objects($data['products'] ?? null, [Product::class]);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class ProductPriceNominal extends DomainValue
{
    public readonly string $id;
    public readonly ?string $productId;
    public readonly ?string $label;
    public readonly ?string $about;
    public readonly bool $active;
    public readonly ProductPriceNominalNominal $nominal;
    public readonly string $createdAt;
    public readonly ?string $updatedAt;
    public readonly ?string $archivedAt;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->id = ValueHydrator::string($data['id'] ?? null, false);
        $this->productId = ValueHydrator::string($data['product_id'] ?? null, true);
        $this->label = ValueHydrator::string($data['label'] ?? null, true);
        $this->about = ValueHydrator::string($data['about'] ?? null, true);
        $this->active = ValueHydrator::bool($data['active'] ?? null, false);
        $this->nominal = ValueHydrator::object($data['nominal'] ?? null, [ProductPriceNominalNominal::class], false);
        $this->createdAt = ValueHydrator::string($data['created_at'] ?? null, false);
        $this->updatedAt = ValueHydrator::string($data['updated_at'] ?? null, true);
        $this->archivedAt = ValueHydrator::string($data['archived_at'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class ProductPriceNominalNominal extends DomainValue
{
    public readonly string $currency;
    public readonly int $value;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->currency = ValueHydrator::string($data['currency'] ?? null, false);
        $this->value = ValueHydrator::int($data['value'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class ProductPriceSummary extends DomainValue
{
    public readonly string $id;
    public readonly bool $active;
    public readonly ?string $label;
    public readonly ProductPriceSummaryNominal $nominal;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->id = ValueHydrator::string($data['id'] ?? null, false);
        $this->active = ValueHydrator::bool($data['active'] ?? null, false);
        $this->label = ValueHydrator::string($data['label'] ?? null, true);
        $this->nominal = ValueHydrator::object($data['nominal'] ?? null, [ProductPriceSummaryNominal::class], false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class ProductPriceSummaryNominal extends DomainValue
{
    public readonly string $currency;
    public readonly int $value;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->currency = ValueHydrator::string($data['currency'] ?? null, false);
        $this->value = ValueHydrator::int($data['value'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class ProductShipment extends DomainValue
{
    public readonly string $type;
    /** @var array<string, mixed>|null */
    public readonly ?array $delivery;
    /** @var array<string, mixed>|null */
    public readonly ?array $download;
    /** @var array<string, mixed>|null */
    public readonly ?array $render;
    /** @var array<string, mixed>|null */
    public readonly ?array $service;
    /** @var array<string, mixed>|null */
    public readonly ?array $stream;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->type = ValueHydrator::string($data['type'] ?? null, false);
        $this->delivery = ValueHydrator::array($data['delivery'] ?? null, true);
        $this->download = ValueHydrator::array($data['download'] ?? null, true);
        $this->render = ValueHydrator::array($data['render'] ?? null, true);
        $this->service = ValueHydrator::array($data['service'] ?? null, true);
        $this->stream = ValueHydrator::array($data['stream'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class PublicFileStorage extends DomainValue
{
    public readonly string $encoding;
    public readonly int $storedSize;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->encoding = ValueHydrator::string($data['encoding'] ?? null, false);
        $this->storedSize = ValueHydrator::int($data['stored_size'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class PurchaseIntent extends DomainValue
{
    public readonly ?PurchaseIntentActivity $activity;
    public readonly bool $allowVariants;
    public readonly string $applicationId;
    public readonly string $createdAt;
    public readonly ?string $expiresAt;
    public readonly string $id;
    public readonly ?string $inactiveAt;
    public readonly ?PurchaseIntentMerchant $merchant;
    public readonly ?PurchaseIntentPrice $price;
    public readonly ?PurchaseIntentProduct $product;
    public readonly PurchaseIntentQuantity $quantity;
    public readonly string $status;
    public readonly ?string $updatedAt;
    public readonly PurchaseIntentUsage $usage;
    public readonly ?PurchaseIntentVariantSet $variantSet;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->activity = ValueHydrator::object($data['activity'] ?? null, [PurchaseIntentActivity::class], true);
        $this->allowVariants = ValueHydrator::bool($data['allow_variants'] ?? null, false);
        $this->applicationId = ValueHydrator::string($data['application_id'] ?? null, false);
        $this->createdAt = ValueHydrator::string($data['created_at'] ?? null, false);
        $this->expiresAt = ValueHydrator::string($data['expires_at'] ?? null, true);
        $this->id = ValueHydrator::string($data['id'] ?? null, false);
        $this->inactiveAt = ValueHydrator::string($data['inactive_at'] ?? null, true);
        $this->merchant = ValueHydrator::object($data['merchant'] ?? null, [PurchaseIntentMerchant::class], true);
        $this->price = ValueHydrator::object($data['price'] ?? null, [PurchaseIntentPrice::class], true);
        $this->product = ValueHydrator::object($data['product'] ?? null, [PurchaseIntentProduct::class], true);
        $this->quantity = ValueHydrator::object($data['quantity'] ?? null, [PurchaseIntentQuantity::class], false);
        $this->status = ValueHydrator::string($data['status'] ?? null, false);
        $this->updatedAt = ValueHydrator::string($data['updated_at'] ?? null, true);
        $this->usage = ValueHydrator::object($data['usage'] ?? null, [PurchaseIntentUsage::class], false);
        $this->variantSet = ValueHydrator::object($data['variant_set'] ?? null, [PurchaseIntentVariantSet::class], true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class PurchaseIntentActivity extends DomainValue
{
    /** @var list<PurchaseIntentActivity>|null */
    public readonly ?array $recent;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->recent = ValueHydrator::objects($data['recent'] ?? null, [PurchaseIntentActivity::class]);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class PurchaseIntentMerchant extends DomainValue
{
    public readonly ?string $appId;
    public readonly ?string $appName;
    public readonly ?string $organizationId;
    public readonly ?string $organizationName;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->appId = ValueHydrator::string($data['app_id'] ?? null, true);
        $this->appName = ValueHydrator::string($data['app_name'] ?? null, true);
        $this->organizationId = ValueHydrator::string($data['organization_id'] ?? null, true);
        $this->organizationName = ValueHydrator::string($data['organization_name'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class PurchaseIntentMoney extends DomainValue
{
    public readonly string $currency;
    public readonly int $value;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->currency = ValueHydrator::string($data['currency'] ?? null, false);
        $this->value = ValueHydrator::int($data['value'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class PurchaseIntentOriginalPrice extends DomainValue
{
    public readonly bool $active;
    public readonly ?string $id;
    public readonly ?string $label;
    public readonly PurchaseIntentMoney $nominal;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->active = ValueHydrator::bool($data['active'] ?? null, false);
        $this->id = ValueHydrator::string($data['id'] ?? null, true);
        $this->label = ValueHydrator::string($data['label'] ?? null, true);
        $this->nominal = ValueHydrator::object($data['nominal'] ?? null, [PurchaseIntentMoney::class], false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class PurchaseIntentPage extends DomainValue
{
    public readonly int $number;
    /** @var list<PurchaseIntent> */
    public readonly array $purchaseIntents;
    public readonly int $size;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->number = ValueHydrator::int($data['number'] ?? null, false);
        $this->purchaseIntents = ValueHydrator::objects($data['purchase_intents'] ?? null, [PurchaseIntent::class]);
        $this->size = ValueHydrator::int($data['size'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class PurchaseIntentPrice extends DomainValue
{
    public readonly bool $active;
    public readonly ?string $id;
    public readonly ?string $label;
    public readonly PurchaseIntentMoney $nominal;
    public readonly ?PurchaseIntentOriginalPrice $original;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->active = ValueHydrator::bool($data['active'] ?? null, false);
        $this->id = ValueHydrator::string($data['id'] ?? null, true);
        $this->label = ValueHydrator::string($data['label'] ?? null, true);
        $this->nominal = ValueHydrator::object($data['nominal'] ?? null, [PurchaseIntentMoney::class], false);
        $this->original = ValueHydrator::object($data['original'] ?? null, [PurchaseIntentOriginalPrice::class], true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class PurchaseIntentProduct extends DomainValue
{
    public readonly string $id;
    public readonly ?string $about;
    public readonly bool $active;
    public readonly ?string $archivedAt;
    /** @var list<PurchaseIntentProductAttributesItem>|null */
    public readonly ?array $attributes;
    public readonly ?string $category;
    public readonly string $createdAt;
    /** @var array<string, string>|null */
    public readonly ?array $customData;
    public readonly ?string $description;
    /** @var array<string, mixed>|null */
    public readonly ?array $dimensions;
    /** @var array<string, mixed>|null */
    public readonly ?array $media;
    public readonly string $name;
    public readonly ?string $publishedAt;
    public readonly ?string $reference;
    /** @var array<string, mixed>|null */
    public readonly ?array $shipment;
    public readonly ?string $taxCode;
    public readonly string $type;
    public readonly ?string $unitDim;
    public readonly ?string $updatedAt;
    /** @var list<ProductPriceSummary>|null */
    public readonly ?array $prices;
    public readonly ?string $variantSetId;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->id = ValueHydrator::string($data['id'] ?? null, false);
        $this->about = ValueHydrator::string($data['about'] ?? null, true);
        $this->active = ValueHydrator::bool($data['active'] ?? null, false);
        $this->archivedAt = ValueHydrator::string($data['archived_at'] ?? null, true);
        $this->attributes = ValueHydrator::objects($data['attributes'] ?? null, [PurchaseIntentProductAttributesItem::class]);
        $this->category = ValueHydrator::string($data['category'] ?? null, true);
        $this->createdAt = ValueHydrator::string($data['created_at'] ?? null, false);
        $this->customData = ValueHydrator::array($data['custom_data'] ?? null, true);
        $this->description = ValueHydrator::string($data['description'] ?? null, true);
        $this->dimensions = ValueHydrator::array($data['dimensions'] ?? null, true);
        $this->media = ValueHydrator::array($data['media'] ?? null, true);
        $this->name = ValueHydrator::string($data['name'] ?? null, false);
        $this->publishedAt = ValueHydrator::string($data['published_at'] ?? null, true);
        $this->reference = ValueHydrator::string($data['reference'] ?? null, true);
        $this->shipment = ValueHydrator::array($data['shipment'] ?? null, true);
        $this->taxCode = ValueHydrator::string($data['tax_code'] ?? null, true);
        $this->type = ValueHydrator::string($data['type'] ?? null, false);
        $this->unitDim = ValueHydrator::string($data['unit_dim'] ?? null, true);
        $this->updatedAt = ValueHydrator::string($data['updated_at'] ?? null, true);
        $this->prices = ValueHydrator::objects($data['prices'] ?? null, [ProductPriceSummary::class]);
        $this->variantSetId = ValueHydrator::string($data['variant_set_id'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class PurchaseIntentProductAttributesItem extends DomainValue
{
    public readonly string $name;
    public readonly string $value;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->name = ValueHydrator::string($data['name'] ?? null, false);
        $this->value = ValueHydrator::string($data['value'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class PurchaseIntentQuantity extends DomainValue
{
    public readonly int $min;
    public readonly ?int $max;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->min = ValueHydrator::int($data['min'] ?? null, false);
        $this->max = ValueHydrator::int($data['max'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class PurchaseIntentUsage extends DomainValue
{
    public readonly ?bool $multiUse;
    public readonly ?PurchaseIntentUsageOrder $order;
    public readonly ?bool $singleUse;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->multiUse = ValueHydrator::bool($data['multi_use'] ?? null, true);
        $this->order = ValueHydrator::object($data['order'] ?? null, [PurchaseIntentUsageOrder::class], true);
        $this->singleUse = ValueHydrator::bool($data['single_use'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class PurchaseIntentUsageOrder extends DomainValue
{
    public readonly string $createdAt;
    public readonly string $id;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->createdAt = ValueHydrator::string($data['created_at'] ?? null, false);
        $this->id = ValueHydrator::string($data['id'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class PurchaseIntentVariant extends DomainValue
{
    public readonly bool $active;
    public readonly ?int $position;
    public readonly ?PurchaseIntentPrice $price;
    public readonly ?PurchaseIntentProduct $product;
    public readonly string $productId;
    /** @var array<string, string> */
    public readonly array $variantValues;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->active = ValueHydrator::bool($data['active'] ?? null, false);
        $this->position = ValueHydrator::int($data['position'] ?? null, true);
        $this->price = ValueHydrator::object($data['price'] ?? null, [PurchaseIntentPrice::class], true);
        $this->product = ValueHydrator::object($data['product'] ?? null, [PurchaseIntentProduct::class], true);
        $this->productId = ValueHydrator::string($data['product_id'] ?? null, false);
        $this->variantValues = ValueHydrator::array($data['variant_values'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class PurchaseIntentVariantAxis extends DomainValue
{
    public readonly string $key;
    public readonly string $label;
    public readonly int $position;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->key = ValueHydrator::string($data['key'] ?? null, false);
        $this->label = ValueHydrator::string($data['label'] ?? null, false);
        $this->position = ValueHydrator::int($data['position'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class PurchaseIntentVariantSet extends DomainValue
{
    public readonly bool $active;
    public readonly ?string $defaultProductId;
    public readonly ?string $description;
    public readonly string $id;
    public readonly string $name;
    public readonly ?string $reference;
    /** @var list<PurchaseIntentVariantAxis> */
    public readonly array $variantAxes;
    /** @var list<PurchaseIntentVariant> */
    public readonly array $variants;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->active = ValueHydrator::bool($data['active'] ?? null, false);
        $this->defaultProductId = ValueHydrator::string($data['default_product_id'] ?? null, true);
        $this->description = ValueHydrator::string($data['description'] ?? null, true);
        $this->id = ValueHydrator::string($data['id'] ?? null, false);
        $this->name = ValueHydrator::string($data['name'] ?? null, false);
        $this->reference = ValueHydrator::string($data['reference'] ?? null, true);
        $this->variantAxes = ValueHydrator::objects($data['variant_axes'] ?? null, [PurchaseIntentVariantAxis::class]);
        $this->variants = ValueHydrator::objects($data['variants'] ?? null, [PurchaseIntentVariant::class]);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class Refund extends DomainValue
{
    public readonly ?string $canceledAt;
    public readonly string $createdAt;
    /** @var array<string, string>|null */
    public readonly ?array $customData;
    public readonly ?string $failedAt;
    public readonly string $id;
    /** @var list<RefundLineItem> */
    public readonly array $lineItems;
    public readonly string $orderId;
    public readonly ?string $processingAt;
    public readonly GenericValue $reason;
    public readonly ?string $reasonDetails;
    public readonly ?string $reference;
    public readonly string $status;
    public readonly ?string $succeededAt;
    public readonly RefundMoney $total;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->canceledAt = ValueHydrator::string($data['canceled_at'] ?? null, true);
        $this->createdAt = ValueHydrator::string($data['created_at'] ?? null, false);
        $this->customData = ValueHydrator::array($data['custom_data'] ?? null, true);
        $this->failedAt = ValueHydrator::string($data['failed_at'] ?? null, true);
        $this->id = ValueHydrator::string($data['id'] ?? null, false);
        $this->lineItems = ValueHydrator::objects($data['line_items'] ?? null, [RefundLineItem::class]);
        $this->orderId = ValueHydrator::string($data['order_id'] ?? null, false);
        $this->processingAt = ValueHydrator::string($data['processing_at'] ?? null, true);
        $this->reason = ValueHydrator::object($data['reason'] ?? null, [GenericValue::class], false);
        $this->reasonDetails = ValueHydrator::string($data['reason_details'] ?? null, true);
        $this->reference = ValueHydrator::string($data['reference'] ?? null, true);
        $this->status = ValueHydrator::string($data['status'] ?? null, false);
        $this->succeededAt = ValueHydrator::string($data['succeeded_at'] ?? null, true);
        $this->total = ValueHydrator::object($data['total'] ?? null, [RefundMoney::class], false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class RefundLineItem extends DomainValue
{
    public readonly string $id;
    public readonly string $orderLineItemId;
    public readonly RefundMoney $originalAmountPaid;
    public readonly ?GenericValue $reason;
    public readonly ?string $reasonDetails;
    public readonly RefundMoney $refundAmount;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->id = ValueHydrator::string($data['id'] ?? null, false);
        $this->orderLineItemId = ValueHydrator::string($data['order_line_item_id'] ?? null, false);
        $this->originalAmountPaid = ValueHydrator::object($data['original_amount_paid'] ?? null, [RefundMoney::class], false);
        $this->reason = ValueHydrator::object($data['reason'] ?? null, [GenericValue::class], true);
        $this->reasonDetails = ValueHydrator::string($data['reason_details'] ?? null, true);
        $this->refundAmount = ValueHydrator::object($data['refund_amount'] ?? null, [RefundMoney::class], false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class RefundMoney extends DomainValue
{
    public readonly string $currency;
    public readonly int $value;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->currency = ValueHydrator::string($data['currency'] ?? null, false);
        $this->value = ValueHydrator::int($data['value'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class RefundPage extends DomainValue
{
    public readonly int $number;
    /** @var list<Refund> */
    public readonly array $refunds;
    public readonly int $size;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->number = ValueHydrator::int($data['number'] ?? null, false);
        $this->refunds = ValueHydrator::objects($data['refunds'] ?? null, [Refund::class]);
        $this->size = ValueHydrator::int($data['size'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class RenderedEmailMessageTemplate extends DomainValue
{
    public readonly string $subject;
    public readonly string $text;
    public readonly ?string $html;
    public readonly ?MessageTemplateMailbox $from;
    public readonly ?MessageTemplateMailbox $replyTo;
    /** @var array<string, string>|null */
    public readonly ?array $headers;
    public readonly ?MessageTemplateSafetyResult $safety;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->subject = ValueHydrator::string($data['subject'] ?? null, false);
        $this->text = ValueHydrator::string($data['text'] ?? null, false);
        $this->html = ValueHydrator::string($data['html'] ?? null, true);
        $this->from = ValueHydrator::object($data['from_'] ?? null, [MessageTemplateMailbox::class], true);
        $this->replyTo = ValueHydrator::object($data['reply_to'] ?? null, [MessageTemplateMailbox::class], true);
        $this->headers = ValueHydrator::array($data['headers'] ?? null, true);
        $this->safety = ValueHydrator::object($data['safety'] ?? null, [MessageTemplateSafetyResult::class], true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class RenderedMessageTemplate extends DomainValue
{
    public readonly string $channel;
    public readonly ?GenericValue $attachments;
    public readonly ?RenderedSMSMessageTemplate $sms;
    public readonly ?RenderedEmailMessageTemplate $email;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->channel = ValueHydrator::string($data['channel'] ?? null, false);
        $this->attachments = ValueHydrator::object($data['attachments'] ?? null, [GenericValue::class], true);
        $this->sms = ValueHydrator::object($data['sms'] ?? null, [RenderedSMSMessageTemplate::class], true);
        $this->email = ValueHydrator::object($data['email'] ?? null, [RenderedEmailMessageTemplate::class], true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class RenderedSMSMessageTemplate extends DomainValue
{
    public readonly string $fullMessage;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->fullMessage = ValueHydrator::string($data['full_message'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class ResourceSupply extends DomainValue
{
    public readonly ?string $attemptId;
    public readonly string $by;
    public readonly ?string $channel;
    public readonly ?string $resourceId;
    public readonly ?string $resourceType;
    public readonly string $suppliedAt;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->attemptId = ValueHydrator::string($data['attempt_id'] ?? null, true);
        $this->by = ValueHydrator::string($data['by'] ?? null, false);
        $this->channel = ValueHydrator::string($data['channel'] ?? null, true);
        $this->resourceId = ValueHydrator::string($data['resource_id'] ?? null, true);
        $this->resourceType = ValueHydrator::string($data['resource_type'] ?? null, true);
        $this->suppliedAt = ValueHydrator::string($data['supplied_at'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class ScheduleCancelDetail extends DomainValue
{
    /** @var list<string>|null */
    public readonly ?array $chimeIds;
    public readonly string $content;
    public readonly string $createdAt;
    /** @var list<string>|null */
    public readonly ?array $customerIds;
    public readonly ?ChimeEmailMessage $email;
    /** @var list<ScheduleError>|null */
    public readonly ?array $errors;
    public readonly ?string $executedAt;
    public readonly string $id;
    public readonly ?string $idempotencyKey;
    public readonly ?string $purpose;
    /** @var list<string> */
    public readonly array $recipients;
    public readonly string $sendAfter;
    public readonly string $senderId;
    public readonly ?string $canceledAt;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->chimeIds = ValueHydrator::array($data['chime_ids'] ?? null, true);
        $this->content = ValueHydrator::string($data['content'] ?? null, false);
        $this->createdAt = ValueHydrator::string($data['created_at'] ?? null, false);
        $this->customerIds = ValueHydrator::array($data['customer_ids'] ?? null, true);
        $this->email = ValueHydrator::object($data['email'] ?? null, [ChimeEmailMessage::class], true);
        $this->errors = ValueHydrator::objects($data['errors'] ?? null, [ScheduleError::class]);
        $this->executedAt = ValueHydrator::string($data['executed_at'] ?? null, true);
        $this->id = ValueHydrator::string($data['id'] ?? null, false);
        $this->idempotencyKey = ValueHydrator::string($data['idempotency_key'] ?? null, true);
        $this->purpose = ValueHydrator::string($data['purpose'] ?? null, true);
        $this->recipients = ValueHydrator::array($data['recipients'] ?? null, false);
        $this->sendAfter = ValueHydrator::string($data['send_after'] ?? null, false);
        $this->senderId = ValueHydrator::string($data['sender_id'] ?? null, false);
        $this->canceledAt = ValueHydrator::string($data['canceled_at'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class ScheduleCreationDetail extends DomainValue
{
    public readonly string $createdAt;
    /** @var list<string>|null */
    public readonly ?array $customerIds;
    public readonly ?ChimeEmailMessage $email;
    public readonly ?string $executedAt;
    public readonly string $fullMessage;
    public readonly string $id;
    public readonly ?string $idempotencyKey;
    public readonly ?string $purpose;
    /** @var list<string>|null */
    public readonly ?array $recipients;
    public readonly string $sendAfter;
    public readonly string $senderId;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->createdAt = ValueHydrator::string($data['created_at'] ?? null, false);
        $this->customerIds = ValueHydrator::array($data['customer_ids'] ?? null, true);
        $this->email = ValueHydrator::object($data['email'] ?? null, [ChimeEmailMessage::class], true);
        $this->executedAt = ValueHydrator::string($data['executed_at'] ?? null, true);
        $this->fullMessage = ValueHydrator::string($data['full_message'] ?? null, false);
        $this->id = ValueHydrator::string($data['id'] ?? null, false);
        $this->idempotencyKey = ValueHydrator::string($data['idempotency_key'] ?? null, true);
        $this->purpose = ValueHydrator::string($data['purpose'] ?? null, true);
        $this->recipients = ValueHydrator::array($data['recipients'] ?? null, true);
        $this->sendAfter = ValueHydrator::string($data['send_after'] ?? null, false);
        $this->senderId = ValueHydrator::string($data['sender_id'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class ScheduleDetail extends DomainValue
{
    /** @var list<string>|null */
    public readonly ?array $chimeIds;
    public readonly string $content;
    public readonly string $createdAt;
    /** @var list<string>|null */
    public readonly ?array $customerIds;
    public readonly ?ChimeEmailMessage $email;
    /** @var list<ScheduleError>|null */
    public readonly ?array $errors;
    public readonly ?string $executedAt;
    public readonly string $id;
    public readonly ?string $idempotencyKey;
    public readonly ?string $purpose;
    /** @var list<string> */
    public readonly array $recipients;
    public readonly string $sendAfter;
    public readonly string $senderId;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->chimeIds = ValueHydrator::array($data['chime_ids'] ?? null, true);
        $this->content = ValueHydrator::string($data['content'] ?? null, false);
        $this->createdAt = ValueHydrator::string($data['created_at'] ?? null, false);
        $this->customerIds = ValueHydrator::array($data['customer_ids'] ?? null, true);
        $this->email = ValueHydrator::object($data['email'] ?? null, [ChimeEmailMessage::class], true);
        $this->errors = ValueHydrator::objects($data['errors'] ?? null, [ScheduleError::class]);
        $this->executedAt = ValueHydrator::string($data['executed_at'] ?? null, true);
        $this->id = ValueHydrator::string($data['id'] ?? null, false);
        $this->idempotencyKey = ValueHydrator::string($data['idempotency_key'] ?? null, true);
        $this->purpose = ValueHydrator::string($data['purpose'] ?? null, true);
        $this->recipients = ValueHydrator::array($data['recipients'] ?? null, false);
        $this->sendAfter = ValueHydrator::string($data['send_after'] ?? null, false);
        $this->senderId = ValueHydrator::string($data['sender_id'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class ScheduleError extends DomainValue
{
    public readonly ?string $recipient;
    public readonly ?string $fixCode;
    public readonly ?string $type;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->recipient = ValueHydrator::string($data['recipient'] ?? null, true);
        $this->fixCode = ValueHydrator::string($data['fix_code'] ?? null, true);
        $this->type = ValueHydrator::string($data['type'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class SecretKey extends DomainValue
{
    public readonly string $id;
    public readonly ?string $label;
    public readonly string $tokenType;
    public readonly string $issuedAt;
    public readonly ?string $updatedAt;
    public readonly ?string $expiresAt;
    public readonly string $status;
    public readonly bool $active;
    public readonly ?string $revokedAt;
    public readonly ?string $lastUsedAt;
    public readonly ?int $usageCount;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->id = ValueHydrator::string($data['id'] ?? null, false);
        $this->label = ValueHydrator::string($data['label'] ?? null, true);
        $this->tokenType = ValueHydrator::string($data['token_type'] ?? null, false);
        $this->issuedAt = ValueHydrator::string($data['issued_at'] ?? null, false);
        $this->updatedAt = ValueHydrator::string($data['updated_at'] ?? null, true);
        $this->expiresAt = ValueHydrator::string($data['expires_at'] ?? null, true);
        $this->status = ValueHydrator::string($data['status'] ?? null, false);
        $this->active = ValueHydrator::bool($data['active'] ?? null, false);
        $this->revokedAt = ValueHydrator::string($data['revoked_at'] ?? null, true);
        $this->lastUsedAt = ValueHydrator::string($data['last_used_at'] ?? null, true);
        $this->usageCount = ValueHydrator::int($data['usage_count'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class SecretKeyPage extends DomainValue
{
    public readonly int $number;
    public readonly int $size;
    public readonly int $count;
    public readonly int $total;
    public readonly bool $hasMore;
    /** @var list<SecretKey> */
    public readonly array $keys;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->number = ValueHydrator::int($data['number'] ?? null, false);
        $this->size = ValueHydrator::int($data['size'] ?? null, false);
        $this->count = ValueHydrator::int($data['count'] ?? null, false);
        $this->total = ValueHydrator::int($data['total'] ?? null, false);
        $this->hasMore = ValueHydrator::bool($data['has_more'] ?? null, false);
        $this->keys = ValueHydrator::objects($data['keys'] ?? null, [SecretKey::class]);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class SecretKeyUsage extends DomainValue
{
    public readonly SecretKey $key;
    public readonly SecretKeyUsagePage $usage;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->key = ValueHydrator::object($data['key'] ?? null, [SecretKey::class], false);
        $this->usage = ValueHydrator::object($data['usage'] ?? null, [SecretKeyUsagePage::class], false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class SecretKeyUsagePage extends DomainValue
{
    public readonly int $number;
    public readonly int $size;
    public readonly int $count;
    public readonly int $total;
    public readonly bool $hasMore;
    /** @var list<SecretKeyUsageRow> */
    public readonly array $rows;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->number = ValueHydrator::int($data['number'] ?? null, false);
        $this->size = ValueHydrator::int($data['size'] ?? null, false);
        $this->count = ValueHydrator::int($data['count'] ?? null, false);
        $this->total = ValueHydrator::int($data['total'] ?? null, false);
        $this->hasMore = ValueHydrator::bool($data['has_more'] ?? null, false);
        $this->rows = ValueHydrator::objects($data['rows'] ?? null, [SecretKeyUsageRow::class]);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class SecretKeyUsageRow extends DomainValue
{
    public readonly string $secretKeyId;
    public readonly string $occurredAt;
    public readonly string $authResult;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->secretKeyId = ValueHydrator::string($data['secret_key_id'] ?? null, false);
        $this->occurredAt = ValueHydrator::string($data['occurred_at'] ?? null, false);
        $this->authResult = ValueHydrator::string($data['auth_result'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class UpdatedProduct extends DomainValue
{
    public readonly string $id;
    public readonly string $name;
    public readonly ?string $description;
    public readonly ?string $about;
    public readonly string $type;
    public readonly ?string $reference;
    public readonly ?string $taxCode;
    public readonly ?string $category;
    /** @var array<string, string>|null */
    public readonly ?array $customData;
    public readonly ?ProductDimensions $dimensions;
    /** @var list<ProductPriceSummary>|null */
    public readonly ?array $prices;
    public readonly ?string $unitDim;
    public readonly string $createdAt;
    public readonly ?string $updatedAt;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->id = ValueHydrator::string($data['id'] ?? null, false);
        $this->name = ValueHydrator::string($data['name'] ?? null, false);
        $this->description = ValueHydrator::string($data['description'] ?? null, true);
        $this->about = ValueHydrator::string($data['about'] ?? null, true);
        $this->type = ValueHydrator::string($data['type'] ?? null, false);
        $this->reference = ValueHydrator::string($data['reference'] ?? null, true);
        $this->taxCode = ValueHydrator::string($data['tax_code'] ?? null, true);
        $this->category = ValueHydrator::string($data['category'] ?? null, true);
        $this->customData = ValueHydrator::array($data['custom_data'] ?? null, true);
        $this->dimensions = ValueHydrator::object($data['dimensions'] ?? null, [ProductDimensions::class], true);
        $this->prices = ValueHydrator::objects($data['prices'] ?? null, [ProductPriceSummary::class]);
        $this->unitDim = ValueHydrator::string($data['unit_dim'] ?? null, true);
        $this->createdAt = ValueHydrator::string($data['created_at'] ?? null, false);
        $this->updatedAt = ValueHydrator::string($data['updated_at'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class UploadFulfillment extends DomainValue
{
    public readonly UploadRequest $uploadRequest;
    public readonly FileUploadReceipt $file;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->uploadRequest = ValueHydrator::object($data['upload_request'] ?? null, [UploadRequest::class], false);
        $this->file = ValueHydrator::object($data['file'] ?? null, [FileUploadReceipt::class], false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class UploadRequest extends DomainValue
{
    public readonly string $id;
    public readonly string $purpose;
    public readonly string $status;
    public readonly bool $active;
    public readonly ?string $fileId;
    public readonly ?string $uploadUrl;
    public readonly UploadRequestConstraints $constraints;
    public readonly UploadRequestDisplay $display;
    public readonly FileParty $subject;
    public readonly FileParty $recipient;
    public readonly FileResource $resource;
    public readonly UploadRequestActor $requester;
    public readonly UploadRequestAttempts $attempts;
    public readonly ?UploadRequestLatestError $latestError;
    public readonly ?UploadRequestActor $canceledBy;
    /** @var array<string, string>|null */
    public readonly ?array $customData;
    /** @var array<string, string>|null */
    public readonly ?array $metadata;
    public readonly string $createdAt;
    public readonly string $updatedAt;
    public readonly string $expiresAt;
    public readonly ?string $uploadingAt;
    public readonly ?string $fulfilledAt;
    public readonly ?string $expiredAt;
    public readonly ?string $canceledAt;
    public readonly ?UploadRequestAttempt $attempt;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->id = ValueHydrator::string($data['id'] ?? null, false);
        $this->purpose = ValueHydrator::string($data['purpose'] ?? null, false);
        $this->status = ValueHydrator::string($data['status'] ?? null, false);
        $this->active = ValueHydrator::bool($data['active'] ?? null, false);
        $this->fileId = ValueHydrator::string($data['file_id'] ?? null, true);
        $this->uploadUrl = ValueHydrator::string($data['upload_url'] ?? null, true);
        $this->constraints = ValueHydrator::object($data['constraints'] ?? null, [UploadRequestConstraints::class], false);
        $this->display = ValueHydrator::object($data['display'] ?? null, [UploadRequestDisplay::class], false);
        $this->subject = ValueHydrator::object($data['subject'] ?? null, [FileParty::class], false);
        $this->recipient = ValueHydrator::object($data['recipient'] ?? null, [FileParty::class], false);
        $this->resource = ValueHydrator::object($data['resource'] ?? null, [FileResource::class], false);
        $this->requester = ValueHydrator::object($data['requester'] ?? null, [UploadRequestActor::class], false);
        $this->attempts = ValueHydrator::object($data['attempts'] ?? null, [UploadRequestAttempts::class], false);
        $this->latestError = ValueHydrator::object($data['latest_error'] ?? null, [UploadRequestLatestError::class], true);
        $this->canceledBy = ValueHydrator::object($data['canceled_by'] ?? null, [UploadRequestActor::class], true);
        $this->customData = ValueHydrator::array($data['custom_data'] ?? null, true);
        $this->metadata = ValueHydrator::array($data['metadata'] ?? null, true);
        $this->createdAt = ValueHydrator::string($data['created_at'] ?? null, false);
        $this->updatedAt = ValueHydrator::string($data['updated_at'] ?? null, false);
        $this->expiresAt = ValueHydrator::string($data['expires_at'] ?? null, false);
        $this->uploadingAt = ValueHydrator::string($data['uploading_at'] ?? null, true);
        $this->fulfilledAt = ValueHydrator::string($data['fulfilled_at'] ?? null, true);
        $this->expiredAt = ValueHydrator::string($data['expired_at'] ?? null, true);
        $this->canceledAt = ValueHydrator::string($data['canceled_at'] ?? null, true);
        $this->attempt = ValueHydrator::object($data['attempt'] ?? null, [UploadRequestAttempt::class], true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class UploadRequestActor extends DomainValue
{
    public readonly ?string $email;
    public readonly ?string $id;
    public readonly ?string $name;
    public readonly string $type;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->email = ValueHydrator::string($data['email'] ?? null, true);
        $this->id = ValueHydrator::string($data['id'] ?? null, true);
        $this->name = ValueHydrator::string($data['name'] ?? null, true);
        $this->type = ValueHydrator::string($data['type'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class UploadRequestAttempt extends DomainValue
{
    public readonly string $attemptedAt;
    public readonly ?string $contentType;
    public readonly ?int $declaredSize;
    public readonly ?UploadRequestLatestError $error;
    public readonly ?string $failedAt;
    public readonly ?string $fileId;
    public readonly ?string $filename;
    public readonly string $id;
    public readonly int $ordinal;
    public readonly ?UploadRequestReview $review;
    public readonly string $status;
    public readonly ?string $succeededAt;
    public readonly string $uploadRequestId;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->attemptedAt = ValueHydrator::string($data['attempted_at'] ?? null, false);
        $this->contentType = ValueHydrator::string($data['content_type'] ?? null, true);
        $this->declaredSize = ValueHydrator::int($data['declared_size'] ?? null, true);
        $this->error = ValueHydrator::object($data['error'] ?? null, [UploadRequestLatestError::class], true);
        $this->failedAt = ValueHydrator::string($data['failed_at'] ?? null, true);
        $this->fileId = ValueHydrator::string($data['file_id'] ?? null, true);
        $this->filename = ValueHydrator::string($data['filename'] ?? null, true);
        $this->id = ValueHydrator::string($data['id'] ?? null, false);
        $this->ordinal = ValueHydrator::int($data['ordinal'] ?? null, false);
        $this->review = ValueHydrator::object($data['review'] ?? null, [UploadRequestReview::class], true);
        $this->status = ValueHydrator::string($data['status'] ?? null, false);
        $this->succeededAt = ValueHydrator::string($data['succeeded_at'] ?? null, true);
        $this->uploadRequestId = ValueHydrator::string($data['upload_request_id'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class UploadRequestAttempts extends DomainValue
{
    public readonly ?int $maxAttempts;
    public readonly int $attemptCount;
    public readonly int $failedAttemptCount;
    public readonly ?string $lastAttemptedAt;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->maxAttempts = ValueHydrator::int($data['max_attempts'] ?? null, true);
        $this->attemptCount = ValueHydrator::int($data['attempt_count'] ?? null, false);
        $this->failedAttemptCount = ValueHydrator::int($data['failed_attempt_count'] ?? null, false);
        $this->lastAttemptedAt = ValueHydrator::string($data['last_attempted_at'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class UploadRequestConstraints extends DomainValue
{
    public readonly ?int $minSize;
    public readonly ?int $maxSize;
    public readonly ?int $exactSize;
    /** @var list<string>|null */
    public readonly ?array $contentTypes;
    /** @var list<string>|null */
    public readonly ?array $extensions;
    public readonly ?string $filename;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->minSize = ValueHydrator::int($data['min_size'] ?? null, true);
        $this->maxSize = ValueHydrator::int($data['max_size'] ?? null, true);
        $this->exactSize = ValueHydrator::int($data['exact_size'] ?? null, true);
        $this->contentTypes = ValueHydrator::array($data['content_types'] ?? null, true);
        $this->extensions = ValueHydrator::array($data['extensions'] ?? null, true);
        $this->filename = ValueHydrator::string($data['filename'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class UploadRequestDisplay extends DomainValue
{
    public readonly ?string $title;
    public readonly ?string $description;
    public readonly ?string $helpText;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->title = ValueHydrator::string($data['title'] ?? null, true);
        $this->description = ValueHydrator::string($data['description'] ?? null, true);
        $this->helpText = ValueHydrator::string($data['help_text'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class UploadRequestLatestError extends DomainValue
{
    public readonly ?string $code;
    public readonly ?string $param;
    public readonly ?string $message;
    public readonly ?bool $retryable;
    public readonly ?string $at;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->code = ValueHydrator::string($data['code'] ?? null, true);
        $this->param = ValueHydrator::string($data['param'] ?? null, true);
        $this->message = ValueHydrator::string($data['message'] ?? null, true);
        $this->retryable = ValueHydrator::bool($data['retryable'] ?? null, true);
        $this->at = ValueHydrator::string($data['at'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class UploadRequestPage extends DomainValue
{
    public readonly int $number;
    public readonly int $size;
    /** @var list<UploadRequest> */
    public readonly array $uploadRequests;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->number = ValueHydrator::int($data['number'] ?? null, false);
        $this->size = ValueHydrator::int($data['size'] ?? null, false);
        $this->uploadRequests = ValueHydrator::objects($data['upload_requests'] ?? null, [UploadRequest::class]);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class UploadRequestReview extends DomainValue
{
    public readonly string $createdAt;
    public readonly string $decision;
    public readonly ?string $fileId;
    public readonly ?string $publicMessage;
    /** @var list<UploadRequestReviewReason>|null */
    public readonly ?array $reasons;
    public readonly string $reviewedAt;
    public readonly string $type;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->createdAt = ValueHydrator::string($data['created_at'] ?? null, false);
        $this->decision = ValueHydrator::string($data['decision'] ?? null, false);
        $this->fileId = ValueHydrator::string($data['file_id'] ?? null, true);
        $this->publicMessage = ValueHydrator::string($data['public_message'] ?? null, true);
        $this->reasons = ValueHydrator::objects($data['reasons'] ?? null, [UploadRequestReviewReason::class]);
        $this->reviewedAt = ValueHydrator::string($data['reviewed_at'] ?? null, false);
        $this->type = ValueHydrator::string($data['type'] ?? null, false);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

final class UploadRequestReviewReason extends DomainValue
{
    public readonly string $code;
    public readonly string $message;
    public readonly ?string $param;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->code = ValueHydrator::string($data['code'] ?? null, false);
        $this->message = ValueHydrator::string($data['message'] ?? null, false);
        $this->param = ValueHydrator::string($data['param'] ?? null, true);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}


/** Snapshot of balances keyed by currency code. */
final class BalanceSnapshot extends DomainValue
{
    /** @var array<string, CurrencyBalanceSnapshot> */
    public readonly array $balances;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->balances = ValueHydrator::objectMap($data['balances'] ?? $data, [CurrencyBalanceSnapshot::class]);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}

/** Country specifications keyed by country code. */
final class CountrySpecifications extends DomainValue
{
    /** @var array<string, CountrySpecification> */
    public readonly array $countries;

    /** @param array<string, mixed> $data */
    public function __construct(array $data)
    {
        $this->countries = ValueHydrator::objectMap($data['countries'] ?? $data, [CountrySpecification::class]);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): static
    {
        return new static($data);
    }
}
