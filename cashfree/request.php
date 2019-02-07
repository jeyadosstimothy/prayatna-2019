<?php
  require '../https_redirect.php';
?>
<!DOCTYPE html>
<html>
<head>
  <title>Cashfree - Signature Generator</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

</head>
<body onload="document.frm1.submit()">


<?php

require '../constants.php';

if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0 || time() > $onlinePaymentEndTime){
  header('Location: '.$domain.'/dashboard.php');
  exit;
}

// Create connection
$conn = new mysqli($db_server, $db_username, $db_password, $db_name);

// check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function loadWorkshops($conn) {
  $sql = 'select workshop_id, price, date from workshop_details';
  $result = $conn->query($sql);
  $workshops = array();
  while ($row = $result->fetch_assoc()) {
    $workshops[$row['workshop_id']] = array('price' => $row['price'], 'date' => $row['date']);
  }
  $sql = 'select workshop_id, user_id from register_details where user_id=?';
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $_COOKIE['user_id']);
  $result = $stmt->execute();
  $result = $stmt->get_result();
  while ($row = $result->fetch_assoc()) {
    $workshops[$row['workshop_id']]['registered'] = true;
  }
  ksort($workshops);
  return $workshops;
}

function isValidPost($workshops) {
  if(!(isset($_POST['type']) && ($_POST['type'] == 'workshop' || $_POST['type'] == 'entry'))) {
    return false;
  }
  if($_POST['type'] == 'workshop') {
    $count = 0;
    $selectedDates = array();
    $registeredDates = array();
    foreach ($workshops as $workshop_id => $workshop_details) {
      if($workshop_details['registered'])
        array_push($registeredDates, $workshop_details['date']);
    }
    foreach ($_POST['selectedWorkshop'] as $workshop_id) {
      if (!array_key_exists($workshop_id, $workshops)) {
        return false;
      }
      else if($workshops[$workshop_id]['registered']) {
        return false;
      }
      else if(in_array($workshops[$workshop_id]['date'], $registeredDates) || in_array($workshops[$workshop_id]['date'], $selectedDates)) {
        return false;
      }
      $count = $count + 1;
      array_push($selectedDates, $workshops[$workshop_id]['date']);
    }
    if($count == 0)
      return false;

  }
  return true;
}

function getOrderID($workshops) {
  $count = 0;
  $workshops_selected = 0;
  if($_POST['type'] == 'entry') {
    $workshops_selected |= (1<<$count);
  }
  elseif ($_POST['type'] == 'workshop') {
    $index = 1;
    foreach ($workshops as $workshop_id => $workshop_details) {
      if(in_array($workshop_id, $_POST['selectedWorkshop'])) {
        $workshops_selected |= (1<<$index);
      }
      $index = $index + 1;
    }
  }
  return uniqid($_COOKIE['user_id'].'_'.$workshops_selected.'_');
}

function getOrderAmount($workshops) {
  if($_POST['type'] == 'entry')
    return 249;
  elseif ($_POST['type'] == 'workshop') {
    $total = 0;
    foreach ($_POST['selectedWorkshop'] as $workshop_id) {
      $total = $total + $workshops[$workshop_id]['price'];
    }
    return $total;
  }
}

$workshops = loadWorkshops($conn);

$conn->close();

if(!isValidPost($workshops)) {
  header('Location: '.$domain.'/dashboard.php');
}

$mode = "TEST"; //<------------ Change to TEST for test server, PROD for production

$secretKey = "d6f31c94c68af1688741fbdaede78fdd68fadb7c"; // get from cashfree

$appId = '34996f73ac58c053e093fb309943'; // get from cashfree
$orderId = getOrderID($workshops);
$orderAmount = getOrderAmount($workshops);
$orderCurrency = 'INR';
$customerName = $_COOKIE['name'];
$customerPhone = $_COOKIE['phone'];
$customerEmail = $_COOKIE['email'];
$returnUrl = $domain.'/cashfree/response.php';
$notifyUrl = $domain.'/cashfree/response.php';

$postData = array(
  "appId" => $appId,
  "orderId" => $orderId,
  "orderAmount" => $orderAmount,
  "orderCurrency" => $orderCurrency,
  "customerName" => $customerName,
  "customerPhone" => $customerPhone,
  "customerEmail" => $customerEmail,
  "returnUrl" => $returnUrl,
  "notifyUrl" => $notifyUrl,
);
ksort($postData);
$signatureData = "";
foreach ($postData as $key => $value){
    $signatureData .= $key.$value;
}
$signature = hash_hmac('sha256', $signatureData, $secretKey,true);
$signature = base64_encode($signature);

if ($mode == "PROD") {
  $url = "https://www.cashfree.com/checkout/post/submit";
} else {
  $url = "https://test.cashfree.com/billpay/checkout/post/submit";
}


?>
  <form action="<?php echo $url; ?>" name="frm1" method="post">
      <p>Please wait.......</p>
      <input type="hidden" name="signature" value='<?php echo $signature; ?>'/>
      <input type="hidden" name="orderCurrency" value='<?php echo $orderCurrency; ?>'/>
      <input type="hidden" name="customerName" value='<?php echo $customerName; ?>'/>
      <input type="hidden" name="customerEmail" value='<?php echo $customerEmail; ?>'/>
      <input type="hidden" name="customerPhone" value='<?php echo $customerPhone; ?>'/>
      <input type="hidden" name="orderAmount" value='<?php echo $orderAmount; ?>'/>
      <input type ="hidden" name="returnUrl" value='<?php echo $returnUrl; ?>'/>
      <input type ="hidden" name="notifyUrl" value='<?php echo $notifyUrl; ?>'/>
      <input type="hidden" name="appId" value='<?php echo $appId; ?>'/>
      <input type="hidden" name="orderId" value='<?php echo $orderId; ?>'/>
  </form>
</body>
</html>
