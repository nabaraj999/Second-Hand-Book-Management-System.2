<?php
session_start();
// Get the pidx from the URL
$pidx = $_GET['pidx'] ?? null;

if ($pidx) {
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://a.khalti.com/api/v2/epayment/lookup/',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode(['pidx' => $pidx]),
        CURLOPT_HTTPHEADER => array(
            'Authorization: key cc09cc0797af49be80dd578ee351e179',
            'Content-Type: application/json',
        ),
    ));
 

    $response = curl_exec($curl);
    curl_close($curl);

    if ($response) {
        $responseArray = json_decode($response, true);
        
<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "khalti_payment";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Save transaction data
$stmt = $conn->prepare("INSERT INTO transactions (pidx, status, amount, purchase_order_id, customer_name, customer_email, customer_phone) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssissss", $pidx, $responseArray['status'], $responseArray['amount'], $responseArray['purchase_order_id'], $responseArray['customer_info']['name'], $responseArray['customer_info']['email'], $responseArray['customer_info']['phone']);
$stmt->execute();
$stmt->close();

$conn->close();
?>

switch ($responseArray['status']) {
            case 'Completed':
                //here you can write your logic to update the database
                $_SESSION['transaction_msg'] = '<script>
                        Swal.fire({
                            icon: "success",
                            title: "Transaction successful.",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    </script>';


                header("Location: message.php");
                exit();
                break;
            case 'Expired':
            case 'User canceled':
                //here you can write your logic to update the database
                $_SESSION['transaction_msg'] = '<script>
                        Swal.fire({
                            icon: "error",
                            title: "Transaction failed.",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    </script>';
                header("Location: checkout.php");
                exit();
                break;
            default:
            //here you can write your logic to update the database
                $_SESSION['transaction_msg'] = '<script>
                        Swal.fire({
                            icon: "error",
                            title: "Transaction failed.",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    </script>';
                header("Location: checkout.php");
                exit();
                break;
        }
    }
}