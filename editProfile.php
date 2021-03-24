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
  
  <title>Indie Depot - Edit Profile</title>
  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" 
        integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="css/custom.css" />
   
</head>
<body>

  <div class="container">
  
  
<?php
  require_once('appvars.php');
  require_once('connectvars.php');
  
  
  //echo SESSION ID and username
  //echo $_SESSION['user_id'];
  //echo $_SESSION['username'];
  
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
  

  // Connect to the database
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  if (isset($_POST['submit'])) {
    // Grab the profile data from the POST
    $first_name = mysqli_real_escape_string($dbc, trim($_POST['firstName']));
    $last_name = mysqli_real_escape_string($dbc, trim($_POST['lastName']));
    $gender = mysqli_real_escape_string($dbc, trim($_POST['gender']));
    $birthdate = mysqli_real_escape_string($dbc, trim($_POST['dateOfBirth']));
    $bio = mysqli_real_escape_string($dbc, trim($_POST['bio']));
    $old_picture = mysqli_real_escape_string($dbc, trim($_POST['oldPicture']));
    $new_picture = mysqli_real_escape_string($dbc, trim($_FILES['newPicture']['name']));
    $new_picture_type = $_FILES['newPicture']['type'];
    $new_picture_size = $_FILES['newPicture']['size']; 
    $error = false;

    // Validate and move the uploaded picture file, if necessary
    if (!empty($new_picture)) {
      list($new_picture_width, $new_picture_height) = getimagesize($_FILES['newPicture']['tmp_name']);
      if ((($new_picture_type == 'image/gif') || ($new_picture_type == 'image/jpeg') || ($new_picture_type == 'image/pjpeg') ||
        ($new_picture_type == 'image/png')) && ($new_picture_size > 0) && ($new_picture_size <= EP_MAXFILESIZE) &&
        ($new_picture_width <= EP_MAXIMGWIDTH) && ($new_picture_height <= EP_MAXIMGHEIGHT)) {
        
          // Move the file to the target upload folder
          $target = EP_UPLOADPATH . basename($new_picture);
          if (move_uploaded_file($_FILES['newPicture']['tmp_name'], $target)) {
            // The new picture file move was successful, now make sure any old picture is deleted
            if (!empty($old_picture) && ($old_picture != $new_picture)) {
              @unlink(EP_UPLOADPATH . $old_picture);
            }
          }
          else {
            // The new picture file move failed, so delete the temporary file and set the error flag
            @unlink($_FILES['newPicture']['tmp_name']);
            $error = true;
            echo '<p class="error">Sorry, there was a problem uploading your picture.</p>';
            
          }
        
      }
      else {
        // The new picture file is not valid, so delete the temporary file and set the error flag
        @unlink($_FILES['newPicture']['tmp_name']);
        $error = true;
        echo '<p class="error">Your picture must be a GIF, JPEG, or PNG image file no greater than ' . (EP_MAXFILESIZE / 1024) .
          ' KB and ' . EP_MAXIMGWIDTH . 'x' . EP_MAXIMGHEIGHT . ' pixels in size.</p>';
      }
    }

    // Update the profile data in the database
    if (!$error) {
      if (!empty($first_name) && !empty($last_name) && !empty($gender) && !empty($birthdate)) {
        // Only set the picture column if there is a new picture
        if (!empty($new_picture)) {
          $query = "UPDATE user_info SET firstName = '$first_name', lastName = '$last_name', gender = '$gender', " .
            " dateOfBirth = '$birthdate', oldPicture = '$new_picture', bio = '$bio' WHERE username = '" . $_SESSION['username'] . "'";
        }
        else {
          $query = "UPDATE user_info SET firstName = '$first_name', lastName = '$last_name', gender = '$gender', " .
            " dateOfBirth = '$birthdate', bio = '$bio' WHERE username = '" . $_SESSION['username'] . "'";
        }
        mysqli_query($dbc, $query)
            or die("ERROR QUERYING THE DATABASE");

        // Confirm success with the user
        echo '<p>Your profile has been successfully updated. Would you like to <a href="viewProfile.php">view your profile</a>?</p>';

        mysqli_close($dbc);
        exit();
      }
      else {
        echo '<p class="error">You must enter all of the profile data (the picture is optional).</p>';
      }
    }
  } // End of check for form submission
  else {
    // Grab the profile data from the database
    $query = "SELECT firstName, lastName, gender, dateOfBirth, oldPicture, bio FROM user_info WHERE username = '" . $_SESSION['username'] . "'";
    $data = mysqli_query($dbc, $query);
    $row = mysqli_fetch_array($data);

    if ($row != NULL) {
      $first_name = $row['firstName'];
      $last_name = $row['lastName'];
      $gender = $row['gender'];
      $birthdate = $row['dateOfBirth'];
      $old_picture = $row['oldPicture'];
      $bio = $row['bio'];
    }
    else {
      echo '<p class="error">No profile information has been set.</p>';
    }
  }

  mysqli_close($dbc);
  
?>
    <div class="row">
        <div class="col-12 text-center justify-content-center">
            <h1 class="pageTile">Indie Depot - Edit Profile</h1>
        </div>
    </div>
    
    <br />
    
    <div class="row justify-content-center">
    
        <div class="col-6">
        
            <form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MM_MAXFILESIZE; ?>" />
                <fieldset>
                
                  <div class="form-group">
                  <label for="firstName">First name:</label>
                  <input type="text" id="firstName" class="form-control" name="firstName" value="<?php if (!empty($first_name)) echo $first_name; ?>" >
                  </div>
                  
                  <br />
                  
                  <div class="form-group">
                  <label for="lastName">Last name:</label>
                  <input type="text" id="lastName" class="form-control" name="lastName" value="<?php if (!empty($last_name)) echo $last_name; ?>" >
                  </div>
                  
                  <br />
                  
                  <div class="form-group">
                  <label for="gender">Gender:</label>
                  <select id="gender" class="form-control" name="gender" required>
                    <option value="M" <?php if (!empty($gender) && $gender == 'M') echo 'selected = "selected"'; ?>>Male</option>
                    <option value="F" <?php if (!empty($gender) && $gender == 'F') echo 'selected = "selected"'; ?>>Female</option>
                  </select>
                  </div>
                  
                  <br />
                  
                  <div class="form-group">
                  <label for="dateOfBirth">Birthdate:</label>
                  <input type="text" id="dateOfBirth" class="form-control" name="dateOfBirth" value="<?php if (!empty($birthdate)) echo $birthdate; else echo 'YYYY-MM-DD'; ?>" >
                  </div>
                  
                  <br />
                  
                   <div class="form-group">
                        <label>Bio</label>
                        <textarea name="bio" class="form-control" rows="15" cols="75" 
                                placeholder="Enter your bio here.."> </textarea>
                   </div>
                  
                  <div class="form-group">
                  <input type="hidden" class="form-control" name="oldPicture" value="<?php if (!empty($old_picture)) echo $old_picture; ?>" />
                  <label for="newPicture">Picture:</label>
                  <input type="file" id="newPicture" class="form-control" name="newPicture" />
                  <?php if (!empty($old_picture)) {
                    echo '<img class="profile" src="' . EP_UPLOADPATH . $old_picture . '" alt="Profile Picture" />';
                  } ?>
                  </div>
                  
                </fieldset>
            <input type="submit" class="form-control" id="submitButton" value="Save Profile" name="submit" />
            </form>
            
        </div>
        
    </div>
    
</div>
       <!-- jQuery first, then Tether, then Bootstrap JS. -->
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" 
            integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" 
            integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" 
            integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
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

