# omise-codeigniter
Easy omise payment library for Codeigniter

```
place it to /application/libraries
```
-----------------------

## Usage :

```
//init keys
$this->load->library('omise_api');
$this->omise_api->init('pkey', 'skey');  // replace with your keys
```

## Charge

```
//$card_token  recieved from card.js submit form  
//$amount use int as Satang
//$capture TRUE is capture immediately and set it false to capture later

$charge = $this->omise_api->create($card_token, $amount ="10000", $description, $capture = true, $currency = 'thb');
```

### for return_uri params I already got from generate Cards.js process if want you can uncomment that 

### Capture


if you charge with capture false, After you confirm order you can capture by this method
```
//$charge_id you got from $charge might be collect to your DBs
$result = $this->omise_api->capture($charge_id);
```

That's all.
