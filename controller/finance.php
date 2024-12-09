<?php
// Database Connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "booknest";
$port = 3307;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create table if not exists with additional columns
$create_table_query = "CREATE TABLE IF NOT EXISTS financial_records (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    date DATE NOT NULL,
    type ENUM('income', 'expense') NOT NULL,
    category VARCHAR(100) NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    description TEXT,
    payment_method VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$conn->query($create_table_query);

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_record'])) {
        $date = $_POST['record_date'];
        $type = $_POST['record_type'];
        $category = $_POST['record_category'];
        $amount = $_POST['record_amount'];
        $description = $_POST['record_description'];
        $payment_method = $_POST['record_payment_method'];

        $insert_query = "INSERT INTO financial_records (date, type, category, amount, description, payment_method) 
                         VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("sssdss", $date, $type, $category, $amount, $description, $payment_method);
        
        if ($stmt->execute()) {
            $success_message = "Record added successfully!";
        } else {
            $error_message = "Error adding record: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Fetch monthly records and generate comprehensive report
$selected_year = isset($_GET['report_year']) ? intval($_GET['report_year']) : date('Y');
$selected_month = isset($_GET['report_month']) ? intval($_GET['report_month']) : date('m');

// Enhanced reporting queries
$category_breakdown_query = "SELECT 
    type, 
    category, 
    SUM(amount) as total_amount,
    COUNT(*) as transaction_count
FROM financial_records 
WHERE YEAR(date) = ? AND MONTH(date) = ?
GROUP BY type, category
ORDER BY total_amount DESC";
$stmt_category = $conn->prepare($category_breakdown_query);
$stmt_category->bind_param("ii", $selected_year, $selected_month);
$stmt_category->execute();
$category_result = $stmt_category->get_result();

$payment_method_query = "SELECT 
    payment_method, 
    SUM(amount) as total_amount,
    COUNT(*) as transaction_count
FROM financial_records 
WHERE YEAR(date) = ? AND MONTH(date) = ?
GROUP BY payment_method
ORDER BY total_amount DESC";

$stmt_payment = $conn->prepare($payment_method_query);
$stmt_payment->bind_param("ii", $selected_year, $selected_month);
$stmt_payment->execute();
$payment_result = $stmt_payment->get_result();

// Comprehensive monthly report
$report_query = "SELECT 
    type, 
    SUM(amount) as total_amount,
    COUNT(*) as transaction_count,
    MIN(amount) as min_amount,
    MAX(amount) as max_amount,
    AVG(amount) as avg_amount
FROM financial_records 
WHERE YEAR(date) = ? AND MONTH(date) = ?
GROUP BY type";
$stmt_report = $conn->prepare($report_query);
$stmt_report->bind_param("ii", $selected_year, $selected_month);
$stmt_report->execute();
$report_result = $stmt_report->get_result();

$report = [
    'income' => 0,
    'expense' => 0,
    'net_profit' => 0,
    'income_count' => 0,
    'expense_count' => 0,
    'income_details' => [],
    'expense_details' => []
];

while ($row = $report_result->fetch_assoc()) {
    $type = $row['type'];
    $report[$type] = $row['total_amount'];
    $report[$type . '_count'] = $row['transaction_count'];
    $report[$type . '_details'] = [
        'min_amount' => $row['min_amount'],
        'max_amount' => $row['max_amount'],
        'avg_amount' => $row['avg_amount']
    ];
}
$report['net_profit'] = $report['income'] - $report['expense'];

// Monthly records for table
$monthly_records_query = "SELECT * FROM financial_records 
                          WHERE YEAR(date) = ? AND MONTH(date) = ?
                          ORDER BY date, type";
$stmt_records = $conn->prepare($monthly_records_query);
$stmt_records->bind_param("ii", $selected_year, $selected_month);
$stmt_records->execute();
$monthly_records_result = $stmt_records->get_result();

// Prepare category and payment method breakdowns
$category_breakdown = [];
$payment_method_breakdown = [];

while ($row = $category_result->fetch_assoc()) {
    $category_breakdown[] = $row;
}

while ($row = $payment_result->fetch_assoc()) {
    $payment_method_breakdown[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BookNest Financial System</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="../view/index.css">
  <link rel="stylesheet" href="contact.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
</head>
<body>
    <div class="navbar">
        <div class="logo">BookNest</div>
        <div class="nav-links">
            <!-- Updated Nav Links -->
            <a href="index.php">Home</a>
            <a href="adminsell.php">Sell</a>
            <a href="bookmanage.php">Buy</a>
            <a href="manage_users.php">User Manage</a>
            <a href="Addbook.php">Book Add</a>
            <a href="manage_books.php">Edit Book</a>
            <a href="finance.php">Finance</a>
            <a href="help.php">Feedback</a>
        </div>
        <div class="search-user">
            <span class="username">
                <?php
                    echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Guest';
                ?>
            </span>
            <!-- Profile Icon -->
            <button class="profile-icon" onclick="redirectToProfile()">
                <i class="fas fa-user"></i>
            </button>
            <!-- Logout Button -->
            <button class="logout" onclick="logout()">Logout</button>
        </div>
    </div>
    <style>
        body { 
            background: linear-gradient(135deg, #f6f8f9 0%, #e5ebee 100%); 
        }
        .card {
            transition: all 0.3s ease;
        }
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="max-w-7xl mx-auto">
       
        <!-- Success/Error Messages -->
        <?php if (isset($success_message)): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6 flex items-center" role="alert">
                <i class="fas fa-check-circle mr-3 text-2xl"></i>
                <span><?php echo htmlspecialchars($success_message); ?></span>
            </div>
        <?php endif; ?>
        
        <?php if (isset($error_message)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6 flex items-center" role="alert">
                <i class="fas fa-exclamation-triangle mr-3 text-2xl"></i>
                <span><?php echo htmlspecialchars($error_message); ?></span>
            </div>
        <?php endif; ?>

        <div class="grid md:grid-cols-2 gap-8">
            <!-- Add Financial Record Form -->
            <div class="bg-white shadow-lg rounded-lg p-6 card">
                <h2 class="text-2xl font-bold mb-6 text-blue-600 flex items-center">
                    <i class="fas fa-plus-circle mr-3 text-blue-500"></i>Add Financial Record
                </h2>
                <form method="POST" class="grid grid-cols-1 gap-4">
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-calendar mr-2 text-blue-500"></i>Date
                            </label>
                            <input type="date" name="record_date" required 
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-tags mr-2 text-blue-500"></i>Type
                            </label>
                            <select name="record_type" required 
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="income">Income</option>
                                <option value="expense">Expense</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-folder mr-2 text-blue-500"></i>Category
                        </label>
                        <input type="text" name="record_category" required 
                               class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-rupes-sign mr-2 text-blue-500"></i>Amount
                            </label>
                            <input type="number" name="record_amount" step="0.01" required 
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-credit-card mr-2 text-blue-500"></i>Payment Method
                            </label>
                            <select name="record_payment_method" 
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="cash">Cash</option>
                                <option value="credit_card">Credit Card</option>
                                <option value="debit_card">Debit Card</option>
                                <option value="bank_transfer">Bank Transfer</option>
                                <option value="digital_wallet">Digital Wallet</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-note-medical mr-2 text-blue-500"></i>Description
                        </label>
                        <textarea name="record_description" 
                                  class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>
                    <button type="submit" name="add_record" 
                            class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 rounded-md hover:opacity-90 transition flex items-center justify-center">
                        <i class="fas fa-save mr-3"></i>Add Financial Record
                    </button>
                </form>
            </div>

            <!-- Financial Report Section -->
            <div class="bg-white shadow-lg rounded-lg p-6 card">
                <h2 class="text-2xl font-bold mb-6 text-blue-600 flex items-center">
                    <i class="fas fa-chart-pie mr-3 text-blue-500"></i>Financial Reports
                </h2>
                <form method="GET" class="mb-6">
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Select Year</label>
                            <select name="report_year" 
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <?php 
                                $current_year = date('Y');
                                for ($i = $current_year - 5; $i <= $current_year; $i++) {
                                    $selected = ($i == $selected_year) ? 'selected' : '';
                                    echo "<option value='$i' $selected>$i</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Select Month</label>
                            <select name="report_month" 
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <?php 
                                $months = [
                                    1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 
                                    5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 
                                    9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
                                ];
                               foreach ($months as $month_num => $month_name) {
                                    $selected = ($month_num == $selected_month) ? 'selected' : '';
                                    echo "<option value='$month_num' $selected>$month_name</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <button type="submit" 
                            class="w-full mt-4 bg-gradient-to-r from-green-600 to-teal-600 text-white py-3 rounded-md hover:opacity-90 transition flex items-center justify-center">
                        <i class="fas fa-file-alt mr-3"></i>Generate Report
                    </button>
                </form>

                <!-- Monthly Summary -->
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="bg-blue-100 p-4 rounded-lg text-center">
                        <h3 class="font-bold text-blue-800 mb-2">Total Income</h3>
                        <p class="text-2xl font-extrabold text-green-600">
                            Rs <?php echo number_format($report['income'], 2); ?>
                        </p>
                        <small class="text-gray-600"><?php echo $report['income_count']; ?> transactions</small>
                    </div>
                    <div class="bg-red-100 p-4 rounded-lg text-center">
                        <h3 class="font-bold text-red-800 mb-2">Total Expenses</h3>
                        <p class="text-2xl font-extrabold text-red-600">
                            Rs <?php echo number_format($report['expense'], 2); ?>
                        </p>
                        <small class="text-gray-600"><?php echo $report['expense_count']; ?> transactions</small>
                    </div>
                </div>

                <!-- Net Profit/Loss -->
                <div class="bg-gradient-to-r <?php echo $report['net_profit'] >= 0 ? 'from-green-200 to-green-300' : 'from-red-200 to-red-300'; ?> p-4 rounded-lg text-center mb-6">
                    <h3 class="font-bold text-gray-800 mb-2">Net Profit/Loss</h3>
                    <p class="text-3xl font-extrabold <?php echo $report['net_profit'] >= 0 ? 'text-green-800' : 'text-red-800'; ?>">
                        Rs <?php echo number_format($report['net_profit'], 2); ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- Category Breakdown -->
        <div class="grid md:grid-cols-2 gap-8 mt-8">
            <div class="bg-white shadow-lg rounded-lg p-6 card">
                <h2 class="text-2xl font-bold mb-6 text-blue-600 flex items-center">
                    <i class="fas fa-chart-bar mr-3 text-blue-500"></i>Category Breakdown
                </h2>
                <div class="overflow-x-auto">
                    <table class="w-full bg-white">
                        <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left">Type</th>
                                <th class="py-3 px-6 text-left">Category</th>
                                <th class="py-3 px-6 text-right">Total Amount</th>
                                <th class="py-3 px-6 text-center">Transactions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            <?php foreach ($category_breakdown as $category): ?>
                                <tr class="border-b border-gray-200 hover:bg-gray-100">
                                    <td class="py-3 px-6 text-left capitalize">
                                        <span class="<?php echo $category['type'] == 'income' ? 'text-green-600' : 'text-red-600'; ?>">
                                            <?php echo $category['type']; ?>
                                        </span>
                                    </td>
                                    <td class="py-3 px-6 text-left"><?php echo htmlspecialchars($category['category']); ?></td>
                                    <td class="py-3 px-6 text-right">Rs <?php echo number_format($category['total_amount'], 2); ?></td>
                                    <td class="py-3 px-6 text-center"><?php echo $category['transaction_count']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Payment Method Breakdown -->
            <div class="bg-white shadow-lg rounded-lg p-6 card">
                <h2 class="text-2xl font-bold mb-6 text-blue-600 flex items-center">
                    <i class="fas fa-credit-card mr-3 text-blue-500"></i>Payment Method Analysis
                </h2>
                <div class="overflow-x-auto">
                    <table class="w-full bg-white">
                        <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left">Payment Method</th>
                                <th class="py-3 px-6 text-right">Total Amount</th>
                                <th class="py-3 px-6 text-center">Transactions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            <?php foreach ($payment_method_breakdown as $payment): ?>
                                <tr class="border-b border-gray-200 hover:bg-gray-100">
                                    <td class="py-3 px-6 text-left capitalize">
                                        <?php echo str_replace('_', ' ', htmlspecialchars($payment['payment_method'])); ?>
                                    </td>
                                    <td class="py-3 px-6 text-right">Rs <?php echo number_format($payment['total_amount'], 2); ?></td>
                                    <td class="py-3 px-6 text-center"><?php echo $payment['transaction_count']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Monthly Transactions Table -->
        <div class="bg-white shadow-lg rounded-lg p-6 card mt-8">
            <h2 class="text-2xl font-bold mb-6 text-blue-600 flex items-center">
                <i class="fas fa-list mr-3 text-blue-500"></i>Monthly Transactions
            </h2>
            <div class="overflow-x-auto">
                <table class="w-full bg-white">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Date</th>
                            <th class="py-3 px-6 text-left">Type</th>
                            <th class="py-3 px-6 text-left">Category</th>
                            <th class="py-3 px-6 text-right">Amount</th>
                            <th class="py-3 px-6 text-left">Payment Method</th>
                            <th class="py-3 px-6 text-right">Actions</th>
                            
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        <?php while ($record = $monthly_records_result->fetch_assoc()): ?>
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 text-left"><?php echo $record['date']; ?></td>
                                <td class="py-3 px-6 text-left capitalize">
                                    <span class="<?php echo $record['type'] == 'income' ? 'text-green-600' : 'text-red-600'; ?>">
                                        <?php echo $record['type']; ?>
                                    </span>
                                </td>
                                <td class="py-3 px-6 text-left"><?php echo htmlspecialchars($record['category']); ?></td>
                                <td class="py-3 px-6 text-right">Rs <?php echo number_format($record['amount'], 2); ?></td>
                                <td class="py-3 px-6 text-left capitalize">
                                    <?php echo str_replace('_', ' ', htmlspecialchars($record['payment_method'])); ?>
                    
                                </td>
                                <td>
                                <a href="edit_transaction.php?id=<?php echo $row['id']; ?>">Edit</a>
                    |
                    <a href="delete_transaction.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this record?');">Delete</a>
                        </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center mt-10 text-gray-600">
        <p>&copy; <?php echo date('Y'); ?> BookNest Financial Management. All rights reserved.</p>
    </footer>

    <script>
        // Optional: Add some client-side interactivity
        document.addEventListener('DOMContentLoaded', function() {
            const recordTypeSelect = document.querySelector('select[name="record_type"]');
            const recordCategory = document.querySelector('input[name="record_category"]');
            
            const categoryPresets = {
                'income': ['Salary', 'Freelance', 'Investments', 'Rental', 'Other Income'],
                'expense': ['Rent', 'Utilities', 'Groceries', 'Transportation', 'Entertainment', 'Dining Out', 'Shopping', 'Healthcare', 'Education', 'Other Expenses']
            };

            recordTypeSelect.addEventListener('change', function() {
                // Provide category suggestions based on record type
                const suggestions = categoryPresets[this.value];
                recordCategory.setAttribute('list', 'category-suggestions');
                
                // Create or update datalist
                let datalist = document.getElementById('category-suggestions');
                if (!datalist) {
                    datalist = document.createElement('datalist');
                    datalist.id = 'category-suggestions';
                    recordCategory.parentNode.insertBefore(datalist, recordCategory.nextSibling);
                }
                
                // Clear existing options
                datalist.innerHTML = '';
                
                // Add new options
                suggestions.forEach(category => {
                    const option = document.createElement('option');
                    option.value = category;
                    datalist.appendChild(option);
                });
            });
        });
    </script>
</body>
</html>

<?php
// Close database connections
$stmt_category->close();
$stmt_payment->close();
$stmt_report->close();
$stmt_records->close();
$conn->close();
?>