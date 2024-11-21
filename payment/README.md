# khalti-ePayment-gateway
This core php project details the process of implementing the latest e-Payment Checkout platform released by Khalti ([khalti-epayment-gateway](https://docs.khalti.com/khalti-epayment/)).
The integration allows merchants to accept payments on their website using Khalti, providing a smooth and secure payment experience.

## Project Overview
This project demonstrates how to:
Initiate a Payment Request: Generate a unique purchase order and make a payment request to Khalti's API.
Handle Payment Callbacks: Process the response from Khalti after a user completes a payment.
Verify Payment Status: Use the Lookup API to confirm the status of a payment.

## Features
Simple integration with Khalti's e-Payment platform.
Secure payment processing.
Detailed response handling and error management.
Easy to extend and customize for your own needs.

## Prerequisites
xampp <br>
PHP 7.4 or higher <br>
cURL extension enabled <br>
Khalti merchant account // optional use test secret key

## Getting Started
Clone the repository:
```bash
git clone https://github.com/Deejs2/khalti-ePayment-gateway.git
cd khalti-ePayment-gateway
```
#### Note: This cloned repository should be in xampp>htdocs>khalti-ePayment-gateway

## Configure the project:
Update the configuration in payment-request.php with your localhost directory path:
```php
"return_url" => "http://localhost/khalti-payment/payment-response.php", //make changes here accordingly
"website_url" => "http://localhost/khalti-payment/", //here as well
```
#### If you follow the instruction then make changes like this: 
```php
"return_url" => "http://localhost/khalti-ePayment-gateway/payment-response.php", //make changes here accordingly
"website_url" => "http://localhost/khalti-ePayment-gateway/", //here as well
```

## Run the project:
Host the project on your local server or any PHP compatible hosting service.

## License
This project is licensed under the MIT License. See the LICENSE file for details.
