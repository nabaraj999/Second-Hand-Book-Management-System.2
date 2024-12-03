<?php
// transactions.php
// Configuration for database connection
include '../connection/connections.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Function to create database and table if they don't exist
function initializeDatabase() {
    global $db_file;
    try {
        $db = new SQLite3($db_file);
        
        // Create transactions table if not exists
        $db->exec('CREATE TABLE IF NOT EXISTS transactions (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            type TEXT NOT NULL,
            name TEXT NOT NULL,
            amount REAL NOT NULL,
            date TEXT NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )');
        
        return $db;
    } catch(Exception $e) {
        error_log('Database initialization error: ' . $e->getMessage());
        sendErrorResponse('Database initialization failed');
    }
}

// Function to send JSON response
function sendJsonResponse($data, $status_code = 200) {
    header('Content-Type: application/json');
    http_response_code($status_code);
    echo json_encode($data);
    exit;
}

// Function to send error response
function sendErrorResponse($message, $status_code = 500) {
    sendJsonResponse([
        'status' => 'error',
        'message' => $message
    ], $status_code);
}

// Handle different HTTP methods
$method = $_SERVER['REQUEST_METHOD'];

try {
    $db = initializeDatabase();

    switch ($method) {
        // GET: Fetch all transactions
        case 'GET':
            $query = $db->query('SELECT * FROM transactiona ORDER BY date DESC');
            $transactions = [];
            
            while ($row = $query->fetchArray(SQLITE3_ASSOC)) {
                $transactions[] = [
                    'id' => $row['id'],
                    'type' => $row['type'],
                    'name' => $row['name'],
                    'amount' => number_format($row['amount'], 2, '.', ''),
                    'date' => $row['date']
                ];
            }
            
            sendJsonResponse($transactions);
            break;

        // POST: Add a new transaction
        case 'POST':
            // Get the raw POST data
            $rawData = file_get_contents('php://input');
            $transaction = json_decode($rawData, true);

            // Validate input
            if (!$transaction || 
                !isset($transaction['type']) || 
                !isset($transaction['name']) || 
                !isset($transaction['amount']) || 
                !isset($transaction['date'])) {
                sendErrorResponse('Invalid transaction data', 400);
            }

            // Prepare and execute insert
            $stmt = $db->prepare('
                INSERT INTO transactiona (type, name, amount, date) 
                VALUES (type, name, amount, date)
            ');
            
            $stmt->bindValue('type', $transaction['type'], SQLITE3_TEXT);
            $stmt->bindValue('name', $transaction['name'], SQLITE3_TEXT);
            $stmt->bindValue('amount', floatval($transaction['amount']), SQLITE3_FLOAT);
            $stmt->bindValue('date', $transaction['date'], SQLITE3_TEXT);

            $result = $stmt->execute();

            if ($result) {
                sendJsonResponse([
                    'status' => 'success',
                    'id' => $db->lastInsertRowID()
                ]);
            } else {
                sendErrorResponse('Failed to insert transaction');
            }
            break;

        // DELETE: Remove a transaction
        case 'DELETE':
            // Get the raw DELETE data
            $rawData = file_get_contents('php://input');
            $deleteData = json_decode($rawData, true);

            // Validate input
            if (!$deleteData || !isset($deleteData['id'])) {
                sendErrorResponse('Invalid delete request', 400);
            }

            // Prepare and execute delete
            $stmt = $db->prepare('DELETE FROM transactiona WHERE id = :id');
            $stmt->bindValue(':id', $deleteData['id'], SQLITE3_INTEGER);

            $result = $stmt->execute();

            if ($result) {
                sendJsonResponse([
                    'status' => 'success'
                ]);
            } else {
                sendErrorResponse('Failed to delete transaction');
            }
            break;

        default:
            sendErrorResponse('Method not allowed', 405);
    }

    // Close database connection
    $db->close();

} catch(Exception $e) {
    sendErrorResponse('An unexpected error occurred: ' . $e->getMessage());
}
?>