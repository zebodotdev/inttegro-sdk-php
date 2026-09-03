<?php

namespace Inttegro\BankAccounts;

// Canonical bank-account module. Payment-method bank snapshots intentionally
// remain in Inttegro because they describe a payment instrument, not a
// financial-account destination.
class_alias(\Inttegro\FinancialAccountBank::class, __NAMESPACE__ . '\\BankAccount');
class_alias(\Inttegro\GhanaBankAccount::class, __NAMESPACE__ . '\\GhanaBankAccount');
class_alias(\Inttegro\FinancialAccountOwner::class, __NAMESPACE__ . '\\Owner');
class_alias(\Inttegro\FinancialAccountAddress::class, __NAMESPACE__ . '\\OwnerAddress');
class_alias(\Inttegro\BankAccountType::class, __NAMESPACE__ . '\\BankAccountType');
