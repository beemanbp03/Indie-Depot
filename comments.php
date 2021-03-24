<?php
class comments {

//If the comment has successfully been submitted, this variable will
//be true, giving user feedback of success

public $success = false;

    //HTML FORM FOR SUBMITTING A COMMENTS
    public function commentForm()
    {
    
        ?>
        <div class="row justify-content-center textBox">
            
            <div class="col-6">
                <p>
                    <a class="textBoxSolid" data-toggle="collapse" href="#collapseComment" role="button" aria-expanded="false" aria-controls="collapseComment">
                        LEAVE A COMMENT
                    </a>
                </p>
            </div>
            
            <div class="col-6">
                <p>
                    <?php
                    if ($this->success == true)
                    {
                    ?>---------YOUR COMMENT HAS BEEN SUBMITTED---------<?php
                    }
                    else
                    {
                    ?> <?php
                    }
                    ?>
                </p>
            </div>
            
            <div class="col-12 collapse" id="collapseComment">
            
                <form method="post" >
  
                    <div class="form-group">
                        <textarea name="comment" class="form-control" rows="10"
                                placeholder="Enter your comment here.."> </textarea>
                    </div>
                    
                    <input type="submit" id="submitButton" class="form-control" name="submitComment" value="Submit Comment" />
                    <input type="hidden" name="gameId" id="gameId" value="<?php echo $_GET['gameId']; ?>" />
                </form>
            </div>
            
        </div>
        
        <br />
        <br />
        <?php
        
    }
    
    //Logic for submitting a comment to the database
    public function enterComment() 
    {
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        
        //set variables
        $comment = mysqli_real_escape_string($dbc, trim($_POST['comment']));
        $user_id = $_SESSION['user_id'];
        $game_id = mysqli_real_escape_string($dbc, trim($_POST['gameId']));
        $this->success = true;
        $query = "INSERT INTO comments (comment, ownerId, gameId) 
                VALUES('" . $comment . "', '" . $user_id . "', '" . $_GET['gameId'] . "');";
        $data = mysqli_query($dbc, $query)
            or die("ERROR: INSERT COMMENT QUERY NOT WORKING PROPERLY");
            
                
        mysqli_close($dbc);
        
    }
    
    //Logic for displaying all comments
    public function displayComments()
    {
       $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME); 
       
       $query1 = "SELECT * FROM comments WHERE gameId='" . $_GET['gameId'] . "'";
       $data1 = mysqli_query($dbc, $query1);
       
       while ( $row1 = mysqli_fetch_array($data1) )
       {
            ?>
            <div class="row justify-content-center textBox">
                <div class="col-12">
                    <h2 class="large-text">Comments</h2>
                </div>
            <?php
            
            $query2 = "SELECT username, oldPicture FROM user_info where id='" . $row1['ownerId'] . "'";
            $data2 = mysqli_query($dbc, $query2);
            while( $row2 = mysqli_fetch_array($data2) )
            {
                ?>
                    <div class="col-3 textBox">
                        <?php 
                        //Output Profile Picture
                        if (!empty($row2['oldPicture'])) 
                        {
                            //show user their picture
                            echo ' <p><img src="' . EP_UPLOADPATH . $row2['oldPicture'] .
                            '" alt="Profile Picture" " /></p> ';
                        } 
                        else 
                        {
                            ?> <p>Profile Picture Does Not Exist</p> <?php
                        }
                        ?>
                        <p>username: <?php echo $row2['username']; ?></p>
                    </div>
                <?php
            }
            ?>
            
                <div class="col-9 textBox">
                    <p><?php echo $row1['comment'] ?></p>
                </div>
            
            </div>
            <?php
       }
       mysqli_close($dbc);
    }

}
?>
