<?php

use PHPUnit\Framework\TestCase;

/**
 * Guards the API documentation carried by the resource-scoped public types.
 *
 * These comments are part of the SDK's usability contract: phpDocumentor renders them for humans,
 * while IDEs and code-aware agents use the same source to understand wire names and value types.
 */
final class DocumentationTest extends TestCase
{
    /** @var list<string> */
    private const DOMAIN_NAMESPACES = [
        'App',
        'Balance',
        'BalanceTransaction',
        'BankAccount',
        'Broadcast',
        'Checkout',
        'Chime',
        'Customer',
        'File',
        'FileLink',
        'FileReference',
        'FinancialAccount',
        'MessageTemplate',
        'Money',
        'Order',
        'Otp',
        'Payment',
        'PaymentMethod',
        'Payout',
        'Price',
        'Product',
        'PurchaseIntent',
        'Refund',
        'Schedule',
        'SecretKey',
        'Shared',
        'UploadRequest',
        'Wallet',
    ];

    public function testResourceScopedTypesCarryCompletePhpDoc(): void
    {
        foreach ($this->publicResourceTypes() as $type) {
            $reflection = new ReflectionClass($type);
            self::assertNotFalse(
                $reflection->getDocComment(),
                sprintf('%s must explain the public value it represents.', $type),
            );

            if (!$reflection->isEnum()) {
                foreach ($reflection->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
                    if ($property->getDeclaringClass()->getName() !== $type) {
                        continue;
                    }

                    $comment = $property->getDocComment();
                    self::assertNotFalse(
                        $comment,
                        sprintf('%s::$%s must document its PHP and API meanings.', $type, $property->getName()),
                    );
                    $normalizedComment = preg_replace('/\s+/', ' ', str_replace('*', '', $comment));
                    self::assertIsString($normalizedComment);
                    self::assertStringContainsString(
                        'wire field:',
                        strtolower($normalizedComment),
                        sprintf('%s::$%s must name its API wire field.', $type, $property->getName()),
                    );
                }
            }

            if (!$reflection->isEnum()) {
                foreach ($reflection->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
                    if ($method->getDeclaringClass()->getName() !== $type) {
                        continue;
                    }

                    self::assertNotFalse(
                        $method->getDocComment(),
                        sprintf('%s::%s() must explain its behavior.', $type, $method->getName()),
                    );
                }
            }

            if ($reflection->isEnum()) {
                $enum = new ReflectionEnum($type);
                foreach ($enum->getCases() as $case) {
                    $comment = $case->getDocComment();
                    self::assertNotFalse(
                        $comment,
                        sprintf('%s::%s must document its API value.', $type, $case->getName()),
                    );
                    self::assertStringContainsString(
                        'Wire value:',
                        $comment,
                        sprintf('%s::%s must state its exact wire value.', $type, $case->getName()),
                    );
                }
            }
        }
    }

    public function testResourceClientOperationsCarryPhpDoc(): void
    {
        $directory = dirname(__DIR__) . '/src/Inttegro/Resources';
        foreach (glob($directory . '/*.php') ?: [] as $path) {
            $type = 'Inttegro\\Resources\\' . pathinfo($path, PATHINFO_FILENAME);
            $reflection = new ReflectionClass($type);

            self::assertNotFalse(
                $reflection->getDocComment(),
                sprintf('%s must describe the resource operations it exposes.', $type),
            );
            foreach ($reflection->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
                if ($method->getDeclaringClass()->getName() !== $type) {
                    continue;
                }
                self::assertNotFalse(
                    $method->getDocComment(),
                    sprintf('%s::%s() must document the API operation.', $type, $method->getName()),
                );
            }
        }
    }

    /** @return list<class-string> */
    private function publicResourceTypes(): array
    {
        $source = dirname(__DIR__) . '/src/Inttegro';
        $types = [];
        foreach (self::DOMAIN_NAMESPACES as $namespace) {
            foreach (glob($source . '/' . $namespace . '/*.php') ?: [] as $path) {
                $contents = file_get_contents($path);
                self::assertIsString($contents);
                self::assertSame(
                    1,
                    preg_match('/^(?:final\s+)?(?:abstract\s+)?(?:class|enum)\s+(\w+)/m', $contents, $match),
                    sprintf('%s must declare one public class or enum.', $path),
                );
                $type = 'Inttegro\\' . $namespace . '\\' . $match[1];
                self::assertTrue(
                    class_exists($type) || enum_exists($type),
                    sprintf('%s must resolve through PSR-4 autoloading.', $type),
                );
                $types[] = $type;
            }
        }

        sort($types);
        return $types;
    }
}
