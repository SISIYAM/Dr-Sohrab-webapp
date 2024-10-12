<?php
require_once 'dp_config.php';
session_start();

$jsonStr = file_get_contents('php://input');
$jsonObj = json_decode($jsonStr);

if (!empty($jsonObj->request_type) && $jsonObj->request_type == 'user_auth') {
    $credential = !empty($jsonObj->credential) ? $jsonObj->credential : '';

    $responsePayload = json_decode(base64_decode(explode(".", $credential)[1]));

    if (!empty($responsePayload)) {
        $oauth_provider = 'google';
        $oauth_uid = !empty($responsePayload->sub) ? $responsePayload->sub : '';
        $first_name = !empty($responsePayload->given_name) ? $responsePayload->given_name : '';
        $last_name = !empty($responsePayload->family_name) ? $responsePayload->family_name : '';
        $full_name = $first_name . ' ' . $last_name;
        $email = !empty($responsePayload->email) ? $responsePayload->email : '';
        $picture = !empty($responsePayload->picture) ? $responsePayload->picture : '';

        // Check if the user already exists in the database
        $stmt = $db->prepare("SELECT * FROM students WHERE student_id = ?");
        $stmt->bind_param("s", $oauth_uid);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // User exists, you can choose to update any information if needed
            // For example:
            // $stmt = $db->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ?, picture = ?, modified = NOW() WHERE google_id = ?");
            // $stmt->bind_param("sssss", $first_name, $last_name, $email, $picture, $oauth_uid);
            // $stmt->execute();
    
            // $_SESSION['login_id'] = $oauth_uid;
            setcookie('student_id', $oauth_uid, time() + time() + (365 * 24 * 60 * 60), '/');
            // header("Location: ../home.php");
           
            
        } else {
            // User does not exist, insert a new record
            $stmt = $db->prepare("INSERT INTO students (student_id, full_name, email, profile_image) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $oauth_uid, $full_name, $email, $picture);
            $stmt->execute();
           
            // $_SESSION['login_id'] = $oauth_uid;
            setcookie('student_id', $oauth_uid, time() + time() + (365 * 24 * 60 * 60), '/');
            ?>
           
        <?php
        }

        $output = [
            'status' => 1,
            'msg' => 'Account data inserted/updated successfully!',
            'pdata' => $responsePayload
        ];
        echo json_encode($output);
    } else {
        echo json_encode(['error' => 'Account data is not available!']);
    }
}
?>
