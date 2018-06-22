# TokenDesk PHP library for API v1

PHP library for TokenDesk API.

You can sign up for a TokenDesk account at <https://wallet.tokendesk.io> and get Auth Token.

More detailed API documentation can be found at <https://wallet.tokendesk.io/api/documentation>


## Manual Installation

Donwload [latest release](https://github.com/TokenDeskWallet/wallet-php/releases/) and include `lib/TokenDesk.php`

```php
require_once('/path/to/wallet-php/lib/TokenDesk.php');
```

## Getting Started

Usage of TokenDesk PHP library.

### Setting up TokenDesk library

#### Setting authentication

```php
$tokenDesk = new \TokenDesk\TokenDesk();

$tokenDesk->config(array(
     'auth_token' => 'YOUR_AUTH_TOKEN',
));

// $project = $tokenDesk->getProject($projectId);
```

# Use case

TokenDesk API is mainly used to create a Buy Tokens widget. There are several steps to accomplish this task using multiple calls to TokenDesk API.


### Step 1. Get project details

```php
$project = $tokenDesk->getProject('YOUR_PROJECT_ID'); // obtained from TokenDesk platform

print_r($project);
```

### Step 2. Generate "Buy Tokens" HTML form using data received from "getProject" method

```php
foreach ($project->payment_methods as $key => $payment_method) {
    echo $key;
    echo $payment_method->currency;
    echo $payment_method->min_order_amount;
    echo $payment_method->payment_method_title'
    // ...
    // ...
}

echo $project->data->token_name;
//...
//...
```

### Step 3. Usage of purchase calculator

Purchase calculator is used to get project prices based on payment method and desired amount of tokens to buy, or currency to spend. Method is used via proxy Ajax call in order not to send Auth Token from front end.

```php
$post_params = array(
    'projectId'        => 'YOUR_PROJECT_ID',
    'finalTokenAmount' => '100',
    'paymentMethod'    => 'eth',
    // ...
    // ...
)

$prices = $tokenDesk->purchaseCalculator($post_params);

print_r($prices);
```

### Step 4. Place an order

This method uses data received from "purchaseCalculator" method combined with user info.

```php
$post_params = array(
    'projectId'     => 'YOUR_PROJECT_ID',
    'paymentMethod' => 'eth',
    'email'         => 'user@example.com'
    // ...
    // ...
)

$order = $tokenDesk->createOrder($params);

print_r($order);
```

### Step 5. Payment step

Generate payment step HTML using data received from 'createOrder' method. Payment step displays where and how much a buyer has to transfer.

```php
echo($order->final_price);
echo($order->final_token_amount);
echo($order->payment_details->receiving_address);
// ...
// ...
```

### Step 6. Check order payment

Get status, if order is paid or not.

```php
$post_params = array(
    'orderId'     => $order->id,
    // ...
    // ...
)

$status = $tokenDesk->getOrderStatus($post_params);

print_r($status);
```

# Demo Application

Fully functional Demo Application which uses TokenDesk library included in this package. Take a note that there are no validations or error handling included.
