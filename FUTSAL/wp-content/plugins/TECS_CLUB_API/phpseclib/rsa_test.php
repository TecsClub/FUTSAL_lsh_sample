<?php
set_include_path(get_include_path() . PATH_SEPARATOR . '../phpseclib');
include('Crypt/RSA.php');

function rsa_encrypt($key, $message) {
	$rsa = new Crypt_RSA(); 
	$rsa->loadKey($key); 
	$encrypted = base64_encode($rsa->encrypt($message)); 
	return $encrypted;
}

function rsa_decrypt($key, $package) {
	$rsa = new Crypt_RSA(); 
	$rsa->loadKey($key); 
	$decrypted = $rsa->decrypt(base64_decode($package)); 
	return $decrypted;
}

function rsa_sign($key, $package) {
	$rsa = new Crypt_RSA(); 
	$rsa->setHash("sha256"); 
	$rsa->setSignatureMode(CRYPT_RSA_SIGNATURE_PKCS1); 
	$rsa->loadKey($key); 
	$signature = base64_encode($rsa->sign($package)); 
	return $signature;
}

function rsa_verify($key, $signature, $package) {
	$rsa = new Crypt_RSA(); 
	$rsa->setHash("sha256"); 
	$rsa->setSignatureMode(CRYPT_RSA_SIGNATURE_PKCS1); 
	$rsa->loadKey($key); 
	$verify = $rsa->verify($package, base64_decode($signature)); 
	return $verify;
}

function rsa_generate($bits=2048) {
	$rsa = new Crypt_RSA(); 
	define('CRYPT_RSA_EXPONENT', 65537); 
	$keypair = $rsa->createKey($bits); 
	return $keypair;
}

$rsa_key = rsa_generate();
echo "RSA_KEY IS...\n" . print_r($rsa_key,true) . "\n";
$text_PLAIN = "THIS IS A PLAIN TEXT" . "\n";

echo "PLAIN_DATA IS...\n" . $text_PLAIN . "\n";

$text_encoded_with_private = rsa_encrypt($rsa_key['privatekey'], $text_PLAIN);
echo "ENCRYPT_DATA WITH PRIVATE KEY IS...\n" . $text_encoded_with_private . "\n";
echo "DECRYPT_DATA WITH PUBLIC  KEY IS...\n" . rsa_decrypt($rsa_key['publickey'], $text_encoded_with_private) . "\n";


$text_encoded_with_public = rsa_encrypt($rsa_key['publickey'], $text_PLAIN);
echo "ENCRYPT_DATA WITH PUBLIC  KEY IS...\n" . $text_encoded_with_public . "\n";
echo "DECRYPT_DATA WITH PRIVATE KEY IS...\n" . rsa_decrypt($rsa_key['privatekey'], $text_encoded_with_public) . "\n";

$text_signature_with_private = rsa_sign($rsa_key['privatekey'], $text_encoded_with_private);
echo "SIGNATURE_DATA WITH PRIVATE KEY IS...\n" . $text_signature_with_private . "\n";

$text_verify_with_public = rsa_verify($rsa_key['publickey'], $text_signature_with_private, $text_encoded_with_private);
echo "VERIFIED_DATA WITH PUBLIC  KEY IS...\n" . $text_verify_with_public . "\n";

$text_signature_with_public = rsa_sign($rsa_key['publickey'], $text_encoded_with_public);
echo "SIGNATURE_DATA WITH PUBLIC  KEY IS...\n" . $text_signature_with_public . "\n";

$text_verify_with_private = rsa_verify($rsa_key['privatekey'], $text_signature_with_public, $text_encoded_with_public);
echo "VERIFIED_DATA WITH PRIVATE  KEY IS...\n" . $text_verify_with_private . "\n";

?>

