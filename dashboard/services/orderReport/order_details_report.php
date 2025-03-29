<?php
// require('fpdf.php');
// require_once '../../config/database.php';

// class PDF extends FPDF
// {
//     function Header()
//     {
//         $this->SetFont('Arial', 'B', 14);
//         $this->Cell(190, 10, 'User Subscription Details Report', 0, 1, 'C');
//         $this->Ln(10);
//     }

//     function Footer()
//     {
//         $this->SetY(-15);
//         $this->SetFont('Arial', 'I', 8);
//         $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
//     }
// }

// if (!isset($_GET['subscription_id'])) {
//     die('Subscription ID is required');
// }

// $subscription_id = $_GET['subscription_id'];

// $database = new Database();
// $pdo = $database->getConnection();

// $pdf = new PDF();
// $pdf->AddPage();
// $pdf->SetFont('Arial', 'B', 12);
// $pdf->SetFillColor(200, 220, 255);

// // Fetch subscription + user + plan in one go
// $sql = "SELECT us.*, 
//                u.name as user_name, u.email, u.phone, u.address, u.preferences, u.allergies,
//                s.name as plan_name, s.description, s.duration_days, s.price, s.goal
//         FROM user_subscriptions us
//         JOIN users u ON us.user_id = u.id
//         JOIN subscriptions s ON us.subscription_id = s.id
//         WHERE us.id = :id";
// $stmt = $pdo->prepare($sql);
// $stmt->bindParam(':id', $subscription_id, PDO::PARAM_INT);
// $stmt->execute();
// $data = $stmt->fetch(PDO::FETCH_ASSOC);

// if (!$data) {
//     die('Subscription not found');
// }

// // User Information
// $pdf->Cell(190, 10, 'User Information', 1, 1, 'C', true);
// $pdf->Ln(5);
// $pdf->SetFont('Arial', '', 11);
// $pdf->Cell(50, 10, 'Name:', 0, 0);
// $pdf->Cell(0, 10, $data['user_name'], 0, 1);
// $pdf->Cell(50, 10, 'Email:', 0, 0);
// $pdf->Cell(0, 10, $data['email'], 0, 1);
// $pdf->Cell(50, 10, 'Phone:', 0, 0);
// $pdf->Cell(0, 10, $data['phone'], 0, 1);
// $pdf->Cell(50, 10, 'Address:', 0, 0);
// $pdf->Cell(0, 10, $data['address'], 0, 1);
// $pdf->Cell(50, 10, 'Preferences:', 0, 0);
// $pdf->Cell(0, 10, $data['preferences'], 0, 1);
// $pdf->Cell(50, 10, 'Allergies:', 0, 0);
// $pdf->Cell(0, 10, $data['allergies'], 0, 1);
// $pdf->Ln(10);

// // Subscription Plan
// $pdf->SetFont('Arial', 'B', 12);
// $pdf->Cell(190, 10, 'Subscription Plan', 1, 1, 'C', true);
// $pdf->Ln(5);
// $pdf->SetFont('Arial', '', 11);
// $pdf->Cell(50, 10, 'Plan Name:', 0, 0);
// $pdf->Cell(0, 10, $data['plan_name'], 0, 1);
// $pdf->Cell(50, 10, 'Goal:', 0, 0);
// $pdf->Cell(0, 10, $data['goal'], 0, 1);
// $pdf->Cell(50, 10, 'Duration:', 0, 0);
// $pdf->Cell(0, 10, $data['duration_days'] . " days", 0, 1);
// $pdf->Cell(50, 10, 'Price:', 0, 0);
// $pdf->Cell(0, 10, "$" . $data['price'], 0, 1);
// $pdf->MultiCell(0, 10, "Description: " . $data['description']);
// $pdf->Ln(10);

// // Subscription Info
// $pdf->SetFont('Arial', 'B', 12);
// $pdf->Cell(190, 10, 'Subscription Info', 1, 1, 'C', true);
// $pdf->Ln(5);
// $pdf->SetFont('Arial', '', 11);
// $pdf->Cell(50, 10, 'Subscription ID:', 0, 0);
// $pdf->Cell(0, 10, $data['id'], 0, 1);
// $pdf->Cell(50, 10, 'Start Date:', 0, 0);
// $pdf->Cell(0, 10, $data['start_date'], 0, 1);
// $pdf->Cell(50, 10, 'End Date:', 0, 0);
// $pdf->Cell(0, 10, $data['end_date'], 0, 1);
// $pdf->Cell(50, 10, 'Status:', 0, 0);
// $pdf->Cell(0, 10, ucfirst($data['status']), 0, 1);
// $pdf->Cell(50, 10, 'Created At:', 0, 0);
// $pdf->Cell(0, 10, $data['created_at'], 0, 1);
// $pdf->Cell(50, 10, 'Updated At:', 0, 0);
// $pdf->Cell(0, 10, $data['updated_at'], 0, 1);

// $pdf->Output();
