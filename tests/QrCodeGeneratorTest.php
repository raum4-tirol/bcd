<?php

namespace Qedv\Tools\Bcd\Tests;

use PHPUnit\Framework\TestCase;
use TCPDF;

use Qedv\Tools\Bcd\Bill;
use Qedv\Tools\Bcd\BillToStringConverter;
use Qedv\Tools\Bcd\QRCodeGenerator;

class QrCodeGeneratorTest extends TestCase
{
    
    /**
     * Test the BCD data generation, see doc example 2.
     */
    
    public function testGenerateValidMessage()
    {
        $billmessage = <<<EOT
BCD
001
1
SCT
GIBAATWW
Max Mustermann
AT682011131032423628
EUR1456.89

457845789452

Diverse Autoteile, Re 789452 KN 457845
EOT;
        $mockPdf = $this->createMock(TCPDF::class);
        $mockPdf->expects($this->once())
                ->method('write2DBarcode')
                ->with($billmessage, 'QRCODE,M', 150, 50, 40, 40, $this->isType('array'), 'N');
        $result = (new QRCodeGenerator())->generate($billmessage, $mockPdf);
    }
}
