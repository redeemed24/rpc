<?php
$count = 0;

$rank_info = array();
$subrank_info = array();

foreach($rank_data as $row){
    $rank_info[$count++] = array('rank_id'=>$row['rank_id'],
                                 'rank_name'=>$row['rank_name'],
                                 'remarks'=>$row['remarks'],
                                 'degree'=>$row['degree_desc']);
}

$count = 0;
foreach($subrank_data as $row){
    $subrank_info[$count++] = array('rank_id'=>$row['rank_id'],
                                    'subrank_id'=> $row['subrank_id'],
                                    'subrank_num'=>$row['subrank_num'],
                                    'min_points'=>$row['min_points'],
                                    'max_points'=>$row['max_points']);
}
    

    // header
    $this->fpdf->Header();
    $this->fpdf->AddPage();
    $this->fpdf->Ln();
    
    // title
    $this->fpdf->SetFont('Arial','B',15);
    $this->fpdf->Cell(35);$this->fpdf->Cell(55,8,'FACULTY RANKING AND PROMOTION RANKS');
    $this->fpdf->Ln(20);
    
    // prints the faculty ranks
    for($count = 0; $count<count($rank_data); $count++){
    $this->fpdf->SetFont('Arial','B',11);
    $this->fpdf->Cell(20);$this->fpdf->Cell(30,8,$rank_info[$count]['rank_name']);$this->fpdf->Ln();
    
    // prints the header tables
    $this->fpdf->SetFont('Arial','B',11);
    $this->fpdf->Cell(30);$this->fpdf->Cell(50,8,'Subrank Steps',1);
    $this->fpdf->Cell(30,8,'Points',1);
    $this->fpdf->Cell(69,8,'Minimum Educational Qualification',1);
    $this->fpdf->Ln();
    
    // prints subranks, points and educational qualifiaction
    for($counta=0; $counta<count($subrank_data); $counta++){
    $this->fpdf->SetFont('Arial','I',11);
    if($rank_info[$count]['rank_id']==$subrank_info[$counta]['rank_id']){
    $this->fpdf->Cell(30);$this->fpdf->Cell(50,8,$subrank_info[$counta]['subrank_num'],1);
    $this->fpdf->Cell(30,8,$subrank_info[$counta]['min_points']."-".$subrank_info[$counta]['max_points'],1);
    $this->fpdf->Cell(69,8,$rank_info[$count]['degree'],1);$this->fpdf->Ln();
    }}
    
    // prints remarks
    $this->fpdf->SetFont('Arial','B',11);
    $this->fpdf->Cell(30);$this->fpdf->Cell(149,8,'Prevailing Criteria',1);$this->fpdf->Ln();
     $this->fpdf->SetFont('Arial','I',11);
    $this->fpdf->Cell(30);$this->fpdf->MultiCell(149,8,$rank_info[$count]['remarks'],1,'J');
    $this->fpdf->Ln(10);
    }
    
    // output
    $this->fpdf->Output();
    
?>