<?php   require_once ('inc/top.php'); ?>
  </head>
  <body>
   <?php   require_once ('inc/header.php'); ?>
   
   <div class="jumbotron">
       <div class="container">
           <div id="details" class="animated slideInLeft">
               <h1>Contact <span>Us</span></h1>
               <p>Feel Free To Contact Us</p>
           </div>
       </div>
       <img src="img/bg.jpg" alt="Top Image">
   </div>
   <section><div class="container">
       <div class="row">
           <div class="col-md-8">
      <div class="row">
          <div class="col-md-12 ">
                <div class="mapouter"><div class="gmap_canvas"><iframe width="100%" height="500" id="gmap_canvas" src="https://maps.google.com/maps?q=kp-9%2Fc%2Ckiit%20university%2Cpatia%2Cbhubaneswar&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><a href="https://www.emojilib.com">emojilib.com</a></div><style>.mapouter{position:relative;text-align:right;height:500px;width:600px;}.gmap_canvas {overflow:hidden;background:none!important;height:500px;width:700px;}</style></div>
          </div>
          <div class="col-md-12 contact-form">
            <?php
              if(isset($_POST['submit'])){
                  $name = mysqli_real_escape_string($con,$_POST['name']);
                  $email = mysqli_real_escape_string($con,$_POST['email']);
                  $website = mysqli_real_escape_string($con,$_POST['website']);
                  $comment = mysqli_real_escape_string($con,$_POST['comment']);
                  
                  $to = "anshulsingh027@gmail.com";
                  $header = "From: $name<$email>";
                  $subject = "Message From $name";
                  
                  $message = "Name: $name \n\n Email: $email \n\n Website: $website \n\n Message:\n $comment";
                  
                  if(empty($name) or empty($email) or empty($comment)){
                      $error = "ALL (*) Fields Are Required";
                      
                  }
                  else{
                    if(mail($to,$subject,$message,$header)){
                        $msg = "Message Has Been Sent";
                    }
                      else{
                          $error = "Message Has Not Been Sent";
                      }
                  }
              }
              ?>
            
             <h2>Contact Form</h2><hr>
              <form action="" method="post">
                  <div class="form-group">
                      <label for="full-name">Full Name:</label>
                      <?php
                      if(isset($error)){
                                    echo "<span style='color:red;' class='pull-right'>$error</span>";
                                }
                                else if(isset($msg)){
                                    echo "<span style='color:green;' class='pull-right'>$msg</span>";
                                }
                      
                      ?>
                      
                      <input type="text" id="full-name" class="form-control" placeholder="Full Name" name="name">
                  </div>
                   <div class="form-group">
                      <label for="email">Email:</label>
                      <input type="email" id="email" class="form-control" placeholder="Email Address" name="email">
                  </div>
                   <div class="form-group">
                      <label for="website">Website:</label>
                      <input type="text" id="website" class="form-control" placeholder="Website" name="website" >
                  </div>
                   <div class="form-group">
                      <label for="message">Message:</label>
                      <textarea name="comment" id="message" cols="30" rows="10" class="form-control" placeholder="Your Message"></textarea>
                  </div>
                  <input type="submit" name="submit" value="Submit" class=" btn btn-primary">
                  
              </form>
          </div>
      </div>
           </div>
           <div class="col-md-4">
               <?php   require_once ('inc/sidebar.php'); ?>
              
              
           </div>
       </div>
   </div></section>
  <?php   require_once ('inc/footer.php'); ?>