<?php

include_once "functions/html.php";

include_once "classes/DB.php";

include_once "classes/admin.php";







function generateHash($pass)

{

    return hash(whirlpool, $pass . 'fUckd!1g@lG_^**^~d@r');

}



function login($user, $pass)

{

    global $DB;

    

    $result = $DB->query("SELECT * FROM admins 

                        WHERE name = '" . $DB->escape($user) . "' AND password= '" . generateHash($pass) . "'");

    

    

    if(!$result)

        return FALSE;

    

    $loginObj = mysql_fetch_object($result);

    

    if($loginObj->name == $user){

        $_SESSION['loggedIn'] = TRUE;

        return TRUE;

    }

    else{

        return FALSE;

    }

}



function logout(){

    $_SESSION['loggedIn'] = FALSE;

    $baseURL = 'http://aaubordfodbold.dk';
    if(defined('URL_HOME')) $baseURL = URL_HOME;

    header( 'Location: '.URL_HOME.'/admin.php' ) ;

}



function doBadStuff(){

    echo "I did bad stuff";

}





function printLoginForm(){

    echo "<form action=\"admin.php\" method=\"POST\">

          <table>

          <tr><td>Username</td><td><input type=\"text\" name=\"user\"/></td>

          <tr><td>Password</td><td><input type=\"password\" name=\"pass\"/></td>

          </table>

          <input type=\"submit\" value=\"Login\"/>

          <input type=\"submit\" name=\"generate\" value=\"Generate Hash\"/>

          </form>";

}



function printLogoutButton(){

    echo "<form action=\"admin.php\" method=\"POST\">

          <input type=\"submit\" name=\"logout\"/ value=\"Logout\">

          </form>

         ";

        

}







//Logged in

if(($_POST['user'] && $_POST['pass'] && login($_POST['user'], $_POST['pass'])) || $_SESSION['loggedIn'])

{

    if(isset($_POST['logout'])){

            logout();



    }

    printHeader("AAU Bordfodbold - Admin Panel", "Admin Panel");

    printLogoutButton();

    

    

    if (isset($_GET['run']))

    {

         $linkchoice=$_GET['run'];

    } else{

        $linkchoice='';

    }

    

    switch($linkchoice){

    

    case 'first' :

        $admin->recalculate();

        echo 'Matches recalculated!';

        break;

    /*case 'second' :

        $admin->otherFunction();

        break;

    */

    

    default :

        echo 'Nothing happened';

    

    }

    

    ?>

    <hr>

    <a href="?run=first">Recalculate</a>

    <br>

    <a href="?run=0">Refresh Page</a> 

    <?php

}



//Not logged in

else if ($_POST['generate'])
{
    printHeader("AAU Bordfodbold - Login", "Login");

    echo "<span>" . generateHash($_POST['pass']) . "</span>";

    printLoginForm();
}
else

{

    printHeader("AAU Bordfodbold - Login", "Login");

    printLoginForm();

}



printFooter();



?>