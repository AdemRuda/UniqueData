<?php
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "UniqueEmployeesData";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$name = $_POST['name'];
$surname = $_POST['surname'];
$start_date = $_POST['start_date'];
$gender = $_POST['gender'];
$work_date = $_POST['work_date'];
$visa_start = $_POST['visa_start'];
$visa_end = $_POST['visa_end'];
$work_place = $_POST['work_place'];
$atesia = $_POST['atesia'];
$amesia = $_POST['amesia'];
$data_e_lindjes = $_POST['data_e_lindjes'];
$numri_i_pashaportes = $_POST['numri_i_pashaportes'];
$vlefshmeria_e_pashaportes = $_POST['vlefshmeria_e_pashaportes'];

// Insert into database
$sql = "INSERT INTO Employees (name, surname, start_date, gender, work_date, visa_start, visa_end, work_place, atesia, amesia, data_e_lindjes, numri_i_pashaportes, vlefshmeria_e_pashaportes)
        VALUES ('$name', '$surname', '$start_date', '$gender', '$work_date', '$visa_start', '$visa_end', '$work_place', '$atesia', '$amesia', '$data_e_lindjes', '$numri_i_pashaportes', '$vlefshmeria_e_pashaportes')";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Record inserted successfully!'); window.location.href = 'index.html';</script>";
} else {
    echo "<script>alert('Error: " . $conn->error . "'); window.location.href = 'index.html';</script>";
}

// Send email using PHPMailer
$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'ademruda1@gmail.com';
    $mail->Password = 'ssxullysupcyduyq'; // Use App Password instead of regular password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;
    $mail->SMTPDebug = 2; // Enable debugging
    $mail->Debugoutput = 'html';

    $mail->setFrom('ademruda1@gmail.com', 'Unique Permit Notification');
    $mail->addAddress('info@arsigroup.al');
    $mail->addAddress('adem_ruda@live.com');

    $mail->isHTML(true);
    $mail->Subject = 'New Employer Registration';
    $mail->Body = "Name: $name $surname<br>Start Date: $start_date<br>Gender: $gender<br>Work data: $work_data<br>Visa start: $visa_start<br>Visa End: $visa_end<br>Work place: $work_place<br> Atesia: $atesia<br>Amesia: $amesia<br>Data e lindjes: $data_e_lindjes<br>Numri i Pashaportes $numri_i_pashaportes<br> Vlefshmeria e Pashaportes $vlefshmeria_e_pashaportes";
 
    if (!$mail->send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        echo "Email sent successfully!";
    }
} catch (Exception $e) {
    echo "Email sending failed. Error: {$mail->ErrorInfo}";
}

// Automatic Visa Expiry Check
$one_month_later = date('Y-m-d', strtotime('+1 month'));
$sql = "SELECT * FROM Employees WHERE visa_end = '$one_month_later'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $name = $row['name'];
        $surname = $row['surname'];
        $visa_end = $row['visa_end'];

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'ademruda1@gmail.com';
            $mail->Password = 'ssxullysupcyduyq';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            
            $mail->setFrom('ademruda1@gmail.com', 'Visa Expiry Notification');
            $mail->addAddress('info@arsigroup.al');
            $mail->addAddress('adem_ruda@live.com');
            
            $mail->isHTML(true);
            $mail->Subject = 'Visa Expiry Alert';
            $mail->Body = "The visa for <strong>$name $surname</strong> is expiring on <strong>$visa_end</strong>. Please take necessary action.";
            
            if (!$mail->send()) {
                echo "Error sending notification for $name $surname: " . $mail->ErrorInfo . "<br>";
            } else {
                echo "Notification email sent for $name $surname.<br>";
            }
        } catch (Exception $e) {
            echo "Error sending notification for $name $surname: {$mail->ErrorInfo}<br>";
        }
    }
} else {
    echo "No visas expiring in 1 month.";
}

$conn->close();
?>
