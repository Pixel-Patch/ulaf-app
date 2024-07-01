<?php
session_start(); // Start the session

require_once 'dbconn.php'; // Include your database connection file

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
	header('Location: sign-in.php'); // Redirect to the sign-in page
	exit(); // Stop further execution
}
$username = $_SESSION['username'];
$userId = $_SESSION['user_id'];

// Check if the registration is incomplete and if the current page is not add-user-details.php
if (isset($_SESSION['registration_incomplete']) && $_SESSION['registration_incomplete'] === true && basename($_SERVER['PHP_SELF']) !== 'add-user-details.php') {
	header("Location: add-user-details.php");
	exit();
}
?>




<!DOCTYPE html>
<html lang="en">


<head>

	<title><?php echo $title; ?></title>
	<!-- Meta -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="author" content="Pixel-Patch">
	<meta name="robots" content="index, follow">


	<meta name="keywords" content="university, lost, found, ULAF, PixelPatch, campus, items, report, claim, student services, mobile app, web app, responsive design, user-friendly interface, innovative technology, app development, digital solution, online presence, university services">

	<meta name="description" content="Discover ULAF, a University Lost and Found mobile and web app designed by PixelPatch. Report or claim lost items, enjoy a user-friendly interface, and experience innovative technology at your fingertips. ULAF is the perfect digital solution to streamline your university's lost and found services.">

	<meta property="og:title" content="ULAF - Home | PixelPatch">
	<meta property="og:description" content="Discover ULAF, a University Lost and Found mobile and web app designed by PixelPatch. Report or claim lost items, enjoy a user-friendly interface, and experience innovative technology at your fingertips. ULAF is the perfect digital solution to streamline your university's lost and found services.">

	<meta property="og:image" content="Your Image URL">

	<meta name="format-detection" content="telephone=no">

	<meta name="twitter:title" content="ULAF - Home | PixelPatch">
	<meta name="twitter:description" content="Discover ULAF, a University Lost and Found mobile and web app designed by PixelPatch. Report or claim lost items, enjoy a user-friendly interface, and experience innovative technology at your fingertips. ULAF is the perfect digital solution to streamline your university's lost and found services.">

	<!-- Mobile Specific -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5, minimum-scale=1, minimal-ui, viewport-fit=cover">

	<!-- Favicons Icon -->
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/app-logo/favicon.png">

	<!-- PWA Version -->
	<link rel="manifest" href="manifest.json">

	<!-- Global CSS -->
	<link href="assets/vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
	<link rel="stylesheet" href="assets/vendor/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css">
	<link rel="stylesheet" href="assets/vendor/swiper/swiper-bundle.min.css">

	<!-- Stylesheets -->
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">

	<!-- Google Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;800;900&family=Raleway:wght@300;400;500&display=swap" rel="stylesheet">

	<!-- Font Awesome -->
	<link rel="stylesheet" data-purpose="Layout StyleSheet" title="Web Awesome" href="/css/app-wa-d53d10572a0e0d37cb8d614a3f177a0c.css?vsn=d">
	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.2/css/all.css">
	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.2/css/sharp-thin.css">
	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.2/css/sharp-solid.css">
	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.2/css/sharp-regular.css">
	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.2/css/sharp-light.css">

	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>