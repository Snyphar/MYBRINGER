<div class="card post-card   post-type-<?php echo $row['post_type']?>" style="max-width: 700px;">
                <div class="card-header d-flex justify-content-between transparent-header">
                    <div>
                        <div class="d-flex align-items-center">
                            <?php
                            
                            if(isset($row['profile_pic']) && !empty($row['profile_pic'])) {
                        
                                $post_profile_pic = "uploads/{$row['profile_pic']}";
                            } else {
                                $post_profile_pic = "assets/images/no_person.jpg";
                            }
                            ?>
                            <a style="text-decoration: none;color: inherit;" href="<?php echo "./profile.php?id=".$row['id']?>">
                            <img src="<?php echo $post_profile_pic; ?>" alt="" style="width: 50px; height: 50px; border-radius: 50%;" />
                            </a>
                            <?php
                                // Assuming $row['created_at'] contains a datetime string like "Y-m-d H:i:s"
                                $created_at = strtotime($row['created_at']);
                                $current_time = time();

                                // Calculate the difference in seconds
                                $time_elapsed = $row['time_elapsed_seconds'];
                                

                                // Define time intervals in seconds
                                $minute = 60;
                                $hour = $minute * 60;
                                $day = $hour * 24;
                                $week = $day * 7;
                                $month = $day * 30;
                                $year = $day * 365;
                                
                                // Calculate elapsed time in human-readable format
                                if ($time_elapsed < $minute) {
                                    $elapsed_result = ($time_elapsed <= 1) ? "just now" : $time_elapsed . " seconds ago";
                                } elseif ($time_elapsed < $hour) {
                                    $elapsed_result = round($time_elapsed / $minute) . " minutes ago";
                                } elseif ($time_elapsed < $day) {
                                    $elapsed_result = round($time_elapsed / $hour) . " hours ago";
                                } elseif ($time_elapsed < $week) {
                                    $elapsed_result = round($time_elapsed / $day) . " days ago";
                                } elseif ($time_elapsed < $month) {
                                    $elapsed_result = round($time_elapsed / $week) . " weeks ago";
                                } elseif ($time_elapsed < $year) {
                                    $elapsed_result = round($time_elapsed / $month) . " months ago";
                                } else {
                                    $elapsed_result = round($time_elapsed / $year) . " years ago";
                                }

                                
                            ?>
                            <div>
                                <a style="text-decoration: none;color: inherit;font-size:18px;" href="<?php echo "./profile.php?id=".$row['id']?>"><?php echo $row['first_name']." ".$row['last_name']?></a>
                                <p class="mb-0" style="font-size: 10px;"><?php echo $elapsed_result; ?></p>
                            </div>
                            
                        </div>
                    </div>
                    <div>
                        <button class="btn btn-transparent btn-borderless p-0">...</button>
                        <button class="btn btn-transparent btn-borderless p-0"><b>X</b></button>
                    </div>
                </div>
                <div class="card-body text-center">
                    <?php
                    $post_type = $row['post_type'];
                    if ($post_type == 0):
                    ?>
                    <h5 class='card-title'><b>I want to send</b></h5>
                    <?php
                    elseif ($post_type == 1) :
                    ?>
                    <h5 class='card-title'><b>I want to receive</b></h5>
                    <?php
                    elseif ($post_type == 2):
                    ?>
                    <h5 class='card-title'><b>I want to carry</b></h5>
                    <?php
                    else:
                    ?>
                        
                    
                    <?php
                    endif;
                    ?>
                    <div>
                    <div class="row mx-auto text-center justify-content-center">
                        <div class="col-8 offset-3 text-left">
                            <p>From : <?php echo $row['from_location']?></p>
                            <p>To : <?php echo $row['to_location']?></p>
                            <p>Pickup : (<?php echo $row['pickup_date_start']?> - <?php echo $row['pickup_date_end']?>)</p>
                            <p>Drop of : (<?php echo $row['dropoff_date_start']?> - <?php echo $row['dropoff_date_end']?>)</p>
                            <?php
                            $parcel_type = $row['parcel_type'];
                            if ($parcel_type == 0) {
                                echo '<p>Parcel type : Document</p>';
                            } elseif ($parcel_type == 1) {
                                echo '<p>Parcel type : Product</p>';
                            } elseif ($parcel_type == 2) {
                                echo '<p>Parcel type : Food</p>';
                            } else {
                                // Handle any other cases
                                echo '<p>Parcel type : Others</p>';
                            }
                            ?>
                            <?php
                            $parcel_size = array("Small","Medium","Large","Extra Large");
                            $weight_scales = array("Kg","Gram","Lbs");
                            ?>
                            <p>Parcel Size: <?php echo $parcel_size[$row['parcel_size']]; ?></p>
                            <p>Weight Allowance: <?php echo $row['weight'];?> <?php echo $weight_scales[$row['weight_scale']]; ?></p>
                            
                            
                        </div>
                    </div>
                    
                    
                    
                    

                    </div>

                    <?php
                    if (!empty($row["details"])):
                    ?>
                        
                            <p class="text-left"><?php echo $row["details"]?></p>
                        
                    <?php endif; ?>
                    
                    
                    
                    
                </div>
                <div class="card-footer">
                    <div class="button-container post-card-footer">
                        
                        <?php
                        $likeIdString = $row['like_id'];

                        // Check if the user has already liked the post
                        $likeIds = explode(",", $likeIdString);
                        
                        $sql = "SELECT comments.*, users.first_name, users.id, users.last_name, users.profile_pic FROM comments LEFT JOIN users ON comments.uid = users.id WHERE comments.post_id = ".$row["post_id"];
                        $comments_results = $conn->query($sql);
                        $num_comments = $comments_results->num_rows;

                        $userLiked = isset($_SESSION["id"]) && in_array($_SESSION["id"], $likeIds);
                        ?>
                        <a class="btn like-btn" href="#" role="button" data-target="<?php echo $row["post_id"]?>">
                        
                            <i class="fas fa-thumbs-up <?php echo $userLiked ? 'liked-icon' : '' ?>"></i>
                            
                        </a>
                        <a class="btn comment-btn" href="#" role="button" data-target="<?php echo $row["post_id"]?>">
                            <i class="fas fa-comments"></i> 
                        </a>
                        <a class="btn share-btn" href="#" role="button">
                            <i class="fas fa-share"></i>
                        </a>
                    </div>
                    <div class="number-container post-card-footer">
                    <p><small>Likes: <span class="like-count" id="like-count-<?php echo $row["post_id"]?>"><?php echo count($likeIds)-1;?></span></small></p>
                        <p><small>Comments: <span  id="comment-count-<?php echo $row["post_id"]?>"><?php echo $num_comments;?></span></small></small></p>
                        <p><small>Shares: 3</small></p>
                    </div>
                </div>
                <div class="comment-post" style="display:none;" data-post-id="<?php echo $row['post_id']; ?>" id="comments-<?php echo $row['post_id']; ?>">
                    <div id='comment-list-<?php echo $row['post_id']; ?>'>
                        <?php
                        while($comment_row=$comments_results->fetch_assoc()):
                            if(!empty($comment_row['profile_pic'])) {
                    
                                $comment_profile_pic = "uploads/{$comment_row['profile_pic']}";
                            } else {
                                $comment_profile_pic = "assets/images/no_person.jpg";
                            }
                        ?>
                        <div class="comment-item">
                            <img src="<?php echo $comment_profile_pic; ?>" alt="" style="width: 30px; height: 30px; border-radius: 50%;" />
                            <div>
                                <b><?php echo ucfirst(strtolower($comment_row['first_name']))." ".ucfirst(strtolower($comment_row['last_name']))?></b>
                                <p><?php echo $comment_row['comment']; ?></p>
                            </div>
                        </div>
                        <?php
                        endwhile;
                    ?>
                    </div>
                    
                    <div class="comment-box" >
                        <textarea id="comment-box-<?php echo $row['post_id']; ?>" rows="3" placeholder="Write a comment..."></textarea>
                    </div>
                    <div class="comment-button-container">
                        <button class="comment-button">Comment</button>
                    </div>
                </div>




            </div>