<?php
require_once "../config/db.php";
require_once "../includes/auth_check.php";
checkRole('student');

require_once "../vendor/autoload.php";

use Dompdf\Dompdf;

// Get student
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT id FROM students WHERE user_id=:uid");
$stmt->execute([':uid'=>$user_id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

$student_id = $student['id'];

// Get latest slip
$stmt = $conn->prepare("
    SELECT * FROM roll_slips 
    WHERE student_id=:sid 
    ORDER BY id DESC 
    LIMIT 1
");

$stmt->execute([':sid'=>$student_id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    die("No slip found");
}

$slip = json_decode($row['slip_data'], true);

// BUILD HTML FOR PDF
$html = '
<h2 style="text-align:center;">Exam Roll Slip</h2>
<hr>

<p><b>Department:</b> '.$row['department'].'</p>
<p><b>Semester:</b> '.$row['semester'].'</p>
<p><b>Student:</b> '.$slip['student_name'].'</p>

<br>

<table border="1" width="100%" cellpadding="8" cellspacing="0">
<tr>
    <th>#</th>
    <th>Subject</th>
    <th>Exam Date</th>
</tr>';

foreach ($slip['subjects'] as $i => $sub) {
    $html .= '
    <tr>
        <td>'.($i+1).'</td>
        <td>'.$sub['subject_name'].'</td>
        <td>'.$sub['exam_date'].'</td>
    </tr>';
}

$html .= '</table>';

// INIT DOMPDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);

// A4 paper
$dompdf->setPaper('A4', 'portrait');

$dompdf->render();

// FORCE DOWNLOAD
$dompdf->stream("roll_slip.pdf", ["Attachment" => true]);
exit;
?>