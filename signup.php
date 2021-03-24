<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
 <head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  
  <title>Indie Depot - Sign Up</title>
  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" 
        integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="css/custom.css" />
  

 </head>
 
<body>


<div class="container">
  
<?php
    require_once('appvars.php');
    require_once('connectvars.php');
    
    
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


    
    //Connect to the database
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
        or die('Error Connecting To Database');
        
    if (isset($_POST['submit']))
    {
        //Set profile data from the signup form POST
        $username = mysqli_real_escape_string($dbc, trim($_POST['username']));
        $password1 = mysqli_real_escape_string($dbc, trim($_POST['password1']));
        $password2 = mysqli_real_escape_string($dbc, trim($_POST['password2']));
        
        //If all three form fields for username, password1, and passowrd2
        //are NOT EMPTY
        if (!empty($username) && !empty($password1) && !empty($password2) &&
                ($password1 == $password2)) 
        {
            //Select everyhing from the mismatch_user table and check for the
            //$username variable
            $query = "SELECT * FROM user_login WHERE username = '$username'";
            $data = mysqli_query($dbc, $query)
                or die("...ERROR QUERYING THE DATABASE FOR SELECT QUERY...");
            
            //Check if the query ($data) returned any rows of results
            if (mysqli_num_rows($data) == 0)
            {
                //There is no matching username in the database, because the
                //query ($data) returned 0 rows of data, so insert the data
                //into the database
                $query1 = "INSERT INTO user_login (username, password) " .
                        "VALUES ('$username', SHA('$password1'));";
                mysqli_query($dbc, $query1)
                    or die("...ERROR QUERYING THE DATABASE FOR INSERT QUERY 1...");
                    
                $query2 = "INSERT INTO user_info (username) VALUES ('$username');";
                mysqli_query($dbc, $query2)
                    or die("...ERROR QUERYING THE DATABASE FOR INSERT QUERY 2...");
                    
                
                //Send Feedback: Success!
                echo '<p>Your new account has been successfuly created. ' . 
                        'You\'re now ready to <a href="login.php">' .
                        'Log In</a>.</p>';
                        
                mysqli_close($dbc);
                exit();
            }
            //A user with that username already exists in the database
            else
            {
                echo '<p class="error">An account already exists for this username. ' .
                        'Please use a different username.</p>';
                $username = "";
            }
        }
        //One of the conditions failed, which means there must be an empty
        //field somewhere
        else
        {
            echo '<p class="error">You must enter all of the sign-up data, ' . 
                    'including the desired password twice.</p>';
        }
    }
    
    mysqli_close($dbc);

?>
 <div class="row justify-content-center">
 
  <div class="col-12 text-center">
   <h1>Sign Up!</h1>
  </div>
  
  <br />
  
  <div class="col-6">
   <p>Please enter your username and desired password to sign up with Indie Depot.</p>
  </div>
  
 </div>
  
  <div class="row justify-content-center">
      <div class="col-6">
          <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
              <div class="form-group">
                  <label for="username">Username:</label>
                  <input type="text" class="form-control" id="username" name="username" value="<?php if (!empty($username)) echo $username; ?>" /><br />
              </div>
              <div class="form-group">
                  <label for="password1">Password:</label>
                  <input type="password" class="form-control" id="password1" name="password1" /><br />
              </div>
              <div class="form-group">
                  <label for="password2">Password (retype):</label>
                  <input type="password" class="form-control" id="password2" name="password2" /><br />
              </div>

            <input type="submit" id="submitButton" class="form-control" value="Sign Up" name="submit" />
          </form>
      </div>
  </div>
  
  
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
