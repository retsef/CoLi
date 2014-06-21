<?php


ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);

include './crypt_manager.php';

$crypt = new crypt_manager();

$plaintext = $_POST['data'];

echo '<p>$plaintext = ' . $plaintext . '<p>';

$encrypted = $crypt->encrypt($plaintext);

echo '<p>$encrypted = ' . $encrypted . '<p>';

$decrypted = $crypt->decrypt($encrypted);

echo '<p>$decrypted = ' . $decrypted . '<p>';

/*
ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);

include './crypt_manager.php';

$public = "-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDfmlc2EgrdhvakQApmLCDOgP0n
NERInBheMh7J/r5aU8PUAIpGXET/8+kOGI1dSYjoux80AuHvkWp1EeHfMwC/SZ9t
6rF4sYqV5Lj9t32ELbh2VNbE/7QEVZnXRi5GdhozBZtS1gJHM2/Q+iToyh5dfTaA
U8bTnLEPMNC1h3qcUQIDAQAB
-----END PUBLIC KEY-----";

$private = "-----BEGIN RSA PRIVATE KEY-----
MIICXAIBAAKBgQDfmlc2EgrdhvakQApmLCDOgP0nNERInBheMh7J/r5aU8PUAIpG
XET/8+kOGI1dSYjoux80AuHvkWp1EeHfMwC/SZ9t6rF4sYqV5Lj9t32ELbh2VNbE
/7QEVZnXRi5GdhozBZtS1gJHM2/Q+iToyh5dfTaAU8bTnLEPMNC1h3qcUQIDAQAB
AoGAcbh6UFqewgnpGKIlZ89bpAsANVckv1T8I7QT6qGvyBrABut7Z8t3oEE5r1yX
UPGcOtkoRniM1h276ex9VtoGr09sUn7duoLiEsp8aip7p7SB3X6XXWJ9K733co6C
dpXotfO0zMnv8l3O9h4pHrrBkmWDBEKbUeuE9Zz7uy6mFAECQQDygylLjzX+2rvm
FYd5ejSaLEeK17AiuT29LNPRHWLu6a0zl923299FCyHLasFgbeuLRCW0LMCs2SKE
Y+cIWMSRAkEA7AnzWjby8j8efjvUwIWh/L5YJyWlSgYKlR0zdgKxxUy9+i1MGRkn
m81NLYza4JLvb8/qjUtvw92Zcppxb7E7wQJAIuQWC+X12c30nLzaOfMIIGpgfKxd
jhFivZX2f66frkn2fmbKIorCy7c3TIH2gn4uFmJenlaV/ghbe/q3oa7L0QJAFP19
ipRAXpKGX6tqbAR2N0emBzUt0btfzYrfPKtYq7b7XfgRQFogT5aeOmLARCBM8qCG
tzHyKnTWZH6ff9M/AQJBAIToUPachXPhDyOpDBcBliRNsowZcw4Yln8CnLqgS9H5
Ya8iBJilFm2UlcXfpUOk9bhBTbgFp+Bv6BZ2Alag7pY=
-----END RSA PRIVATE KEY-----";

if (!$privateKey = openssl_pkey_get_private($private))
    die('Loading Private Key failed');
if (!$publicKey = openssl_pkey_get_public($public))
    die('Loading Public Key failed');

$encrypted = '';
$decrypted = '';

$plaintext = 'This is just some text to encrypt';

echo '<p>$plaintext = ' . $plaintext . '<p>';

if (!openssl_public_encrypt($plaintext, $encrypted, $publicKey))
    die('Failed to encrypt data');

echo '<p>$encrypted = ' . $encrypted . '<p>';

if (!openssl_private_decrypt($encrypted, $decrypted, $privateKey))
    die('Failed to decrypt data');

echo '<p>$decrypted = ' . $decrypted . '<p>';*/

