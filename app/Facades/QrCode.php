<?php

namespace App\Facades;

use chillerlan\QRCode\{QRCode as QRCodeGenerator, QROptions};
use Illuminate\Support\Facades\Facade;

class QrCode extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'qrcode';
    }

    public static function size($size)
    {
        $options = new QROptions([
            'version'      => 5,
            'outputType'   => 'svg',
            'eccLevel'     => 0,  // 0 = L, 1 = M, 2 = Q, 3 = H
            'scale'        => 5,
            'addQuietzone' => true,
            'imageBase64'  => false,
        ]);

        $qrcode = new QRCodeGenerator($options);
        
        return new class($qrcode, $size) {
            private $qrcode;
            private $size;

            public function __construct($qrcode, $size)
            {
                $this->qrcode = $qrcode;
                $this->size = $size;
            }

            public function generate($text)
            {
                $svg = $this->qrcode->render($text);
                return preg_replace(
                    '/<svg([^>]*)>/',
                    '<svg${1} width="'.$this->size.'" height="'.$this->size.'">',
                    $svg
                );
            }
        };
    }
} 