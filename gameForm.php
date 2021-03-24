
<?php
class gameForm {
    
    
    //Display HTML form for game enteries
    public function displayForm() {

            //show HTML game form
            ?>
                <div class="row justify-content-center">
                
                    <div class="col-6">
                    
                        <form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MM_MAXFILESIZE; ?>" />
                        
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" class="form-control" name="title" />
                        </div>
                       
                        <br />
                        
                        <div class="form-group">
                            <label>Link To Game</label>
                            <input type="text" class="form-control" name="gameLink" />
                        </div>
                       
                        <br />
                        
                        <div class="form-group">
                        <label>Author</label>
                        <input type="text" class="form-control" name="author" />
                        </div>
                        
                        <br />
                        
                        <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" class="form-control" rows="15" cols="75" 
                                placeholder="Enter your game description here.."> </textarea>
                        </div>
                        
                        <br />
                        
                        <div class="form-group">
                        <label>Date</label>
                        <input type="text" class="form-control" name="pubDate" value="<?php $date = date("y-m-d"); echo $date;?>" 
                                placeholder="(YYYY-MM-DD)" />
                        </div>
                        
                        <br />
                        
                        <div class="form-group">
                        <label for="icon">Picture:</label>
                        <input type="file" id="icon" class="form-control" name="icon" />
                        <?php 
                        if (!empty($icon))
                        {
                        echo '<img class="profile" src="' . ICON_UPLOADPATH . $icon . '" alt="Game Icon" />';
                        }
                        ?>
                        </div>
                        
                        <input type="submit" id="submitButton" class="form-control" name="submitGame" value="Submit Game" />
                        
                        </form>
                        
                    </div>
                    
                </div>
                
            <?php
        
    }
    
    //Processing code for submitting games to the gameDepot database
    public function enterGame() 
    {
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        
        if (isset($_POST['submitGame'])) 
        {
            //set variables
            $title = mysqli_real_escape_string($dbc, trim($_POST['title']));
            $gameLink = mysqli_real_escape_string($dbc, trim($_POST['gameLink']));
            $author = mysqli_real_escape_string($dbc, trim($_POST['author']));
            $description = mysqli_real_escape_string($dbc, trim($_POST['description']));
            $pubDate = mysqli_real_escape_string($dbc, trim($_POST['pubDate']));
            $icon = mysqli_real_escape_string($dbc, trim($_FILES['icon']['name']));
            $icon_type = $_FILES['icon']['type'];
            $icon_size = $_FILES['icon']['size']; 
            $user_id = $_SESSION['user_id'];
            
            // Validate and move the uploaded picture file, if necessary
            if (!empty($icon)) 
            {
                list($icon_width, $icon_height) = getimagesize($_FILES['icon']['tmp_name']);
                if ((($icon_type == 'image/gif') || ($icon_type == 'image/jpeg') || ($icon_type == 'image/pjpeg') ||
                        ($icon_type == 'image/png')) && ($icon_size > 0) && ($icon_size <= ICON_MAXFILESIZE) &&
                        ($icon_width <= ICON_MAXIMGWIDTH) && ($icon_height <= ICON_MAXIMGHEIGHT)) {
        
                // Move the file to the target upload folder
                $target = ICON_UPLOADPATH . basename($icon);
                if (move_uploaded_file($_FILES['icon']['tmp_name'], $target)) 
                {
                 echo "<p class='success'>SUCCESS! The game titled <strong>"
                     . $_POST['title'] . "</strong> was entered into the database.</p>";
                }
                else 
                {
                    // The new picture file move failed, so delete the temporary file and set the error flag
                    @unlink($_FILES['icon']['tmp_name']);
                    $error = true;
                    echo '<p class="error">Sorry, there was a problem uploading your picture.</p>'; 
                }
            }
            else 
            {
                // The new picture file is not valid, so delete the temporary file and set the error flag
                @unlink($_FILES['icon']['tmp_name']);
                $error = true;
                echo '<p class="error">Your picture must be a GIF, JPEG, or PNG image file no greater than ' . (ICON_MAXFILESIZE / 1024) .
                 ' KB and ' . ICON_MAXIMGWIDTH . 'x' . ICON_MAXIMGHEIGHT . ' pixels in size.</p>';
            }
            
            
            
            $query = "INSERT INTO games (title, author, description, pubDate, icon, gameLink, ownerId) 
                    VALUES('" . $title . "', '" . $author . "', '" . $description . "', '" . $pubDate . "', '" . $icon . "', '" . $gameLink . "', '" . $user_id . "');";
            $data = mysqli_query($dbc, $query)
                or die("ERROR: INSERT GAME QUERY NOT WORKING PROPERLY");
            
        } 
        else 
        {
            $title = '';
            $author = '';
            $description = '';
            $pubDate = '';
            $icon = '';
            //$user_id = $_SESSION['user_id'];
        }
        mysqli_close($dbc);  
    }
}
}
?>

