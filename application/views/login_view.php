<? php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!--Login Home Page-->
<html>
    <!--Login Page Library-->
    <head>
        <title>RCM Services - Login</title>
        <link rel="bookmark" href="<?php echo BASE_URL;?>dist/img/favicon.png"/>
        <link rel="shortcut icon" href="<?php  echo BASE_URL;?>dist/img/favicon.png"/>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL;?>dist/js/site.min.js"></script>
        <script type="text/javascript" src="dist/js/jquery.min.js"></script>
        <link rel="stylesheet" href="<?php echo BASE_URL;?>dist/css/home.css">
        <style tyepe="text/css">
            body {
                background-image: url('<?php echo BASE_URL;?>dist/img/home.jpg');
                background-size: cover;
                background-repeat: no-repeat;
                height: 100%;
            }
        </style>
        <script type="text/javascript">
            
            var capsLockEnabled = null;

            function getChar(e) {
              if (e.which == null) {
                return String.fromCharCode(e.keyCode); // IE
              }
              if (e.which != 0 && e.charCode != 0) {
                return String.fromCharCode(e.which); // rest
              }
              return null;
            }

            document.onkeydown = function(e) {
              e = e || event;
              if (e.keyCode == 20 && capsLockEnabled !== null) {
                capsLockEnabled = !capsLockEnabled;
              }
            }

            document.onkeypress = function(e) {
              e = e || event;
              var chr = getChar(e);
              if (!chr) return; // special key

              if (chr.toLowerCase() == chr.toUpperCase()) {
                // caseless symbol, like whitespace 
                // can't use it to detect Caps Lock
                return;
              }
              capsLockEnabled = (chr.toLowerCase() == chr && e.shiftKey) || (chr.toUpperCase() == chr && !e.shiftKey);
            }
            // Check caps lock 
            function checkCapsWarning() {
              document.getElementById('caps').style.display = capsLockEnabled ? 'block' : 'none';
            }
            function removeCapsWarning() {
              document.getElementById('caps').style.display = 'none';
            }
        </script>

    </head>
    <body>
        <!--Login Page View Content-->
        <div class="wrapper fadeInDown">
            <div id="formContent">
                <div class="fadeIn first">
                    <img src="<?php echo BASE_URL;?>dist/img/favicon.png" id="icon" alt="User Icon" />
                </div>
                  <h3 class="text-center text-info">RevWorks - PP Workflow Tool</h3>
                <!-- Login Form -->
                <form id="loginform" method="post" action="<?php echo BASE_URL;?>C_login/signin" onload>
                    <input type="text" 
                        maxlength="8" 
                        pattern="[A-Za-z]{2}\d{6}" 
                        title="Enter Proper AssociateID, Ex: AB123456"
                        id="associateId" 
                        name="associateId" 
                        class="fadeIn second" 
                        placeholder="Associate ID" required
                        onkeyup="checkCapsWarning(event)" onfocus="checkCapsWarning(event)" onblur="removeCapsWarning()" >
                    <input type="password" 
                        id="password" 
                        name="password"
                        class="fadeIn third" 
                        placeholder="Password" required
                        onkeyup="checkCapsWarning(event)" onfocus="checkCapsWarning(event)" onblur="removeCapsWarning()">
                    <button type="submit" class="fadeIn fourth" >Log In</button>
                </form>
                <!-- Login Error -->
                <span style="display:none;color:blue" id="caps">Warning: Caps Lock is on!</span>
                <?php
                if ($this->session->flashdata('error')==true){
                    echo "<span style='color:red;'>Invalid Credentials!!! Please Try Again.</span>";
                }
                ?>
            </div>
        </div>
    </body>
</html>


