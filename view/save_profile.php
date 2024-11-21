<?php
session_start();
include('../connection/connection.php');

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: signupa.php");
    exit();
}

$username = $_SESSION['username'];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect data from the form fields
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $district = mysqli_real_escape_string($conn, $_POST['district']);
    $municipality = mysqli_real_escape_string($conn, $_POST['municipality']);
    $ward_no = mysqli_real_escape_string($conn, $_POST['ward_no']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
    $job_type = mysqli_real_escape_string($conn, $_POST['job_type']);

    $college_name = isset($_POST['college_name']) ? mysqli_real_escape_string($conn, $_POST['college_name']) : NULL;
    $level = isset($_POST['level']) ? mysqli_real_escape_string($conn, $_POST['level']) : NULL;
    $subject = isset($_POST['subject']) ? mysqli_real_escape_string($conn, $_POST['subject']) : NULL;
    $company_name = isset($_POST['company_name']) ? mysqli_real_escape_string($conn, $_POST['company_name']) : NULL;
    $post = isset($_POST['post']) ? mysqli_real_escape_string($conn, $_POST['post']) : NULL;

    // Handle avatar upload
    $avatar = $_POST['existing_avatar'];
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
        $avatar_dir = "../uploads/";
        $avatar_name = basename($_FILES['avatar']['name']);
        $avatar_path = $avatar_dir . $avatar_name;

        // Check if the file is a valid image
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        $file_type = strtolower(pathinfo($avatar_path, PATHINFO_EXTENSION));

        if (in_array($file_type, $allowed_types)) {
            // Move uploaded file to avatar directory
            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $avatar_path)) {
                $avatar = $avatar_name;
            } else {
                $_SESSION['update_success'] = "Failed to upload avatar.";
            }
        } else {
            $_SESSION['update_success'] = "Invalid file type for avatar.";
        }
    }

    // Prepare the SQL query to update the user profile
    $query = "UPDATE users SET 
                full_name = '$full_name', 
                district = '$district', 
                municipality = '$municipality', 
                ward_no = '$ward_no', 
                email = '$email', 
                phone_number = '$phone_number', 
                job_type = '$job_type', 
                college_name = NULL, 
                level = NULL, 
                subject = NULL, 
                company_name = NULL, 
                post = NULL, 
                avatar = '$avatar'";

    if ($job_type === "Student") {
        $query .= ", college_name = '$college_name', level = '$level', subject = '$subject'";
    } elseif ($job_type === "Employed") {
        $query .= ", company_name = '$company_name', post = '$post'";
    }

    $query .= " WHERE username = '$username'";

    // Execute the update query
    if (mysqli_query($conn, $query)) {
        $_SESSION['update_success'] = "Profile updated successfully!";
    } else {
        $_SESSION['update_success'] = "Error updating profile: " . mysqli_error($conn);
    }

    // Redirect back to the profile page
    header("Location: profile.php");
    exit();
} else {
    header("Location: profile.php");
    exit();
}
?>
