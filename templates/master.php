<?php
    // Start our sessions - populate our menu - spin up the quotes if the user is logged in
    session_start();
    require('masterTemplateDBfunctions.php');
    $menuItems = getAllPosts();
    $quotes = getAllQuotes();
?>

<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <title><?=$this->e($title)?></title>
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/vendor.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <script src="js/modernizr.js"></script>
    <link rel="shortcut icon" href="images/logo.png" type="image/x-icon">
    <link rel="icon" href="images/logo.png" type="image/x-icon">
</head>
<body id="top">
    <div id="preloader">
        <div id="loader" class="dots-fade">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <header class="s-header header">
        <div class="header__logo">
            <a class="logo" href="index.php">
                <img src="images/logo.png" alt="Homepage">           
            </a>
        </div>
        <a class="header__search-trigger" href="#0"><i class="fab fa-2x fa-searchengin"></i></a>
        <div class="header__search">
            <form role="search" method="post" class="header__search-form" action="index.php">
                <label>
                    <span class="hide-content">Search for:</span>
                    <input type="search" class="search-field" placeholder="Type Keywords" value="" name="searchTerms" title="Search for:" autocomplete="off">
                </label>
                <input type="submit" class="search-submit" name="searchSubmitted" value="">
            </form>
            <a href="#0" title="Close Search" class="header__overlay-close">Close</a>
        </div>
        <a class="header__toggle-menu" href="#0" title="Menu"><span>Menu</span></a>
        <nav class="header__nav-wrap">
            <h2 class="header__nav-heading h6">Navigate to</h2>
            <ul class="header__nav">
                <li class="current"><a href="index.php" title="">Home</a></li>
                <li class="has-children">
                    <a href="#0" title="">Blog</a>
                    <ul class="sub-menu"> 

                        <?php
                            // Query DB for all Avaiable post and make drop down out of the list
                            for ($i=0; $i < count($menuItems); $i++) { 
                                echo("<li><a href=single.php?id=" . $menuItems[$i][0] . ">" . $menuItems[$i][1] . "</a></li>" );
                            }
                        ?>

                    </ul>
                </li>
                <li><a href="about.php" title="">About</a></li>

                <?php 
                    if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']) {
                        echo('<li><a class="" href="dashboard.php" title="">Dashboard</a></li>');
                    }
                    else {         
                        echo('<li><a class="header__login-trigger" href="#" title="">Login</a></li>');
                    } 
                ?>    

            </ul> 
            <a href="#0" title="Close Menu" class="header__overlay-close close-mobile-menu">Close</a>

            <div class="header__login">
                <form role="login" method="post" class="header__login-form" action="dashboard.php">
                    <label>
                        <span class="hide-content">Username:</span>
                        <input type="login" class="login-field" id="usernameField" placeholder="Type Keywords" value="" name="loginUserName" title="login" required>
                    </label>
                      <label>
                        <span class="hide-content">Password:</span>
                        <input type="password" class="login-field" id="passwordField" placeholder="Type Keywords" value="" name="loginUserPass" title="password" required>
                    </label>
                    <button type="submit" class="login-submit btn" value="" name="loginSubmitted">Login</button>
                </form>
                <a href="#0" title="Close login" class="header__overlay-close">Close</a>
            </div>
        </nav>
    </header>

			<?=$this->section('content')?>

  <footer class="s-footer" id="formFooter">
        <div class="s-footer__main">
            <div class="row">
               
                <?php
                    // Hide two sections in footer if applicable 
                    $hideFooter = "";
                    if(isset($_POST['registerSubmitted'])) {                      
                      $msg = "";
                      if(!$_POST['userFName']) {
                        $msg = "<p>Please Enter Your First Name.</p>\n";                          
                          if(!$_POST['userPass']) {
                            $msg = "<p>Please Enter a Password.</p>\n";                          
                              if (!$_POST['userEmail']) {
                                $msg = "<p>Please Enter Your Email.</p>\n";                              
                                  if (!$_POST['userName']) {
                                    $msg = "<p>Please Enter Your User Name.</p>\n";
                                }
                            }
                        }                      
                      }
                      if($msg === "") {
                        $name = htmlspecialchars($_POST['userName']);
                        $fName = htmlspecialchars($_POST['userFName']);
                        $passHash = password_hash($_POST['userPass'], PASSWORD_DEFAULT);
                        $email = htmlspecialchars($_POST['userEmail']);
                        if(regUser($name,$passHash,$email, $fName)) {
                            echo("   <div style='text-align:center;'>
                                         <h4 class='reg-success' style='border-bottom: 1px solid;'>Thank you!</h4>
                                        <br>
                                        <p> Please login with the <a class='smoothscroll' href='#top'>menu bar</a>.</p>                                                
                                        ");
                            $hideFooter = "display:none;";
                        }
                        else {
                            echo("   <div style='text-align:center;'>
                                         <h4 class='reg-success' style='border-bottom: 1px solid;'>Sorry, There was Error.</h4>
                                         <p>" . $msg . "</p>
                                        <br>
                                        <p> Please try again.</p>
                                        ");
                                }
                      }
                    }

                    ?>

                <div class="col-six tab-full s-footer__subscribe" style=<?php echo($hideFooter); ?>>

                    <?php 
                        if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']) {    
                            $randIndx = rand(0,count($quotes)-1);
                            echo('
                            <h4>Quotes</h4>
                            <i class="fas fa-3x fa-quote-left"></i>
                            <p style="padding-top: 15px;text-align:center;"> ' . $quotes[$randIndx][1] . '</p>
                            <br>
                            <p style="font-size: 1.8rem;">-' . $quotes[$randIndx][0] . '</p>
                            <i class="fas fa-3x fa-quote-right" style="float: right;margin-top:-100px"></i>
                                ');
                        }
                        else {                           
                            echo('          
                            <h4>Register</h4>
                            <div class="subscribe-form">
                                <form id="mc-form" action="#formFooter" method="post" class="group">
                                    <input type="text" value="" name="userFName" class="email" placeholder="First Name" required>
                                    <input type="text" value="" name="userName" class="email" placeholder="User Name" required>
                                    <input type="password" value="" name="userPass" class="email" placeholder="Password" required>
                                    <input type="email" value="" name="userEmail" class="email mc-email" id="RegEmail" placeholder="Email Address" required>
                                    <input type="submit" name="registerSubmitted" value="Register">
                                    <label for="mc-email" class="subscribe-message"><?php if(isset($msg)){echo($msg);} ?> </label>
                                </form>
                            </div>');                            
                    } 
                    ?>

                </div> 
                <div class="col-six tab-full s-footer__subscribe" style=<?php echo($hideFooter); ?>>
                    <?php
                        if(isset($_POST['contact'])){
                            if(isset($_POST['userName']) && !empty($_POST['userName'])){
                                if(isset($_POST['userEmail']) && !empty($_POST['userEmail'])){
                                    if(isset($_POST['message']) && !empty($_POST['message'])){
                                        $_name = htmlspecialchars($_POST['userName']);
                                        $_email = htmlspecialchars($_POST['userEmail']);
                                        $_message = "You Have New Email From" . $_name .
                                                    "(" . $_email . ")\r\n\r\n" .
                                                    htmlspecialchars($_POST['message']);
                                        $_headers = "From: webmaster@derekbb.com";

                                        mail("dev.dbbring@gmail.com","Blue Jeans Investing Question",$_message, $_headers);

                                       echo('
                                                <h4>Thank You!</h4>
                                                <hr>
                                                <div class="subscribe-form">
                                                <p> Your Message Has Been Sent! </p>
                                                </div>
                                            </div>
                                            </div>
                                        </div> 
                                        <div class="go-top">
                                            <a class="smoothscroll" title="Back to Top" href="#top">
                                                <i class="fas fa-2x fa-caret-square-up"></i>
                                            </a>
                                        </div>
                                    </footer>
                                                ');   
                                    }
                                    else{
                                        $errMsg = "You did not include a message.";
                                    }
                                }
                                else {
                                    $errMsg = "You did not include a email.";
                                }
                            }
                            else {
                                $errMsg = "You did not include a name.";
                            }
                            echo('
                                    <h4>There was an Error...</h4>
                                                <hr>
                                                <div> class="subscribe-form">
                                                <p> ' . $errMsg . '</p>
                                                </div>
                                ');
                          
                        }
                        else {
                            echo('
                                <h4>Contact Us</h4>
                                <div class="subscribe-form">
                                    <form id="mc-form" class="group" method="post" action="#formFooter">
                                        <input type="text" value="" name="userName" class="email" placeholder="First and Last Name" required>
                                        <input type="email" value="" name="userEmail" class="email mc-email" id="mc-email" placeholder="Email Address" required="">
                                        <textarea name="message" id="contactMessage" cols="70" rows="2" placeholder="Whats on your mind?" required style="min-height: 0px;"></textarea>
                                        <input type="submit" name="contact" value="Send">
                                        <label for="mc-email" class="subscribe-message"></label>
                                    </form>
                                </div>
                            </div>
                            </div>
                        </div> 
                        <div class="go-top">
                            <a class="smoothscroll" title="Back to Top" href="#top">
                                <i class="fas fa-2x fa-caret-square-up"></i>
                            </a>
                        </div>
                    </footer>
                    <script src="js/jquery-3.2.1.min.js"></script>
                    <script src="js/plugins.js"></script>
                    <script src="js/main.js"></script>
                                ');
                        }
                    ?>
                </div>
            </div>
        </div> 
        <div class="go-top">
            <a class="smoothscroll" title="Back to Top" href="#top">
                <i class="fas fa-2x fa-caret-square-up"></i>
            </a>
        </div>
    </footer>
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/main.js"></script>
</body>
</html>