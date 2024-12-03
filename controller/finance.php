

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookNest Monthly Financial Tracker</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 800px;
            margin: auto;
        }
        h1 {
            text-align: center;
        }
        .summary {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .summary div {
            flex: 1;
            margin: 5px;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
        }
        .income {
            background-color: #d4edda;
            color: #155724;
        }
        .expenses {
            background-color: #f8d7da;
            color: #721c24;
        }
        .balance {
            background-color: #d6d8db;
            color: #383d41;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        .delete-btn {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 3px;
        }
        .delete-btn:hover {
            background-color: #c82333;
        }
        form {
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        form input, form select, form button {
            flex: 1;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 5px;
        }
        form button {
            background-color: #28a745;
            color: white;
            border: none;
        }
        form button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>BookNest Monthly Financial Tracker</h1>
    <div class="summary">
        <div class="income">
            <h3>Total Income</h3>
            <p id="total-income">$0.00</p>
        </div>
        <div class="expenses">
            <h3>Total Expenses</h3>
            <p id="total-expenses">$0.00</p>
        </div>
        <div class="balance">
            <h3>Net Balance</h3>
            <p id="net-balance">$0.00</p>
        </div>
    </div>
    <form id="transaction-form">
        <input type="hidden" name="action" value="add_transaction">
        <select name="type" required>
            <option value="Income">Income</option>
            <option value="Expense">Expense</option>
        </select>
        <input type="text" name="transaction_name" placeholder="Transaction Name" required>
        <input type="number" name="amount" placeholder="Amount" required>
        <input type="date" name="date" required>
        <button type="submit">Add Transaction</button>
    </form>
    <table>
        <thead>
        <tr>
            <th>Date</th>
            <th>Type</th>
            <th>Name</th>
            <th>Amount</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody id="transactions-table"></tbody>
    </table>
</div>
<script>
    document.getElementById('transaction-form').addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(e.target);
        const response = await fetch('index.php', {
            method: 'POST',
            body: formData
        });
        const result = await response.json();
        alert(result.message);
        loadSummary();
        loadTransactions();
    });

    async function loadSummary() {
        const response = await fetch('index.php?action=monthly_summary');
        const summary = await response.json();
        document.getElementById('total-income').innerText = `$${summary.income.toFixed(2)}`;
        document.getElementById('total-expenses').innerText = `$${summary.expenses.toFixed(2)}`;
        document.getElementById('net-balance').innerText = `$${summary.net_balance.toFixed(2)}`;
    }

    async function loadTransactions() {
        const response = await fetch('index.php?action=transactions');
        const transactions = await response.json();
        const tableBody = document.getElementById('transactions-table');
        tableBody.innerHTML = transactions.map(t => `
            <tr>
                <td>${t.date}</td>
                <td>${t.type}</td>
                <td>${t.transaction_name}</td>
                <td>$${parseFloat(t.amount).toFixed(2)}</td>
                <td><button class="delete-btn" onclick="deleteTransaction(${t.id})">Delete</button></td>
            </tr>`).join('');
    }

    async function deleteTransaction(id) {
        const response = await fetch('index.php', {
            method: 'DELETE',
            body: JSON.stringify({ id })
        });
        const result = await response.json();
        alert(result.message);
        loadSummary();
        loadTransactions();
    }

    loadSummary();
    loadTransactions();
</script>
</body>
</html>
