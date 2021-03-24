<?php
  session_start();

  // If the session vars aren't set, try to set them with a cookie
  if (!isset($_SESSION['user_id'])) 
  {
    if (isset($_COOKIE['user_id']) && isset($_COOKIE['username'])) 
    {
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
  
  <title>Indie Depot</title>
  
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

  
?>

        <div class="row">
        
            <div class="col-12 text-center justify-content-center">
                <h1>Indie Depot<h1>
            </div>
            
        </div>
        
        <br />
        
        <div class="row text-center justify-content-center textBox">
        
            <div class="col-4">
                <p class="large-text">--Indie--</p>
            </div>
        
        
        
            <div class="col-4">
                <p class="large-text">--Games--</p>
            </div>
       
        
        
            <div class="col-4">
                <p class="large-text">--Rule--</p>
            </div>
            
            <div class="col-12">
                <strong><p class="textBox">Indie Depot is a place where fans of 
                        indie style games can play other developers games, 
                        discover all kinds of new genre's, and share their 
                        own creations</p></strong>
            </div>
            
        </div>
        
        <br />
        
    <?php
    // Connect to the database 
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME); 

    // Retrieve the games list data
    $query = "SELECT * FROM games order by id desc limit 1";
    $data = mysqli_query($dbc, $query);

    //HTML H1 tag
    ?>
    <br />
    <div class="row justify-content-left">
        <div class="col-12 text-left">
            <h2>Latest Entry</h2>
        </div>
    </div>
    <?php

    // Loop through the array of games data, formatting it as HTML
    while ($row = mysqli_fetch_array($data)) 
    { 
        //OUTPUT GAME INFO FROM DATABASE
    ?>
    
        <br />

      
        <div class="row justify-content-center ">
        
            <div class="col-12 text-center textBox">
            
                <h3><?php echo $row['title']; ?></h3>
                
            </div> 
            
            <div class="col-2 text-center textBox">
            
                <p>
                    <?php echo '<img src="' . ICON_UPLOADPATH . $row['icon'] . '" alt="Profile Picture" />'; ?>
                </p>
                
            </div>
                
                <br />
                
            <div class="col-5 text-center textBox">
                
                <p>
                    -------- AUTHOR --------
                </p>
                
                <p class="large-text">
                    <?php echo $row['author']; ?>
                </p>
                
            </div>
                
                <br />
            <div class="col-5 text-center textBox">
            
                <p>
                    ---- DATE SUBMITTED -----
                </p>
                
                <p class="large-text">
                    <?php echo $row['pubDate']; ?>
                </p>
                
            </div>
            
            <div class="col-12 text-center textBox">
                <p class="text-center">
                    ---------------------- DESCRIPTION ----------------------
                </p>
                <br />
                <p>
                    <?php echo $row['description']; ?>
                </p>
            </div>
            
            <div class="col-12 textBoxSolid text-center large-text">
                
                <a class="large-text"
                        href="viewSingleGame.php?gameId=<?php echo $row['id']; ?>"><--------------- VISIT PAGE ---------------></a>
                        
            </div>
                
                <br />
            
        </div>
        
    <?php
    }

    mysqli_close($dbc);
    ?>

        <!-- jQuery first, then Tether, then Bootstrap JS. -->
        <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" 
                integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" 
                integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" 
                integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>

        <!--END PAGE CONTAINER-->
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
