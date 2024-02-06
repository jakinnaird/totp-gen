<?php

use RobThree\Auth\TwoFactorAuth;
use RobThree\Auth\Providers\Qr\IQRCodeProvider;

class QRCodeProvider implements IQRCodeProvider
{
    public function getQRCodeImage(string $qrtext, int $size) : string
    {
        $qroptions = new \chillerlan\QRCode\QROptions([
            'imageBase64' => false,
            'outputType' => \chillerlan\QRCode\Output\QROutputInterface::GDIMAGE_PNG,
        ]);

        $qrcode = new \chillerlan\QRCode\QRCode($qroptions);
        return $qrcode->render($qrtext);
    }

    public function getMimeType() : string
    {
        return 'image/png';
    }
}

$issuer = 'totp-gen';

$totp = new \RobThree\Auth\TwoFactorAuth(
    $issuer, 6, 30,
    \RobThree\Auth\Algorithm::Sha1,
    new QRCodeProvider);

$email = 'no-reply@example.com';
$secret = $totp->createSecret();
$qr_code = $totp->getQRCodeImageAsDataUri($issuer.':'.$email, $secret);
