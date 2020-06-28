<?php

$pwd = password_hash("egg", PASSWORD_DEFAULT);
echo $pwd;
$pwd = password_verify("egg", $pwd);
echo " " . $pwd;

?>
