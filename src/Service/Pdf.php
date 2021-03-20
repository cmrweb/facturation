<?php

namespace App\Service;

use App\Entity\Facture;

class Pdf
{
    private $facture;
    public function getPdf(Facture $facture){
        $pdf = new \FPDF;
        $pdf->AddPage();
        $pdf->Ln(10);
        $pdf->SetFont('Arial','B',18);
        $pdf->Cell(40,10,"FACTURE ");
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(80,10,utf8_decode("n°_").$facture->getDate()->format("Ym").$facture->getClient()->getAbbr());
        $pdf->Ln(10);
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(100,10,"Le ".$facture->getDate()->format("d/m/Y"));
        $pdf->Ln(5);
        $pdf->Cell(100,10,"Du ".$facture->getMois()->format("01/m/Y")." au ".$facture->getMois()->format("t/m/Y"));
        $pdf->Ln(20);   
        $pdf->SetFillColor(200,200,200);
        $pdf->Cell(90,10,$facture->getPrestataire()->getNom(),"R",0,"C",true);
        $pdf->Cell(90,10,$facture->getClient()->getEntreprise(),"L",0,"C",true);
        $pdf->Ln(10);
        $pdf->Cell(90,5,$facture->getPrestataire()->getSiret(),"R",0,"C",true);
        $pdf->Cell(90,5,$facture->getClient()->getSiret(),"L",0,"C",true);

        $pdf->Ln(5);
        $pdf->Cell(90,5,$facture->getPrestataire()->getAdresse(),"R",0,"C",true);
        $pdf->Cell(90,5,$facture->getClient()->getAdresse(),"L",0,"C",true);

        $pdf->Ln(5);
        $pdf->Cell(90,5,$facture->getPrestataire()->getCp()." ".$facture->getPrestataire()->getVille(),"R",0,"C",true);
        $pdf->Cell(90,5,$facture->getClient()->getCp()." ".$facture->getClient()->getVille(),"L",0,"C",true);
        
        $pdf->Ln(30);
        $pdf->Cell(80,10,utf8_decode("Désignation"),1);
        $pdf->Cell(30,10,utf8_decode("Quantité"),1,"","C");
        $pdf->Cell(30,10,"Taux",1,"","C");
        $pdf->Cell(40,10,"Montant",1,"","C");
        $pdf->Ln(10);
        $pdf->Cell(80,20,utf8_decode($facture->getPrestation()),1);
        switch($facture->getQuantiteType()){
            case 0:
                $type = "h";
            break;
            case 1:
                $type = "j";
            break;
            case 2:
                $type = "presta.";
            break;
        }
        $pdf->Cell(30,20,$facture->getQuantite()." ($type)",1,"","R");
        $pdf->Cell(30,20,$facture->getTaux()." ".chr(128) ,1,"","R");
        $pdf->Cell(40,20,round($facture->getQuantite()*$facture->getTaux(),2)." ".chr(128) ,1,"","R");
        $pdf->Ln(20);
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(100,40,"TVA non applicable, art. 293 B du CGI");
        $pdf->SetFont('Arial','',12);
        $pdf->Ln(30);
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(25,10,"Total TTC" ,1,"","L");
        $pdf->Cell(25,10,round($facture->getQuantite()*$facture->getTaux(),2)." ".chr(128) ,1,"","R");
        $pdf->Ln(20);
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(80,10,$facture->getPrestataire()->getNom());
        $pdf->Cell(100,10,"RIB: ".$facture->getPrestataire()->getRib());
        $pdf->Ln(5);
        $pdf->Cell(80,10,$facture->getPrestataire()->getSiren());
        $pdf->Cell(100,10,$facture->getPrestataire()->getBanque());
        $pdf->Ln(5);
        $pdf->Cell(80,10,$facture->getPrestataire()->getAdresse());
        $pdf->Cell(80,10,$facture->getPrestataire()->getCode());
        $pdf->Ln(5);
        $pdf->Cell(80,10,$facture->getPrestataire()->getCp()." ".$facture->getPrestataire()->getVille());
        $pdf->Cell(80,10,$facture->getPrestataire()->getCle());
        $pdf->Ln(5);
        $pdf->Cell(80,10,$facture->getPrestataire()->getEmail());
        $pdf->Ln(5);
        $pdf->Cell(80,10,$facture->getPrestataire()->getTel());
        $pdf->Ln(20);
        $pdf->Cell(80,10,$facture->getMention()?utf8_decode($facture->getMention()):"");
        $pdf->Ln(30);
        $pdf->Cell(180,10,"Le ".$facture->getDate()->format("d/m/Y"),"","","R");
        
        return $pdf->Output();
    } 
}
