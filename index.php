<?php session_start(); if(isset($_SESSION["uid"])) header("Location: languages.php"); else header("Location: landing.php");?>
