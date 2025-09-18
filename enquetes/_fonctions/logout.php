<?php

session_start();

unset($_SESSION['admin']);

echo "<script language='javascript'>
        document.location.replace('../bo/_views/login.php')
    </script>";

?>