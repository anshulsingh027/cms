<?php require_once('inc/top.php');

 if(!isset($_SESSION['username'])){
    header('Location: login.php');
}
$session_username = $_SESSION['username'];

if(isset($_GET['edit'])){
    $edit_id = $_GET['edit'];
    $edit_query = "SELECT * FROM users WHERE id ='$edit_id'";
    $edit_query_run = mysqli_query($con,$edit_query);
    if(mysqli_num_rows($edit_query_run) > 0){
        $edit_row = mysqli_fetch_array($edit_query_run);
        $e_username= $edit_row['username'];
       if($e_username == $session_username){
            $e_first_name= $edit_row['first_name'];
            $e_last_name= $edit_row['last_name'];
            $e_image= $edit_row['image'];
             $e_details= $edit_row['details'];
       }
        else{
            header('location: index.php');
        }
    }
    else{
        header("Location: index.php");
    }
}

else{
    header("Location: index.php");
}

?>
 
 
  </head>
  <body>
    <div id="wrapper">
      
       <?php require_once('inc/header.php'); ?>
       
    <div class="container-fluid body-section">
        <div class="row">
            <div class="col-md-3">
              
               <?php require_once('inc/sidebar.php'); ?>
            
            </div>
            <div class="col-md-9">
                <h1> <i class="fa fa-user"></i> Edit Profile <small>Edit Profile Details</small></h1><hr>
                <ol class="breadcrumb">
                  <li><a href="#"><i class="fa fa-tachometer"></i> Dashboard </a></li>
                   <li class="active"><i class="fa fa-user"></i> Edit Profile</li>
                </ol>
             <?php
                if(isset($_POST['submit'])){
                    
                    $first_name = mysqli_real_escape_string($con,$_POST['first-name']); 
                    $last_name = mysqli_real_escape_string($con,strtolower($_POST['last-name']));
                    
                    $password = mysqli_real_escape_string($con,$_POST['password']);
                    
                    $image = $_FILES['image']['name'];
                    $image_tmp = $_FILES['image']['tmp_name'];
                    $details = mysqli_real_escape_string($con,$_POST['details']); 
                    
                    if(empty($image)){
                        $image =$e_image;
                    }
                    
                    $salt_query="SELECT * FROM users ORDER BY id DESC LIMIT 1 ";
                    $salt_run=mysqli_query($con,$salt_query);
                    $salt_row = mysqli_fetch_array($salt_run);
                    $salt = $salt_row['salt'];
                    
                    $insert_password = $password;
                        
                    if(empty($first_name)or empty($last_name)or empty($image)){
                        $error = "All (*) Fields Are Required";
                    }
                   
                   else{
                      $update_query = "UPDATE `users` SET `first_name` = '$first_name', `last_name` = '$last_name', `image` = '$image', `details` = '$details'";
                       
                       if(isset($password)){
                           $update_query .= ",`password` = '$insert_password'";
                       }
                       
                       $update_query .= "WHERE `users`.`id` = $edit_id";
                       if(mysqli_query($con,$update_query)){
                           $msg = "User Has Been Updated";
                           header("refresh:0; url=edit-profile.php?edit=$edit_id");
                           if(!empty($image)){
                               move_uploaded_file($image_tmp,"img/$image");
                           }
                       }
                       else{
                           $error = "User Has Not Been Updated";
                       }
                   }
                }
                ?>
             <div class="row">
                 <div class="col-md-8">
                       
                           <form action="" method="post" enctype="multipart/form-data">
                               <div class="form-group">
                                   <label for="first-name">First Name:*</label>
                                   <?php
                                   if(isset($error)){
                                    echo "<span style='color:red;' class='pull-right'>$error</span>";
                                   }
                                   else if(isset($msg)){
                                       echo "<span style='color:green;' class='pull-right'>$msg</span>";
                                       
                                   }
                                   ?>
                                   <input type="text" name="first-name" id="first-name" value="<?php echo $e_first_name;?>"  class="form-control" placeholder="First Name" >
                               </div>
                               <div class="form-group">
                                   <label for="last-name">Last Name:*</label>
                                   <input type="text" name="last-name" value="<?php echo $e_last_name;?>" class="form-control" id="last-name" placeholder="Last Name" >
                               </div>
                               
                               <div class="form-group">
                                   <label for="password">Password:*</label>
                                   <input type="password" name="password" class="form-control" id="password" placeholder="Password" >
                               </div>
                               
                               
                               <div class="form-group">
                                   <label for="image">Profile Picture:*</label>
                                   <input type="file" id="image" name="image" >
                               </div>
                               
                                <div class="form-group">
                                   <label for="details">Details:*</label>
                                   <textarea name="details" id="details" cols="30" rows="10" class="form-control"><?php echo $e_details?></textarea>
                               </div>
                               
                               <input type="submit" value="Update User" name="submit" class="btn btn-primary">
                           </form>
                 </div>
                 <div class="col-md-4">
                     <?php
                     
                         echo "<img src='img/$e_image' width='100%'>";
                     
                     ?>
                     
                 </div>
             </div>  
             
             </div>
        </div>
    </div>
    
   <?php require_once('inc/footer.php'); ?>