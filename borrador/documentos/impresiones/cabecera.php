<?php
require('../../../fpdf/fpdf.php');
class PDF extends FPDF{
//Cabecera de página
function Header(){
$this->Image('../../../../images/fondoAzul.png',10,8,33);
$this->SetFont('Arial','B',12);
$this->Cell(30,10,'Title',1,0,'C');
}
}
//Creación del objeto de la clase heredada
$pdf=new PDF();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
//Aquí escribimos lo que deseamos mostrar...
$pdf->Output();
?>