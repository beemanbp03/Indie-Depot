<?php
  session_start();

  // If the session vars aren't set, try to set them with a cookie
  if (!isset($_SESSION['user_id'])) {
    if (isset($_COOKIE['user_id']) && isset($_COOKIE['username'])) {
      $_SESSION['user_id'] = $_COOKIE['user_id'];
      $_SESSION['username'] = $_COOKIE['username'];
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

    <title>Indie Depot - View Profile</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" 
        integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/custom.css" />
</head>
<body>
    
<div class="container">
<?php
  require_once('appvars.php');
  require_once('connectvars.php');
  
  // Generate the navigation menu
    
    if (isset($_SESSION['username'])) 
    {
        //IF the Session variable "username" is set to "boulder", this user is
        //an admin, so show administrator nav bar
        if ($_SESSION['username'] == 'boulder') 
        {
            
            echo ' <nav class="navbar navbar-default>';
            echo '   <a class="navbar-brand" href="index.php"></a>';
            echo '   <ul class="nav justify-content-center">';
            echo '    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>';
            echo '    <li class="nav-item"><a class="nav-link" href="admin.php">Admin (' . $_SESSION['username'] . ')</a></li>';
            echo '    <li class="nav-item"><a class="nav-link" href="gameEntry.php">Submit A Game</a></li>';
            echo '    <li class="nav-item"><a class="nav-link" href="viewGames.php">View Games</a></li>';
            echo '    <li class="nav-item"><a class="nav-link" href="editProfile.php">Edit Profile</a></li>';
            echo '    <li class="nav-item"><a class="nav-link" href="viewProfile.php">View Profile</a></li>';
            echo '    <li class="nav-item"><a class="nav-link" href="logout.php">Log Out (' . $_SESSION['username'] . ')</a></li>';
            echo '   </ul>';
            echo ' </nav>';
        }
        //ELSE this user is not an admin, but they are a logged in member, so show
        //member nav bar
        else
        {
            echo ' <nav class="navbar navbar-default>';
            echo '   <a class="navbar-brand" href="index.php"></a>';
            echo '   <ul class="nav justify-content-center">';
            echo '    <li class="nav-item"><a class="navbar-brand" href="index.php">Home</a></li>';
            echo '    <li class="nav-item"><a class="nav-link" href="gameEntry.php">Submit A Game</a></li>';
            echo '    <li class="nav-item"><a class="nav-link" href="viewGames.php">View Games</a></li>';
            echo '    <li class="nav-item"><a class="nav-link" href="editProfile.php">Edit Profile</a></li>';
            echo '    <li class="nav-item"><a class="nav-link" href="viewProfile.php">View Profile</a></li>';
            echo '    <li class="nav-item"><a class="nav-link" href="logout.php">Log Out (' . $_SESSION['username'] . ')</a></li>';
            echo '   </ul>';
            echo ' </nav>';
        }
    }
    //ELSE Session variable "username" is not set, which means this user is a guest
    //at this point in time, so show the guest nav bar
    else 
    {
        echo ' <nav class="navbar navbar-default>';
        echo '   <a class="navbar-brand" href="index.php"></a>';
        echo '   <ul class="nav justify-content-center">';
        echo '    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>';
        echo '    <li class="nav-item"><a class="nav-link" href="viewGames.php">View Games</a></li>';
        echo '    <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>';
        echo '    <li class="nav-item"><a class="nav-link" href="signup.php">Sign up</a></li>';
        echo '   </ul>';
        echo ' </nav>';
    }
  
    //HTML Page Heading
    ?>
        <div class="row">
            <div class="col-12 justify-content-center text-center">
                <h1 class="pageTitle">Indie Depot - View Profile</h1>
            </div>
        </div>
     
    <?php
    

  // Connect to the database
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  // Grab the profile data from the database
  if (!isset($_GET['username'])) {
    $query = "SELECT firstName, lastName, gender, dateOfBirth, oldPicture, bio FROM user_info WHERE username = '" . $_SESSION['username'] . "'";
  }
  $data = mysqli_query($dbc, $query)
    or die('ERROR SELECTING FROM DATABASE');

  //OUTPUT USER PROFILE INFORMATION FROM DATABASE (indieDepot.sql > games)
  if (mysqli_num_rows($data) == 1) {
    // The user row was found so display the user data
    $row = mysqli_fetch_array($data);

    
    //Output FULL Profile Info
    if ( !empty($row['oldPicture']) && !empty($row['firstName']) && 
            !empty($row['lastName']) && !empty($row['dateOfBirth']) 
            && !empty($row['gender']))
    {
        //HTML PROFILE DATA
        
        //Output Profile Picture
        if (!empty($row['oldPicture'])) 
        {
            //show user their picture
            echo ' <div class="row justify-content-center"><div class="col-3 textBox text-center"><p><img src="' . EP_UPLOADPATH . $row['oldPicture'] .
            '" alt="Profile Picture" " /></p></div> ';
        } 
        else 
        {
            ?> <div class="col-3 textBox"><p>There was no picture to load.</p> <?php
        }
        
        
        //Output FULL name (firstName, lastName) in HTML
        ?>
        
            <div class="col-3 textBox">
                <p>Name: <?php echo $row['firstName'] . " " . $row['lastName']; ?></p>
            </div>
                
        <?php
        //Output full date of birth if its the user's profile, output
        //only the year if another user is viewing the page
        if (!isset($_GET['id']) || ($_SESSION['user_id'] == $_GET['id']))
        {
            // Show the user their own birthdate
            ?><div class="col-3 textBox"><p>Birthdate: <?php echo $row['dateOfBirth'];?></p></div> <?php
        }
        else 
        {
            // Show only the birth year for everyone else
            list($year, $month, $day) = explode('-', $row['dateOfBirth']);
            ?><div class="col-3 textBox"><p>Year born: <?php echo $year;?></p></div><?php
        }
        
        //OUTPUT GENDER
        if (!empty($row['gender'])) 
        {
                ?> <div class="col-3 textBox"><p>Gender: <?php
            if ($row['gender'] == 'M') {
                ?> Male <?php
            }
            else if ($row['gender'] == 'F') {
                ?> Female <?php
            }
            else 
            {
                ?> ? <?php
            }
            ?> </p></div> <?php
        }
        
        ?> </div> <?php
        
        /*
        //OUTPUT BIO
        if (!empty($row['bio']))
        {
        */
            ?>
            <div class="row justify-content-center">
                
                <div class="col-12 textBox">
                    <p class="text-center">
                    ----------------------------- BIO -----------------------------
                    </p>
                    <p>
                        <?php echo $row['bio']; ?>
                    </p>
                </div>
            </div>
            <?php
        /*
        }
        */
    }
    
    
    if (!isset($_GET['id']) || ($_SESSION['user_id'] == $_GET['id'])) {
      echo '<div class="row justify-content-center text-center">';
      echo '<div class="col-12">';
      //echo '<p>Would you like to <a href="editProfile.php">edit your profile</a>?</p></div></div>';
    }
  } // End of check for a single row of user results
  else {
    echo '<div class="row justify-content-center text-center">';
    echo '<div class="col-12">';
    echo '<p class="error">There\'s no profile information to pull up. Please visit Edit Profile page to customize your profile.</p></div></div>';
  }
  
  
?>

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
