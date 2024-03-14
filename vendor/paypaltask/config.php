<?php
/* 
 * PayPal and database configuration 
 */

// PayPal configuration 
define('PAYPAL_ID', 'sb-nee43x27967117@business.example.com');
define('PAYPAL_SANDBOX', TRUE); //TRUE or FALSE 

define('PAYPAL_RETURN_URL', 'http://localhost/project/vendor/paypaltask/success.php');
define('PAYPAL_CANCEL_URL', 'http://localhost/project/vendor/paypaltask/cancel.php');
define('PAYPAL_CURRENCY', 'USD');

// Change not required 
define('PAYPAL_URL', (PAYPAL_SANDBOX == true) ? "https://www.sandbox.paypal.com/cgi-bin/webscr" : "https://www.paypal.com/cgi-bin/webscr");
