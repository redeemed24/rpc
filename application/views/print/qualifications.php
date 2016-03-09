<?php

    // header
    $this->fpdf->Header();
    $this->fpdf->AddPage();
    $this->fpdf->Ln();
    
    // title
    $this->fpdf->SetFont('Arial','B',15);
    $this->fpdf->Cell(21);$this->fpdf->Cell(55,8,'FACULTY RANKING AND PROMOTION QUALIFICATIONS');
    $this->fpdf->Ln(20);
    
    // prints the qualifications
    foreach($qualification_data as $qual){
    $this->fpdf->SetFont('Arial','B',11);
    $this->fpdf->Cell(11);$this->fpdf->Cell(55,8,$qual->qualification_name);
    $this->fpdf->Ln();
    
    // prints the items
    foreach($item_data as $itm){
    $this->fpdf->SetFont('Arial','I',11);
    if($itm->qualification_id == $qual->qualification_id){
    $this->fpdf->Cell(20);$this->fpdf->Cell(150,8,$itm->item_name,1);
    $this->fpdf->Ln();
    }}
    
    // prints the points and percentage
    $this->fpdf->SetFont('Arial','',11);
    $this->fpdf->Cell(20);$this->fpdf->Cell(55,8,'Maxmimum points: '.$qual->maxpoints);
    $this->fpdf->Cell(9);$this->fpdf->Cell(55,8,' Overall percentage: '.$qual->maxpercentage);
    $this->fpdf->Ln(10);
    }
    
    // output
    $this->fpdf->Output();
    
?>