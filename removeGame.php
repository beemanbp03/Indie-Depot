<?php
    require_once('authorize.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  
  <title>Blog Website - Remove Blog</title>
  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" 
        integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="css/custom.css" />
  
</head>

<body>
  <h2>Indie Depot - Remove Game</h2>

<?php
  require_once('appvars.php');
  require_once('connectvars.php');

  if (isset($_GET['id']) && isset($_GET['title']) && isset($_GET['author']) && isset($_GET['pubDate'])) 
  {
    // Grab the game data from the GET
    $id = $_GET['id'];
    $title = $_GET['title'];
    $author = $_GET['author'];
    $pubDate = $_GET['pubDate'];

  }
  else if (isset($_POST['id']) && isset($_POST['title']) && isset($_POST['author'])) 
  {
    // Grab the game data from the POST
    $id = $_POST['id'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $pubDate = $_POST['pubDate'];


  }
  else 
  {
    echo '<p class="error">Sorry, no game was specified for removal.</p>';
  }

  if (isset($_POST['submit'])) 
  {
    if ($_POST['confirm'] == 'Yes') 
    {

      // Connect to the database
      $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME); 

      // Delete the game data from the database
      $query = "DELETE FROM games WHERE id = $id LIMIT 1";
      mysqli_query($dbc, $query)
            or die("THERE WAS AN ERROR TRYING TO DELETE FROM GAMES");
      mysqli_close($dbc);

      // Confirm success with the user
      echo '<p>The game <b> ' . $title . ' </b> was successfully removed.';
    }
    else 
    {
      echo '<p class="error">ERROR: The game was not removed.</p>';
    }
  }
  else if (isset($id) && isset($title) && isset($author) && isset($pubDate)) 
  {
    echo '<p>Are you sure you want to delete the following game?</p>';
    echo '<p><strong>Title: </strong>' . $title . '<br /><strong>Author: </strong>' . $author .
      '<br /><strong>Date Published: </strong>' . $pubDate . '</p>';
    echo '<form method="post" action="removeGame.php">';
    echo '<input type="radio" name="confirm" value="Yes" /> Yes ';
    echo '<input type="radio" name="confirm" value="No" checked="checked" /> No <br />';
    echo '<input type="submit" value="Submit" name="submit" />';
    echo '<input type="hidden" name="id" value="' . $id . '" />';
    echo '<input type="hidden" name="title" value="' . $title . '" />';
    echo '<input type="hidden" name="author" value="' . $author . '" />';
    echo '<input type="hidden" name="pubDate" value="' . $pubDate . '" />';
    echo '</form>';
  }

  echo '<p><a href="admin.php">&lt;&lt; Back to admin page</a></p>';
?>

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
