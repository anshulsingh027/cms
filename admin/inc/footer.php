<footer class="text-center">
        Copyright &copy; by <a href="#">Ansul Gautam </a><?php echo date('Y'); ?>
    </footer>

   
    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
         <script src="https://cloud.tinymce.com/5/tinymce.min.js"></script>
        <script src="js/code.js"></script>
        <script>
            
            var demoBaseConfig = {
              selector: "textarea#textarea",
              width: 755,
              height: 300,
              resize: false,
              autosave_ask_before_unload: false,
              codesample_dialog_width: 600,
              codesample_dialog_height: 425,
              template_popup_width: 600,
              template_popup_height: 450,
              plugins: [
                "advlist anchor autolink codesample colorpicker contextmenu fullscreen help image imagetools",
                " lists link media noneditable preview",
                " searchreplace table template textcolor visualblocks wordcount"
              ], //removed:  charmap insertdatetime print
              toolbar:
                "insertfile a11ycheck undo redo | bold italic | forecolor backcolor | template codesample | alignleft aligncenter alignright alignjustify | bullist numlist | link image",
              content_css: [
                "//fonts.googleapis.com/css?family=Lato:300,300i,400,400i",
                "//www.tiny.cloud/css/content-standard.min.css"
              ],
                <?php
                $media_query = "SELECT * FROM media ORDER BY id DESC";
                $media_run = mysqli_query($con,$media_query);
                if(mysqli_num_rows($media_run) > 0){
                    
            
                ?>
                 image_list: [
                     <?php
                     while($media_row = mysqli_fetch_array($media_run)){
                         $media_name = $media_row['image'];
                     
                     ?>
    {title: '<?php echo $media_name;?>', value: 'media/<?php echo $media_name;?>'},
    <?php
                     }
                     ?>
  ]
                <?php
                }
                ?>
            };

            tinymce.init(demoBaseConfig);
                    </script>
  </body>
</html>