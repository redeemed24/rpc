<?php
$count=1;
$sy = array();
foreach($school_year as $row){
    $sy[$count++]=$row->SY_desc;
}
$count = 0;


    // header
    $this->fpdf->Header();
    $this->fpdf->AddPage();
    $this->fpdf->Ln();
    
    // title
    $this->fpdf->SetFont('Arial','B',11);
    $this->fpdf->Cell(45);$this->fpdf->Cell(55,1,'FACULTY RANKING AND PROMOTION SUMMARY FORM');
    $this->fpdf->Ln(15);
    
    // name, program, previous rank, school year
    foreach($individual_data as $row){
    $this->fpdf->SetFont('Arial','',11);
    $this->fpdf->Cell(20);$this->fpdf->Cell(55,8,'Name: '.$individual_data[0]['faculty_lname'].', '.$individual_data[0]['faculty_fname'].' '.$individual_data[0]['faculty_mname']);
    $this->fpdf->Cell(40);$this->fpdf->Cell(55,8,'Previous Rank: '.$individual_data[0]['previous_rank'].' '.$individual_data[0]['previous']);
    $this->fpdf->Ln();
    $this->fpdf->Cell(20);$this->fpdf->Cell(55,8,'Program: '.$individual_data[0]['program_name']);
	$this->fpdf->Ln();
    $this->fpdf->Cell(20);$this->fpdf->Cell(55,8,'School Year: '.$sy[$individual_data[0]['SY_id']]);
    
    $this->fpdf->Ln(7);
    
    
    // header tables
    $this->fpdf->SetFont('Arial','B',11);
    $this->fpdf->Cell(20);
    $this->fpdf->MultiCell(70,14,'Specific Areas',1,'C');
    $this->fpdf->SetXY(100,85);
    $this->fpdf->SetFont('Arial','B',10);
    $this->fpdf->MultiCell(20,7,'Maximum Points',1,'C');
    $this->fpdf->SetXY(120,85);
    $this->fpdf->SetFont('Arial','B',10);
    $this->fpdf->MultiCell(30,7,'Points Earned for Current Year',1,'C');
    $this->fpdf->SetXY(150,85);
    $this->fpdf->MultiCell(30,7,'Points Percentage',1,'C');
    
    // data tables
    foreach($record_data as $row1){
    $this->fpdf->SetFont('Arial','I',10);
    $this->fpdf->Cell(20);
    $this->fpdf->Cell(70,10,$row1->qualification_name,1);
    $this->fpdf->Cell(20,10 ,$row1->maxpoints,1);
    $this->fpdf->Cell(30,10,$row1->points_earned,1);
    $this->fpdf->Cell(30,10,$row1->points_percent,1);
    $this->fpdf->Ln(10);
    }
    $this->fpdf->Ln(10);
    
    // total datas
    $this->fpdf->SetFont('Arial','',10);
    $this->fpdf->Cell(20);$this->fpdf->Cell(55,8,'TOTAL POINTS EARNED FROM CURRENT RANKING: ');
    $this->fpdf->Cell(35);$this->fpdf->SetFont('Arial','B',10);
    $this->fpdf->Cell(55,8,$individual_data[0]['currentpoints']);$this->fpdf->Ln();
    $this->fpdf->SetFont('Arial','',10);
    $this->fpdf->Cell(20);$this->fpdf->Cell(55,8,'POINTS EARNED FROM PREVIOUS RANKING: ');
    $this->fpdf->Cell(24);$this->fpdf->SetFont('Arial','B',10);
    $this->fpdf->Cell(55,8,$individual_data[0]['prevpoints']);$this->fpdf->Ln();
    $this->fpdf->SetFont('Arial','',10);
    $this->fpdf->Cell(20);$this->fpdf->Cell(55,8,'TOTAL:  ');
    $this->fpdf->Cell(-41);$this->fpdf->SetFont('Arial','B',10);
    $this->fpdf->Cell(1,8,$individual_data[0]['total_points']);$this->fpdf->Ln();
    $this->fpdf->SetFont('Arial','',10);
    $this->fpdf->Cell(20);$this->fpdf->Cell(55,8,'EQUIVALENT RANK: ');
    $this->fpdf->Cell(-19);$this->fpdf->SetFont('Arial','B',10);
    $this->fpdf->Cell(55,8,$individual_data[0]['current_rank'].' '.$individual_data[0]['current']);
    $this->fpdf->Ln();
    $this->fpdf->SetFont('Arial','',10);
    $this->fpdf->Cell(20);$this->fpdf->Cell(55,8,'REMARKS: ');
    $this->fpdf->Cell(-35);$this->fpdf->SetFont('Arial','B',10);
    $this->fpdf->Cell(55,8,$individual_data[0]['remarks']);$this->fpdf->Ln();
    $this->fpdf->Ln();$this->fpdf->Ln();
    $this->fpdf->Cell(1);$this->fpdf->SetFont('Arial','',10);
    $this->fpdf->Cell(19);$this->fpdf->Cell(55,8,'EVALUATED BY: ');
    $this->fpdf->Cell(-19);$this->fpdf->SetFont('Arial','B',10);
    $this->fpdf->Cell(55,8,$individual_data[0]['user_fname'].' '.$individual_data[0]['user_lname']);$this->fpdf->Ln();
    $this->fpdf->Ln(-1);
	$this->fpdf->SetFont('Arial','I',8);
	$this->fpdf->Cell(50);$this->fpdf->Cell(55,5,'SIGNATURE OVER PRINTED NAME','T');
	$this->fpdf->Ln();
    if($updated_data!=NULL){
    foreach($updated_data as $row){
     $this->fpdf->Ln();$this->fpdf->Ln();
    $this->fpdf->Cell(1);$this->fpdf->SetFont('Arial','',10);
    $this->fpdf->Cell(19);$this->fpdf->Cell(55,8,'UPDATED BY: ');
    $this->fpdf->Cell(-19);$this->fpdf->SetFont('Arial','B',10);
    $this->fpdf->Cell(55,8,$row->user_fname.' '.$row->user_lname);$this->fpdf->Ln();
    $this->fpdf->Ln(-1);
	$this->fpdf->SetFont('Arial','I',8);
	$this->fpdf->Cell(50);$this->fpdf->Cell(55,5,'SIGNATURE OVER PRINTED NAME','T');
	$this->fpdf->Ln();
    }
    }
    $this->fpdf->Ln();$this->fpdf->Ln();
    $this->fpdf->SetFont('Arial','I',8);
    $this->fpdf->Cell(65);$this->fpdf->Cell(60,-15,$individual_data[0]['date']);
    $this->fpdf->Ln();
    }
    
    // output
    $this->fpdf->Output();
    
?>