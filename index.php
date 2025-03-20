<?php

/* 
 * Example for usage of the library.
 */

require_once('vendor/autoload.php');
require_once('vendor/tecnickcom/tcpdf/examples/tcpdf_include.php');

use Qedv\Tools\Bcd\Bill;
use Qedv\Tools\Bcd\BillToStringConverter;
use Qedv\Tools\Bcd\QRCodeGenerator;
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$bill = new Bill();
$bill->setVersion(Bill::VERSION_1)
->setDecodingNumber(Bill::ENCODING_UTF8)
->setCreditTransferMethod(Bill::SCT)
->setBankIdentiferCode('GIBAATWW')
->setReceiverName('Fabia Mustermann')
->setIban('AT682011131032423628')
->setAmount('EUR1456.89')
->setPaymentReference('457845789452')
->setReasonForPayment('Diverse Autoteile, Re 789452 KN 457845');

 $converter = new BillToStringConverter();
 $var= $converter->convert($bill);
 $pdf->AddPage();
 $qrcode=new QRCodeGenerator($var, $pdf);
$pdf=$qrcode->generate($var, $pdf);

$pdf->Text(10, 15, 'Rechnung');

$pdf->Text(10, 30, $bill->getRecieverName());
$pdf->Text(10, 35, $bill->getIban());
$pdf->Text(10, 40, $bill->getBankIdentifierCode());
$pdf->Text(150, 40, $bill->getAmount());
$pdf->Text(10, 45, $bill->getPaymentReference());
$pdf->Text(10, 55, $bill->getReasonForPayment());
$pdf->Text(10, 100, 'Danke für ihren Einkauf.');
$pdf->Output('TestPDF.pdf', 'I');
