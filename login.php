<?php
  require_once('connectvars.php');

  // Start the session
  session_start();

  // Clear the error message
  $error_msg = "";

  // If the user isn't logged in, try to log them in
  if (!isset($_SESSION['user_id'])) 
  {
    if (isset($_POST['submit'])) 
    {
      // Connect to the database
      $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

      // Grab the user-entered log-in data
      $user_username = mysqli_real_escape_string($dbc, trim($_POST['username']));
      $user_password = mysqli_real_escape_string($dbc, trim($_POST['password']));

      if (!empty($user_username) && !empty($user_password)) 
      {
        // Look up the username and password in the database
        $query = "SELECT id, username FROM user_login WHERE username = '$user_username' AND password = SHA('$user_password')";
        $data = mysqli_query($dbc, $query)
            or die("ERROR SELECTING FROM DATABASE");

        if (mysqli_num_rows($data) == 1) 
        {
          // The log-in is OK so set the user ID and username session vars (and cookies), and redirect to the home page
          $row = mysqli_fetch_array($data);
          $_SESSION['user_id'] = $row['id'];
          $_SESSION['username'] = $row['username'];
          setcookie('user_id', $row['id'], time() + (60 * 60 * 24 * 30));    // expires in 30 days
          setcookie('username', $row['username'], time() + (60 * 60 * 24 * 30));  // expires in 30 days
          $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';
          header('Location: ' . $home_url);
        }
        else 
        {
          // The username/password are incorrect so set an error message
          $error_msg = 'Sorry, you must enter a valid username and password to log in.';
        }
      }
      else 
      {
        // The username/password weren't entered so set an error message
        $error_msg = 'Sorry, you must enter your username and password to log in.';
      }
    }
  }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  
  <title>Login!</title>
  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" 
        integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="css/custom.css" />

</head>
<body>

<div class="container">


<?php
  //Generate Navigation Menu


    echo ' <nav class="navbar navbar-default>';
    echo '   <a class="navbar-brand" href="index.php"></a>';
    echo '   <ul class="nav justify-content-center">';
    echo '    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>'; 
    echo '    <li class="nav-item"><a class="nav-link" href="viewGames.php">View Games</a></li>';  
    echo '    <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>';
    echo '    <li class="nav-item"><a class="nav-link" href="signup.php">Sign up</a></li>';
    echo '   </ul>';
    echo ' </nav>';


  
  // If the session var is empty, show any error message and the log-in form; otherwise confirm the log-in
  if (empty($_SESSION['user_id'])) 
  {
    echo '<p class="error">' . $error_msg . '</p>';
    
?>
<div class="row justify-content-center">
 <div class="col-6 text-center">
  <h1>Login!</h1>
    <br />
  <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <div class="form-group">
          <label for="username">Username:</label>
          <input type="text" class="form-control" name="username" value="<?php if (!empty($user_username)) echo $user_username; ?>" /><br />
      </div>
      <div class="form-group">
          <label for="password">Password:  </label>
          <input type="password" class="form-control" name="password" />
      </div>
      <input type="submit" id="submitButton" class="form-control" value="Log In" name="submit" />
   </form>
  </div>
 </div>

<?php
  }
  else 
  {
    // Confirm the successful log-in
    echo('<p class="login">You are logged in as ' . $_SESSION['username'] . '.</p>');
  }
?>

  <!-- jQuery first, then Tether, then Bootstrap JS. -->
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" 
            integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" 
            integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" 
            integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>

</div>
</body>
<footer>
    <br />
    <div class="row justify-content-center text-center">
        <div class="col-12">
            <p>Boulder Beeman - PHP Capstone 2020</p>
        </div>
    </div>
</footer>
</html>
