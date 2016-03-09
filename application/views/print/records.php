<?php
$count =1;
    $sy_info = array();
    foreach($school_year as $row){
        $sy_info[$count++] = $row->SY_desc;
    }
    foreach($record_data as $row){
        $school_year [0]= $row->sy_id;
    }
$count = 0;

    // header
    $this->fpdf->Header();
    $this->fpdf->AddPage();
    $this->fpdf->Ln();
    
    // title
    $this->fpdf->SetFont('Arial','B',14);
    $this->fpdf->Cell(35);$this->fpdf->Cell(55,8,'FACULTY RANKING AND PROMOTION RECORDS');
    $this->fpdf->Ln(15);

    // name and school year
    foreach($faculty_data as $row){
    $this->fpdf->SetFont('Arial','',11);
    $this->fpdf->Cell(20);$this->fpdf->Cell(55,8,'Name: '.$row->faculty_lname.', '.$row->faculty_fname.' '.$row->faculty_mname);
    $this->fpdf->Cell(60);$this->fpdf->Cell(55,8,'SY: '.$sy_info[$school_year[0]]);
    $this->fpdf->Ln();
    foreach($previous_rank as $rank){
    $this->fpdf->Cell(20);$this->fpdf->Cell(55,8,'Previous Rank: '.$rank->rank_name." ".$rank->subrank_num);
    }
    $this->fpdf->Ln(15);
    }
    
    // prints qualifications
    foreach($totalrecord_data as $total){
    $this->fpdf->SetFont('Arial','B',11);
    $this->fpdf->Cell(20);$this->fpdf->Cell(55,8,$total->qualification_name.' ('.$total->maxpoints.' maximum points)');$this->fpdf->Ln();
    $this->fpdf->Cell(30);$this->fpdf->Cell(105,8,'Items',1);$this->fpdf->Cell(35,8,'Points Earned',1);
     $this->fpdf->Ln();
    // prints items with points
    foreach($record_data as $record){
    $this->fpdf->SetFont('Arial','I',11);
    if($record->qualification_id == $total->qualification_id){
    $this->fpdf->Cell(30);$this->fpdf->Cell(105,8,$record->item_name,1);$this->fpdf->Cell(35,8,$record->points,1);
    $this->fpdf->Ln();
    }}
    
    // prints total points and average
    $this->fpdf->SetFont('Arial','B',11);
    $this->fpdf->Cell(30);$this->fpdf->Cell(55,8,'Total: '.$total->points_earned);
    $this->fpdf->Cell(40);$this->fpdf->Cell(55,8,'Total percentage: '.$total->points_percent);
    $this->fpdf->Ln(10);
    }
    $this->fpdf->Ln();
    // output
    $this->fpdf->Output();
    
?>