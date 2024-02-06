<?php
/*
MIT License

Copyright (c) 2024 James Kinnaird

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
*/

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
