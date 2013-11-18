<?php
require_once("util.php");


define("VALID",          0);
define("BLANK",          1);
define("TOO_LONG",       2);
define("PWD_NO_MATCH",   3);
define("TOO_SHORT",      4);
define("USER_EXISTS",    5);

$isError = false;
$firstNameReturnCode = VALID;
$lastNameReturnCode = VALID;
$middleInitialReturnCode = VALID;
$phoneReturnCode = VALID;
$addressReturnCode = VALID;
$aptReturnCode = VALID;
$townReturnCode = VALID;
$stateReturnCode = VALID;
$zipcodeReturnCode = VALID;

if (isset($_POST['first_name'])) {
    $_POST['first_name'] = trim($_POST['first_name']);
    $length = strlen($_POST['first_name']);    
    if ($length == 0) {
        $firstNameReturnCode = BLANK;
        $isError = true;
    } elseif ($length > 30) {
        $firstNameReturnCode = TOO_LONG;
        $isError = true;
    }
}
if (isset($_POST['last_name'])) {
    $_POST['last_name'] = trim($_POST['last_name']);
    $length = strlen($_POST['last_name']);    
    if ($length == 0) {
        $lastNameReturnCode = BLANK;
        $isError = true;
    } elseif ($length > 30) {
        $lastNameReturnCode = TOO_LONG;
        $isError = true;
    }
}
if (isset($_POST['middle_initial'])) {
    $_POST['middle_initial'] = trim($_POST['middle_initial']);
    $length = strlen($_POST['middle_initial']);    
    if ($length > 1) {
        $middleInitialReturnCode = TOO_LONG;
        $isError = true;
    }
}
if (isset($_POST['phone_number'])) {
    $_POST['phone_number'] = trim($_POST['phone_number']);
    $length = strlen($_POST['phone_number']);    
    if ($length == 0) {
        $phoneReturnCode = BLANK;
        $isError = true;
    } elseif ($length > 20) {
        $phoneReturnCode = TOO_LONG;
        $isError = true;
    }
}

if (isset($_POST['address'])) {
    $_POST['address'] = trim($_POST['address']);
    $length = strlen($_POST['address']);    
    if ($length == 0) {
        $addressReturnCode = BLANK;
        $isError = true;
    } elseif ($length > 255) {
        $addressReturnCode = TOO_LONG;
        $isError = true;
    }
}

if (isset($_POST['apt'])) {
    $_POST['apt'] = trim($_POST['apt']);
    $length = strlen($_POST['apt']);    
    if ($length == 0) {
        $aptReturnCode = BLANK;
        $isError = true;
    } elseif ($length > 20) {
        $aptReturnCode = TOO_LONG;
        $isError = true;
    }
}

if (isset($_POST['town'])) {
    $_POST['town'] = trim($_POST['town']);
    $length = strlen($_POST['town']);    
    if ($length == 0) {
        $townReturnCode = BLANK;
        $isError = true;
    } elseif ($length > 35) {
        $townReturnCode = TOO_LONG;
        $isError = true;
    }
}

if (isset($_POST['state'])) {
    $_POST['state'] = trim($_POST['state']);
    $length = strlen($_POST['state']);    
    if ($length == 0) {
        $stateReturnCode = BLANK;
        $isError = true;
    } elseif ($length > 2) {
        $stateReturnCode = TOO_LONG;
        $isError = true;
    }
}

if (isset($_POST['zipcode'])) {
    $_POST['zipcode'] = trim($_POST['zipcode']);
    $length = strlen($_POST['zipcode']);    
    if ($length == 0) {
        $zipcodeReturnCode = BLANK;
        $isError = true;
    } elseif ($length > 5) {
        $zipcodeReturnCode = TOO_LONG;
        $isError = true;
    }
}

session_start();

if (isset($_POST['first_name'])) {
    $_SESSION["first_name"] = trim(strip_tags($_POST['first_name']));
}
if (isset($_POST['last_name'])) {
    $_SESSION["last_name"] = trim(strip_tags($_POST['last_name']));
}
if (isset($_POST['middle_initial'])) {
    $_SESSION["middle_initial"] = trim(strip_tags($_POST['middle_initial']));
}
if (isset($_POST['phone_number'])) {
    $_SESSION["phone_number"] = trim(strip_tags($_POST['phone_number']));
}
if (isset($_POST['address'])) {
    $_SESSION["address"] = trim(strip_tags($_POST['address']));
}
if (isset($_POST['apt'])) {
    $_SESSION["apt"] = trim(strip_tags($_POST['apt']));
}
if (isset($_POST['town'])) {
    $_SESSION["town"] = trim(strip_tags($_POST['town']));
}
if (isset($_POST['state'])) {
    $_SESSION["state"] = trim(strip_tags($_POST['state']));
}
if (isset($_POST['zipcode'])) {
    $_SESSION["zipcode"] = trim(strip_tags($_POST['zipcode']));
}
if (isset($_POST['zipext'])) {
    $_SESSION["zipext"] = trim(strip_tags($_POST['zipext']));
}
    
?>
<html>
  <head>
    <title>Create Account</title>
    <script type="text/javascript">
    <!--
        function resetForm() {
            document.forms['main_form'].first_name.value = '';
            document.forms['main_form'].last_name.value = '';
            document.forms['main_form'].middle_initial.value = '';
            document.forms['main_form'].phone_number.value = '';
            document.forms['main_form'].address.value = '';
            document.forms['main_form'].apt.value = '';
            document.forms['main_form'].town.value = '';
            document.forms['main_form'].state.value = '';
            document.forms['main_form'].zipcode.value = '';
            document.forms['main_form'].zipext.value = '';

            document.getElementById('firstNameError').innerHTML = "";
            document.getElementById('lastNameError').innerHTML = "";
            document.getElementById('middleInitialError').innerHTML = "";
            document.getElementById('phoneError').innerHTML = "";
            document.getElementById('aptError').innerHTML = "";
            document.getElementById('addressError').innerHTML = "";
            document.getElementById('townError').innerHTML = "";
            document.getElementById('stateError').innerHTML = "";
            document.getElementById('zipcodeError').innerHTML = "";
            document.getElementById('zipextError').innerHTML = "";

        }
    // -->
    </script>
  </head>
  <body>
      <form  id="main_form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <table border="0">
      <tr>
        <td>First name</td>
        <td><input type="text" name="first_name" value="<?php if (isset($_SESSION["first_name"])) echo $_SESSION["first_name"]; ?>" maxlength="30" /></td>
        <td id="firstNameError"><?php
            displayLengthError($firstNameReturnCode, "First name", 30);
            ?>
        </td>
     </tr>
     <tr>
       <td>Last name</td>
       <td><input type="text" name="last_name" value="<?php if (isset($_SESSION["last_name"])) echo $_SESSION["last_name"]; ?>" maxlength="255" /></td>
       <td id="lastNameError"> <?php
            displayLengthError($lastNameReturnCode, "Last name", 255);
            ?>
       </td>
    </tr>
         <tr>
             <td>Middle initial</td>
             <td><input type="text" name="middle_initial" value="<?php if (isset($_SESSION["middle_initial"])) echo $_SESSION["middle_initial"]; ?>" maxlength="30" /></td>
             <td id="middleInitialError"> <?php
            displayLengthError($middleInitialReturnCode, "Middle initial", 30);
            ?>
           </td>
         </tr>
         <tr>
             <td>Phone number</td>
             <td><input type="text" name="phone_number" value="<?php if (isset($_SESSION["phone_number"])) echo $_SESSION["phone_number"]; ?>" maxlength="30" /></td>
             <td id="phoneError"> <?php
            displayLengthError($phoneReturnCode, "Phone number", 30);
            ?>
           </td>
         </tr>
         <tr>
             <td>Apt</td>
             <td><input type="text" name="apt" value="<?php if (isset($_SESSION["apt"])) echo $_SESSION["apt"]; ?>" maxlength="30" /></td>
             <td id="aptError"> <?php
            displayLengthError($aptReturnCode, "Apartment number", 30);
            ?>
           </td>
         </tr>
      <tr>
             <td>Address</td>
             <td><input type="text" name="address" value="<?php if (isset($_SESSION["address"])) echo $_SESSION["address"]; ?>" maxlength="30" /></td>
             <td id="addressError"> <?php
            displayLengthError($addressReturnCode, "Address", 30);
            ?>
           </td>
         </tr>
         <tr>
             <td>Town</td>
             <td><input type="text" name="town" value="<?php if (isset($_SESSION["town"])) echo $_SESSION["town"]; ?>" maxlength="30" /></td>
             <td id="townError"> <?php
            displayLengthError($townReturnCode, "Town", 30);
            ?>
           </td>
         </tr>
         <tr>
             <td>State</td>
             <td><input type="text" name="state" value="<?php if (isset($_SESSION["state"])) echo $_SESSION["state"]; ?>" maxlength="30" /></td>
             <td id="stateError"> <?php
            displayLengthError($stateReturnCode, "State", 30);
            ?>
           </td>
         </tr>
         <tr>
             <td>Zipcode</td>
             <td><input type="text" name="zipcode" value="<?php if (isset($_SESSION["zipcode"])) echo $_SESSION["zipcode"]; ?>" maxlength="30" /></td>
             <td id="zipcodeError"> <?php
            displayLengthError($zipcodeReturnCode, "Zipcode", 30);
            ?>
           </td>
         </tr>
         <tr>
             <td>Zipcode extension</td>
             <td><input type="text" name="zipext" value="<?php if (isset($_SESSION["zipext"])) echo $_SESSION["zipext"]; ?>" maxlength="30" /></td>
             <td id="zipextError"> <?php
            displayLengthError($zipcodeReturnCode, "Zipcode extension", 30);
            ?>
           </td>
         </tr>
         <tr>
        <td colspan="2">
          <input type="submit" value="Create Account" />
          <input type="button" name="resetButton" value="Reset Form" onclick="resetForm()" />
        </td>
        <td></td>
      </tr>
    </table>
  </body>
</html>
