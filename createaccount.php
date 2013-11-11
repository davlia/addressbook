<?php
require_once "util.php";
define("VALID",          0);
define("BLANK",          1);
define("TOO_LONG",       2);
define("PWD_NO_MATCH",   3);
define("TOO_SHORT",      4);
define("USER_EXISTS",    5);

$isError = false;
$firstNameReturnCode = VALID;
$lastNameReturnCode = VALID;
$passwordReturnCode = VALID;
$uidStatus = VALID;
$message = NULL;

// Validate the first name field.
if (isset($_POST['first_name'])) {
    $_POST['first_name'] = trim($_POST['first_name']);
    $length = strlen($_POST['first_name']);
    if ($length == 0) {
        $firstNameReturnCode = BLANK;
        $isError = true;
    } elseif ($length > 20) {
        $firstNameReturnCode = TOO_LONG;
        $isError = true;
    }
}
// Validate the last name field.
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
// Validate the password.
if (isset($_POST['password'])) {
    $_POST['password'] = trim($_POST['password']);
    $_POST['confirm_password'] = trim($_POST['confirm_password']);
    $length = strlen($_POST['password']);
    if ($length < 6) {
        $passwordReturnCode = TOO_SHORT;
        $isError = true;
    } elseif ($length > 20) {
        $passwordReturnCode = TOO_LONG;
        $isError = true;
    } elseif (strcmp($_POST['password'], $_POST['confirm_password']) != 0) {
        $passwordReturnCode = PWD_NO_MATCH;
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
if (isset($_POST['user_id_hidden'])) {
    $_SESSION["user_id"] = trim(strip_tags($_POST['user_id_hidden']));
}
if (isset($_POST['password'])) {
    $_SESSION["password"] = trim(strip_tags($_POST['password']));
}
if (isset($_POST['admin'])) {
    $_SESSION["admin"] = "Yes";
} else {
    $_SESSION["admin"] = "No";
}

if (isset($_POST['first_name']) && !$isError) {
    // Validate that the user does not already exist.
    if (isset($_SESSION["user_id"])) {
        if (user_exists($_SESSION["user_id"])) {
            $uidStatus = USER_EXISTS;
            $isError = true;
        } else {
            $admin = strcmp($_SESSION["admin"], 'Yes') == 0;
            $results = create_user($_SESSION["user_id"], $_SESSION["last_name"], $_SESSION["first_name"], $_SESSION["password"], $admin);
            if ($results[0] == 0) {
                $message = "User account [" . $_SESSION["user_id"] . "] has successfully been created for " . $_SESSION["first_name"] . " " . $_SESSION["last_name"] . ".";
                unset($_SESSION["first_name"]);
                unset($_SESSION["last_name"]);
                unset($_SESSION["user_id"]);
                unset($_SESSION["password"]);
                unset($_SESSION["admin"]);
            } else {
                $message = "Error creating user account [" . $_SESSION["user_id"] . "] for " . $_SESSION["first_name"] . " " . $_SESSION["last_name"] . ".";
                foreach ($results[1] as $line) {
                    $message .= str_replace(' ', '&nbsp;', htmlentities($line)) . "<br />";
                }
            }
        }
    }
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
            document.forms['main_form'].user_id.value = '';
            document.forms['main_form'].user_id_hidden.value = '';
            document.forms['main_form'].admin.checked = false;
            document.getElementById('firstNameError').innerHTML = "test";
            //document.getElementById('firstNameError').innerHTML = "";
            document.getElementById('lastNameError').innerHTML = "";
            document.getElementById('passwordError').innerHTML = "";
            document.getElementById('errorMessage').innerHTML = "";
        }
    // -->
    </script>
  </head>

  <body onload="createUserId()">
    <?php include("adminmenu.php"); ?>
    <form id="main_form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <table border="0">
        <tr>
          <td>First name:</td>
          <td><input type="text" name="first_name" value="<?php if (isset($_SESSION["first_name"])) echo $_SESSION["first_name"]; ?>" maxlength="20"
               onblur="createUserId()"" /></td>
          <td id="firstNameError">
          
          </td>
        </tr>
        <tr>
          <td>Last name:</td>
          <td><input type="text" name="last_name" value="<?php if (isset($_SESSION["last_name"])) echo $_SESSION["last_name"]; ?>" maxlength="30"
               onblur=createUserId() /></td>
          <td id="lastNameError"><?php
            if ($lastNameReturnCode == BLANK) {
                echo "&nbsp;Last name is required.";
            } elseif ($lastNameReturnCode == TOO_LONG) {
                echo "&nbsp;Last name is too long. Should not be more than 30 characters.";
            }?></td>
        </tr>
        <tr>
          <td>User ID:</td>
          <td><input type="text" name="user_id" disabled /><input type="hidden" name="user_id_hidden" /></td>
          <td id="userIdError"></td>
        </tr>
        <tr>
          <td>Password:</td>
          <td><input type="password" name="password" maxlength="20" /></td>
          <td id="passwordError"><?php
            if ($passwordReturnCode == TOO_SHORT) {
                echo "&nbsp;Password must be at least 6 characters long.";
            } elseif ($passwordReturnCode == TOO_LONG) {
                echo "&nbsp;Password is too long. Should not be more than 20 characters.";
            } elseif ($passwordReturnCode == PWD_NO_MATCH) {
                echo "&nbsp;Passwords do not match.";
            }?></td>
        </tr>
        <tr>
          <td>Confirm password:</td>
          <td><input type="password" name="confirm_password" maxlength="20" /></td>
          <td></td>
        </tr>
        <tr>
          <td>Administrator?</td>
          <td><input type="checkbox" name="admin" <?php
            if (isset($_SESSION["admin"]) && $_SESSION["admin"] == 'Yes') {
                echo "checked=\"checked\"";
            } ?> /></td>
          <td></td>
        </tr>
        <tr>
          <td colspan="2">
            <input type="submit" value="Create Account" />
            <input type="button" name="resetButton" value="Reset Form" onclick="resetForm()" />
          </td>
          <td></td>
        </tr>
      </table>
      <br />
      <div id="errorMessage"><?php
      if ($uidStatus == USER_EXISTS) {
          echo "Error: User ID is already taken.";
      } elseif ($message != NULL) {
          echo $message;
      }?></div>
    </form>
  </body>
</html>
