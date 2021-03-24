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
  
  <title>Indie Depot - Game Page</title>
  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" 
        integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
   <link rel="stylesheet" type="text/css" href="css/custom.css" />

</head>

<body>

 <div class="container">

<?php
    require_once('appvars.php');
    require_once('connectvars.php');
    require_once('comments.php');
    
    $comments = new comments();
    


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



    //RETRIEVE $_GET['id'] so that the program knows which game to pull out of
    //the database
    
    if (isset($_GET['gameId']))
    {
        $id = $_GET['gameId'];
    }
    else if (isset($_POST['gameId']))
    {
        $id = $_POST['gameId'];
    }else {
        ?><p>$_GET['id'] && $_POST['id'] NOT SET</p><?php
    }
    
    // Connect to the database 
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME); 

    // Retrieve the games list data
    $query = "SELECT * FROM games where id='" . $_GET['gameId'] . "';";
    $data = mysqli_query($dbc, $query);


    // Loop through the array of games data, formatting it as HTML
    while ($row = mysqli_fetch_array($data)) 
    { 
        //OUTPUT GAME INFO FROM DATABASE
    ?>
        <div class="row">
        
            <div class="col-12 justify-content-center text-center">
            
                <h1><?php echo $row['title']; ?></h1>
            
            </div>
        
        </div>
        
        <br />
        
        <br />

      
        <div class="row justify-content-center ">
        
            
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
                        href="<?php echo $row['gameLink']; ?>"><------------- DOWNLOAD LINK -------------></a>
                
            </div>
                
                <br />
            
        </div>
        
    <?php
    }
    mysqli_close($dbc);
    
    //COMMENT SECTION - if user is logged in, give option to comment, else
    //prompt them to login *SHOW ALL COMMENTS REGARDLESS OF LOGIN CREDENTIALS*
    
    
    if (isset($_SESSION['user_id']))
    {
        if (isset($_POST['submitComment']))
        {
            $comments->enterComment();
            ?>
            <script>
                window.location.href = 'viewSingleGame.php?gameId=<?php echo $row['id']; ?>';
            </script>
            <?php
        }
        //DISPLAY COMMENT FORM
        $comments->commentForm();
        
    }
    else
    {
        ?>
            <br />
            <div class="row justify-content-center">
                <div class="col-12 text-center">
                    <p><a class="loginLink" href="login.php">Login</a> to leave a comment</p>
                </div>
            </div>
            <br />
            <br />
        <?php
    }
    $comments->displayComments();
  
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
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-12">
                <p>Boulder Beeman - PHP Capstone 2020</p>
            </div>
        </div>
    </div>
</footer>
</html>
