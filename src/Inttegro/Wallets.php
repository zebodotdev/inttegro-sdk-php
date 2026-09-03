<?php

namespace Inttegro\Wallets;

// Canonical wallet module. These aliases preserve the generated wire classes
// while presenting financial-account wallet types through a focused namespace.
class_alias(\Inttegro\FinancialAccountWallet::class, __NAMESPACE__ . '\\Wallet');
class_alias(\Inttegro\FinancialAccountWalletMobileMoney::class, __NAMESPACE__ . '\\MobileMoney');
class_alias(\Inttegro\WalletType::class, __NAMESPACE__ . '\\WalletType');
