<?php
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $passwd = $_POST['login'] . ':' . crypt($_POST['password']);
    file_put_contents('/var/www/credentials', $passwd);
    header('Location: /');
    die('Reload the page');
  }
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Setup your ruTorrent account</title>
    <style type="text/css">
      html {
        background-color: #ccc;
      }
      body {
        background-color: #fff;
        border-radius: 10px;
        border: 1px solid #aaa;
        padding: 20px;
        width: 600px;
        margin: 50px auto;
        color: black;
        font-family: verdana;
      }
      h1 {
        border-bottom: 1px dashed #aaa;
        margin-top: 0;
        font-weight: normal;
      }
      .beware {
        color: #a00;
        font-weight: bold;
        font-size: 16px;
      }
      .error {
        background-color: rgba(255, 0, 0, 0.2);
        padding: 10px;
        font-weight: bold;
        font-size: 1.4em;
      }
      p {text-align: center;}
      table {
        width: 200px;
        margin: 0 auto;
      }
      form input {
        width: 100%;
      }
      .label {
        font-size: 13px;
      }
      input[type=password], input[type=text] {
        height: 20px;
        font-size: 14px;
      }
      input[type=submit] {
        margin-top: 20px;
        background:#5CCD00;
        background:-moz-linear-gradient(top,#5CCD00 0%,#4AA400 100%);
        background:-webkit-gradient(linear,left top,left bottom,color-stop(0%,#5CCD00),color-stop(100%,#4AA400));
        background:-webkit-linear-gradient(top,#5CCD00 0%,#4AA400 100%);
        background:-o-linear-gradient(top,#5CCD00 0%,#4AA400 100%);
        background:-ms-linear-gradient(top,#5CCD00 0%,#4AA400 100%);
        background:linear-gradient(top,#5CCD00 0%,#4AA400 100%);
        filter: progid: DXImageTransform.Microsoft.gradient( startColorstr='#5CCD00', endColorstr='#4AA400',GradientType=0);
        padding:10px 15px;
        color:#fff;
        font-family:'Helvetica Neue',sans-serif;
        font-size:16px;
        border-radius:5px;
        -moz-border-radius:5px;
        -webkit-border-radius:5px;
        border:1px solid #459A00
      }
    </style>
  </head>
  <body>
    <h1>Setup your account</h1>
    <p>
      Setup your account to access your torrents.
    </p>
    <p>
      <span class="beware">Beware: there's no easy way to reset your credentials.<br/>
      Take care to remember your login and password!</span>
    </p>

    <?php
      if (isset($error))
        echo '<div class="error">' . $error . '</div>';
    ?>

    <form method="POST" action="credentials.php">
      <table>
        <tr><td><input placeholder="Login" required id="login" name="login" type="text"></td></tr>
        <tr><td><input placeholder="Password" required id="password" name="password" type="password"></td></tr>
        <tr><td><input placeholder="Password confirmation" required id="passwordconf" name="passwordconf" oninput="check(this)" type="password"></td></tr>
        <tr><td><input type="submit" value="Create your account"></td></tr>
      </table>
    </form>

    <script type="text/javascript">
    function check(input) {
        if (input.value != document.getElementById('password').value) {
            input.setCustomValidity('The two passwords must match.');
        } else {
            input.setCustomValidity('');
       }
    }
    </script>
  </body>
</html>