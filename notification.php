<?php
$title = "ULAF - My Notification | PixelPatch";
require('header.php');

require('dbconn.php');

require('fetch-userid.php'); // Ensure this file sets $userId


// Fetch notifications for the current user
$sql = "
    SELECT Notification_ID, Notification_Text, Timestamp 
    FROM notifications 
    WHERE User_ID = ?
    ORDER BY Timestamp DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
?>
</head>

<body>
	<div class="page-wrapper">

		<!-- Preloader -->
		<div id="preloader">
			<div class="loader">
				<div class="spinner-border text-primary" role="status">
					<span class="visually-hidden">Loading...</span>
				</div>
			</div>
		</div>
		<!-- Preloader end-->

		<!-- Header -->
		<header class="header header-fixed border-bottom">
			<div class="header-content">
				<div class="left-content">
					<a href="javascript:void(0);" class="back-btn">
						<i class="feather icon-arrow-left"></i>
					</a>
				</div>
				<div class="mid-content">
					<h4 class="title">Notifications (12)</h4>
				</div>
				<div class="right-content">
					<a href="search.php" class="icon font-24">
						<i class="icon feather icon-search"></i>
					</a>
				</div>
			</div>
		</header>
		<!-- Header -->

		<!-- Main Content Start -->
		<main class="page-content space-top">
			<div class="container pb-0 overflow-hidden">
				<div class="dz-list notification-list">
					<ul>
						<?php while ($row = $result->fetch_assoc()) : ?>
							<li class="list-items pull_delete">
								<div class="media">
									<div class="media-60 m-r10">
										<img src="assets/images/avatar/1.jpg" alt="">
									</div>
									<div class="list-content">
										<h5 class="title"><?php echo htmlspecialchars($row['Notification_Text']); ?></h5>
										<span class="date"><?php echo date('d M Y', strtotime($row['Timestamp'])); ?></span>
									</div>
								</div>
							</li>
						<?php endwhile; ?>
					</ul>
				</div>
			</div>
		</main>
		<!-- Main Content End -->
	</div>
	<!--**********************************
    Scripts
	***********************************-->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="assets/js/jquery.js"></script>
	<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
	<script src="assets/vendor/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js"></script>
	<script src="assets/js/pulldelete.js"></script>
	<script src="assets/js/settings.js"></script>
	<script src="assets/js/custom.js"></script>
	<script>
		$(function() {
			$('.pull_delete').pulldelete(function($dom) {
				// something you want here
				console.log('click delete');
				$dom.remove();
			});
		})
	</script>

	<script>
		function checkNewClaims() {
			$.ajax({
				url: 'check_new_claims.php',
				method: 'GET',
				dataType: 'json',
				success: function(response) {
					if (response.newClaims && response.newClaims.length > 0) {
						insertNotifications(response.newClaims);
					}
				},
				error: function(xhr, status, error) {
					console.error('Error checking for new claims:', error);
				}
			});
		}

		function insertNotifications(newClaims) {
			$.ajax({
				url: 'insert_notifications.php',
				method: 'POST',
				data: {
					claims: JSON.stringify(newClaims)
				},
				dataType: 'json',
				success: function(response) {
					if (response.success) {
						console.log('Notifications inserted successfully');
					} else {
						console.error('Failed to insert notifications');
					}
				},
				error: function(xhr, status, error) {
					console.error('Error inserting notifications:', error);
				}
			});
		}

		// Run the check every 30 seconds
		setInterval(checkNewClaims, 30000);
	</script>
</body>

</html>

<?php
$stmt->close();
$conn->close();
?>