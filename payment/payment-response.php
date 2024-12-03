<?php
session_start();
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

        // Debug Khalti API Response
        file_put_contents('debug.log', "Khalti Response: " . print_r($responseArray, true) . PHP_EOL, FILE_APPEND);

        if (isset($responseArray['status'], $responseArray['amount'], $responseArray['purchase_order_id'], $responseArray['customer_info']['name'], $responseArray['customer_info']['email'], $responseArray['customer_info']['phone'])) {
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "booknest";

            $conn = new mysqli($servername, $username, $password, $dbname, 3307);

            if ($conn->connect_error) {
                die("Database Connection Failed: " . $conn->connect_error);
            }

            // Prepare Insert Query
            $stmt = $conn->prepare("INSERT INTO transactions (pidx, status, amount, purchase_order_id, customer_name, customer_email, customer_phone) 
                VALUES (?, ?, ?, ?, ?, ?, ?) 
                ON DUPLICATE KEY UPDATE status = VALUES(status), amount = VALUES(amount)");
            $stmt->bind_param(
                "ssissss",
                $pidx,
                $responseArray['status'],
                $responseArray['amount'],
                $responseArray['purchase_order_id'],
                $responseArray['customer_info']['name'],
                $responseArray['customer_info']['email'],
                $responseArray['customer_info']['phone']
            );

            if ($stmt->execute()) {
                echo "Transaction saved successfully!";
            } else {
                // Debug SQL Error
                file_put_contents('debug.log', "SQL Error: " . $stmt->error . PHP_EOL, FILE_APPEND);
                echo "Error saving transaction: " . $stmt->error;
            }

            $stmt->close();
            $conn->close();
        } else {
            die("Invalid response from Khalti API. Missing required fields.");
        }
    } else {
        die("Failed to connect to Khalti API.");
    }
} else {
    die("Invalid request. Pidx is missing.");
}
?>
