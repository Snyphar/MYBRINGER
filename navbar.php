<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php">Courier</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="post.php">Post</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="#">Message</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Connect</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Follow</a>
            </li>
            <?php
            // Fetch notification count for the logged-in user
            if (isset($_SESSION['id'])):
                $userId = intval($_SESSION['id']);
                $notificationSql = "SELECT COUNT(*) as unread_count FROM post_notification LEFT JOIN post ON post_notification.post_id = post.id WHERE post.uid = $userId AND post_notification.seen = 0";
                $notificationResult = $conn->query($notificationSql);
                $unreadCount = 0;
                if ($notificationResult) {
                    $notificationRow = $notificationResult->fetch_assoc();
                    $unreadCount = $notificationRow['unread_count'];
                }
            
            ?>
            <a class="nav-link" href="#" data-toggle="modal" data-target="#notificationModal">
                Notification <?php if ($unreadCount > 0): ?><span class="badge badge-danger"><?php echo $unreadCount; ?></span><?php endif; ?>
            </a>
            <?php endif;?>
        </ul>
        <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
        <ul class="navbar-nav ml-auto">
        
            <?php
            // Start session
            if(isset($_SESSION['id']) && !empty($_SESSION['profile_pic'])) {
                $profile_pic = "uploads/{$_SESSION['profile_pic']}";
            } else {
                $profile_pic = "assets/images/no_person.jpg";
            }

            
            ?>
            <?php
            if (isset($_SESSION['id'])):
            ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="<?php echo $profile_pic;?>" alt="Profile Image" class="navbar-profile-image"> Welcome, <?php echo $_SESSION['first_name'];?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="profile.php">Profile</a>
                        <a class="dropdown-item" href="logout.php">Logout</a>
                    </div>
                </li>
                
            <?php
            else:
            ?>
                <li class="nav-item"><a class="nav-link" href="login.php">Login/Signup</a></li>
            <?php
            endif;
            ?>
        </ul>
    </div>
</nav>

<?php
if (isset($_SESSION['id'])):
    $userId = intval($_SESSION['id']);
    $notificationSql = "SELECT  post_notification.* FROM post_notification LEFT JOIN post ON post_notification.post_id = post.id WHERE post.uid = ".$_SESSION['id']." AND post_notification.seen = 0";
    $notificationResult = $conn->query($notificationSql);
    

?>
<div class="modal fade" id="notificationModal" tabindex="-1" role="dialog" aria-labelledby="notificationModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="notificationModalLabel"><b>Notifications</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container" style="border: 1px solid gray; border-radius: 10px; padding: 5px; box-shadow: 0 5px 8px rgba(0, 0, 0, 0.1);">
            <div class="row rounded-buttons p-2">
                <div class="pl-3 pb-3">
                    <button class="btn btn-info btn-sm btn-info-filled btn-block" style="max-width: 100px; min-width:70px;">  All  </button>
                </div>
                <div class="pl-3 pb-3">
                    <button class="btn btn-info btn-sm btn-info-filled btn-block" style="max-width: 150px;">My Posts</button>
                </div>
                <div class="pl-3 pb-3">
                    <button class="btn btn-info btn-sm btn-info-filled btn-block" style="max-width: 150px;">Unread Posts</button>
                </div>
                <div class="pl-3 pb-3">
                    <button class="btn btn-info btn-sm btn-info-filled btn-block" style="max-width: 150px;">Read All</button>
                </div>
                <div class="pl-3 pb-3">
                    <button class="btn btn-info btn-sm btn-info-filled btn-block" style="max-width: 150px;">Unread Posts</button>
                </div>
            </div>
        </div>
        <div class="container mt-5" style="border: 1px solid gray; border-radius: 10px; padding: 5px; box-shadow: 0 5px 8px rgba(0, 0, 0, 0.1); overflow:hidden;">
            <?php
            if($unreadCount):
            ?>
            <?php
            while($notification_row=$notificationResult->fetch_assoc()):
            ?>
            <a href="./view_post.php?id=<?php echo $notification_row['post_id'];?>&noid=<?php echo $notification_row['id']; ?>" style="text-decoration: none; color: inherit;">
                <div class="row p-2" style="<?php echo $notification_row['seen'] == 0 ? 'background-color: #CFE9ED;' : ''; ?>">
                    <div class="col-1"><img src="./assets/images/no_person.jpg" alt="" style="width: 30px; height: 30px; border-radius: 50%;" /></div>
                    <div class="col-11">
                        <p><?php echo $notification_row['message']?></p>
                    </div>
                </div>
            </a>
            <?php endwhile; ?>
            <?php
            else:
            ?>
            <p class="text-center">No new notifications.</p>
            <?php endif; ?>
            
        </div>
        <!-- Content for notifications will be loaded here -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<?php endif;?>

