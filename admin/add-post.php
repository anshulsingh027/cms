<?php
  require_once('inc/top.php');
  if(!isset($_SESSION['username'])) {
    header('Location: login.php');
  }

  $session_username = $_SESSION['username'];
if(isset($_SESSION['author_image'])){
    //echo $_SESSION['author_image'];
  $session_author_image = $_SESSION['author_image'];
}
?>
  </head>
  <body>
    <div id="wrapper"><!--So that when any content is deleted from body,footer sticks to the bottom of page otherwise it would move up-->
              <?php require_once('inc/header.php');?>
              <div class="container-fluid body-section">
                <div class="row">
                  <div class="col-md-3">
                    <?php require_once('inc/sidebar.php');?>
                  </div>
                  <div class="col-md-9">
                    <h1><i class="fa fa-plus-square"></i> Add Post <small>Add New Post</small></h1><hr>
                    <ol class="breadcrumb"><!--to apply breadcrumbs.Source: https://getbootstrap.com/docs/3.3/components/#breadcrumbs -->
                      <li><a href="index.php"><i class="fa fa-tachometer"></i> Dashboard</a></li>
                      <li class="active"><i class="fa fa-plus-square"></i> Add Post</li>
                    </ol>
                    <?php
                      if (isset($_POST['submit'])) {
                        $date = time();
                        $title = mysqli_real_escape_string($con, $_POST['title']);
                        $post_data = mysqli_real_escape_string($con, $_POST['post-data']);
                        $categories = $_POST['categories'];
                        $tags = mysqli_real_escape_string($con, $_POST['tags']);
                        $status = $_POST['status'];
                        $image = $_FILES['image']['name'];
                        $tmp_name = $_FILES['image']['tmp_name'];

                        if(empty($title) or empty($post_data) or empty($tags) or empty($image) ) {
                          $error = "All (*) Fields are Required";
                        }
                        else {
                          $insert_query = "INSERT INTO posts (date, title, author, author_image, image, categories, tags, post_data, views, status) VALUES ('$date', '$title', '$session_username', '$session_author_image', '$image', '$categories', '$tags', '$post_data', '0', '$status')";
                          if(mysqli_query($con, $insert_query)) {
                            $msg = "Post Has Been Added";
                            $path = "img/$image";
                            $title = "";
                            $post_data = "";
                            $tags = "";
                            $status = "";
                            $categories = "";
                            if(move_uploaded_file($tmp_name, $path)) {
                              copy($path, "../$path");
                            }
                          }
                          else {
                            $error = mysqli_error($con);
                          }
                        }
                      }
                    ?>
                    <div class="row">
                      <div class="col-xs-12">
                        <form action="" method="post" enctype="multipart/form-data">
                          <div class="form-group">
                            <label for="title">Title:*</label>
                            <?php
                              if(isset($msg)) {
                                echo "<span class='pull-right' style='color:green;'>$msg</span>";
                              }
                              else if(isset($error)) {
                                echo "<span class='pull-right' style='color:red;'>$error</span>";
                              }
                            ?>
                            <input type="text" name="title" placeholder="Type Posts Title Here" value="<?php if(isset($title)){echo $title;}?>" class="form-control">
                          </div>

                          <div class="form-group">
                            <a href="media.php" class="btn btn-primary">Add Media</a>
                          </div>

                          <div class="form-group">
                            <textarea name="post-data" id="textarea" rows="10" class="form-control"><?php if(isset($post_data)){echo $post_data;}?></textarea>
                          </div>

                          <div class="row">
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label for="file">Post Image:*</label>
                                <input type="file" name="image">
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label for="categories">Categories:*</label>
                                <select class="form-control" name="categories" id="categories">
                                  <?php
                                    $cat_query = "SELECT * FROM categories ORDER BY id DESC";
                                    $cat_run = mysqli_query($con, $cat_query);
                                    if(mysqli_num_rows($cat_run) > 0) {
                                      while($cat_row = mysqli_fetch_array($cat_run)) {
                                          $cat_name = $cat_row['category'];
                                          echo "<option value='".$cat_name."' ".((isset($categories) AND $categories == $cat_name)?"selected":"").">".ucfirst($cat_name)."</option>";
                                      }
                                    }
                                    else {
                                      echo "<center><h6>No Categories Available</h6></center>";
                                    }
                                  ?>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label for="tags">Tags:*</label>
                                <input type="text" name="tags" placeholder="Your Tags Here" value="<?php if(isset($tags)){echo $tags;}?>" class="form-control">
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label for="status">Status:*</label>
                                <select class="form-control" name="status" id="categories" id="status">
                                  <option value="publish" <?php if(isset($status) AND $status == 'publish'){echo "selected";}?>>Publish</option>
                                  <option value="draft" <?php if(isset($status) AND $status == 'draft'){echo "selected";}?>>Draft</option>
                                </select>
                              </div>
                            </div>
                          </div>
                          <input type="submit" name="submit" class="btn btn-primary" value="Add Post">
                        </form>
                      </div>  
                    </div>
                  </div>
                </div>
              </div><!--data inside body section-->

             <?php require_once('inc/footer.php');?>