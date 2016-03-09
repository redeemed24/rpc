<?php
$count = 0;

    // header
    $this->fpdf->Header();
    $this->fpdf->AddPage();
    $this->fpdf->Ln();
    
    // title
    $this->fpdf->SetFont('Arial','B',14);
    $this->fpdf->Cell(45);$this->fpdf->Cell(55,8,'FACULTY RANKING AND PROMOTION REPORTS');
    $this->fpdf->Ln(15);
 
    $ssy;
    foreach($school_year as $sy){
        $ssy = $sy->SY_desc;
    }
    //School Year
    $this->fpdf->SetFont('Arial','B',9);
    $this->fpdf->Cell(80);$this->fpdf->Cell(50,-10,'School Year: ');
    $this->fpdf->SetFont('Arial','',9);
    $this->fpdf->Cell(-30);$this->fpdf->Cell(50,-10,$ssy);
    $this->fpdf->Ln(15);
    
    // header tables
    foreach($report_data as $row){
    $this->fpdf->SetFont('Arial','B',10);
    $this->fpdf->Cell(10);
    $this->fpdf->Cell(35,8,'Name: ');
    $this->fpdf->SetFont('Arial','',10);
    $this->fpdf->Cell(35,8,$row->faculty_lname.", ".$row->faculty_fname." ".$row->faculty_mname);
    $this->fpdf->Ln();
    $this->fpdf->Cell(10);
    $this->fpdf->SetFont('Arial','B',10);
    $this->fpdf->Cell(35,8,'Program: ');
    $this->fpdf->SetFont('Arial','',10);
    $this->fpdf->Cell(35,8,$row->program_name);
    $this->fpdf->Ln();
    
    $this->fpdf->Cell(10);
    $this->fpdf->SetFont('Arial','B',10);
    $this->fpdf->Cell(28,8,'Previous Points',1);
    $this->fpdf->Cell(36,8,'Previous Rank',1);
    $this->fpdf->Cell(26,8,'Current Points',1);
    $this->fpdf->Cell(42,8,'Current Rank',1);
    $this->fpdf->Cell(42,8,'Pegged',1);
    $this->fpdf->Ln();
  
    $this->fpdf->Cell(10);
    $this->fpdf->SetFont('Arial','I',10);
    $this->fpdf->Cell(28,8,$row->prevpoints,1);
    if($row->previous_rank==0 && $row->previous==0){
    $this->fpdf->Cell(36,8,"");
    }
    else{
    $this->fpdf->Cell(36,8,$row->previous_rank." ".$row->previous,1);
    }
    $this->fpdf->Cell(26,8,$row->total_points,1);
    $this->fpdf->Cell(42,8,$row->current_rank." ".$row->current,1);
    $this->fpdf->Cell(42,8,$row->pegged." ".$row->pegg,1);
    
    $this->fpdf->Ln();   
    $this->fpdf->Cell(10);
    $this->fpdf->SetFont('Arial','B',10);
    $this->fpdf->Cell(174,8,'Remarks',1);
    $this->fpdf->Ln();
   
    $this->fpdf->Cell(10);
    $this->fpdf->SetFont('Arial','I',10);
    $this->fpdf->Cell(174,8,$row->remarks,1);
    $this->fpdf->Ln();   
    
    $this->fpdf->Cell(10);
    $this->fpdf->SetFont('Arial','B',10);
    $this->fpdf->Cell(35,8,'Total: ');
    $this->fpdf->SetFont('Arial','',10);
     $this->fpdf->Cell(35,8,$row->currentpoints);
    $this->fpdf->Ln();
    $this->fpdf->Ln();
    }
    $this->fpdf->Ln();
    
    // output
    $this->fpdf->Output();
    
?>
