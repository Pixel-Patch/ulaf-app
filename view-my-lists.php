<?php
$title = "ULAF - My List | PixelPatch";
require("header.php");
require("fetch-userid.php");

// Fetch user claims
$myclaims = [];
$claimsQuery = "SELECT items.*, claims.Claim_ID, claims.Claim_Status, claims.Proof, claims.Proof_Image, claims.Claim_Date, claims.Verification_Status, claims.Verification_Date
                FROM claims 
                JOIN items ON claims.Item_ID = items.Item_ID
                WHERE claims.Claimer_ID = ?
				ORDER BY claims.Claim_Date DESC";

if ($stmt = $conn->prepare($claimsQuery)) {
	$stmt->bind_param("i", $userId);
	$stmt->execute();
	$result = $stmt->get_result();

	while ($row = $result->fetch_assoc()) {
		$myclaims[] = $row;
	}
}

// Fetch user posts
$mypost = [];
$postsQuery = "SELECT * FROM items WHERE Poster_ID = ? ORDER BY Posted_Date DESC";

if ($stmt = $conn->prepare($postsQuery)) {
	$stmt->bind_param("i", $userId);
	$stmt->execute();
	$result = $stmt->get_result();

	while ($row = $result->fetch_assoc()) {
		if ($row['Poster_ID'] == $userId) {
			$mypost[] = $row;
		}
	}
}
?>

<style>
	.default-tab.style-2 .nav-tabs {
		margin-top: -28px;
	}

	.responsive-image {
		max-height: 125px;
		max-width: 150px;
		object-fit: cover;
	}

	.right-content {
		position: absolute;
		top: 0;
		right: 0;
		padding: 10px;
	}

	.item-name {
		display: -webkit-box;
		-webkit-box-orient: vertical;
		-webkit-line-clamp: 2;
		overflow: hidden;
		text-overflow: ellipsis;
	}
</style>

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
		<header class="header header-sticky border-bottom">
			<div class="header-content">
				<div class="mid-content">
					<h4 class="title">My Lists</h4>
				</div>
			</div>
		</header>
		<!-- Header -->

		<!-- Main Content Start -->
		<main class="page-content space-top">
			<div class="container pt-0">
				<div class="default-tab style-2 mt-1">
					<ul class="nav nav-tabs" role="tablist">
						<li class="nav-item" role="presentation">
							<a class="nav-link active" data-bs-toggle="tab" href="#home" aria-selected="true" role="tab">Claims</a>
						</li>
						<li class="nav-item" role="presentation">
							<a class="nav-link" data-bs-toggle="tab" href="#profile" aria-selected="false" role="tab" tabindex="-1">Posts</a>
						</li>
					</ul>


					<!-- Featured Beverages -->
					<div class="tab-content">
						<div class="tab-pane fade active show" id="home" role="tabpanel">
							<ul class="featured-list" style="margin-bottom: 18%;">
								<div class="row g-3">
									<?php foreach ($myclaims as $item) :
										// Handle multiple images by taking the first one
										$images = explode(',', $item['Image']);
										$firstImage = trim($images[0]);
									?>
										<div class="col-12 col-sm-12">
											<div class="dz-wishlist-bx">

												<div class="dz-media">
													<a href="view-my-claim-details.php?claim_id=<?php echo $item['Claim_ID']; ?>"><img src="assets/uploads/items/<?php echo $firstImage; ?>" alt="image" class="responsive-image"></a>
												</div>
												<div class="dz-info">
													<br>
													<div class="dz-head">
														<p>Claim # <?php echo $item['Claim_ID']; ?></p>
														<h6 class="title"><a href="view-my-claim-details.php?claim_id=<?php echo $item['Claim_ID']; ?>"><?php echo $item['Item_Name']; ?></a></h6>

														<br>
														<?php
														if ($item['Verification_Status'] == 'Pending') {
															echo '<span class="badge badge-info" style="font-size: 18px; position: absolute; bottom: 0; right: 0; margin-right: 17px; margin-bottom: 14px;">Pending</span>';
														} elseif ($item['Verification_Status'] == 'Cl') {
															echo '<span class="badge badge-dark" style="font-size: 18px; position: absolute; bottom: 0; right: 0; margin-right: 17px; margin-bottom: 14px;" >Declined</span>';
														} elseif ($item['Verification_Status'] == 'Approved') {
															echo '<span class="badge badge-success" style="font-size: 18px; position: absolute; bottom: 0; right: 0; margin-right: 17px; margin-bottom: 14px;" >Approved</span>';
														}
														?>




													</div>

												</div>
											</div>
										</div>
									<?php endforeach; ?>
								</div>
							</ul>
						</div>
						<div class="tab-pane fade" id="profile" role="tabpanel">
							<ul class="featured-list" style="margin-bottom: 18%;">
								<div class="row g-3">
									<?php foreach ($mypost as $item) :
										// Handle multiple images by taking the first one
										$images = explode(',', $item['Image']);
										$firstImage = trim($images[0]);
									?>
										<div class="col-12 col-sm-12">
											<div class="dz-wishlist-bx">
												<a href="view-my-post-claims.php?item_id=<?php echo $item['Item_ID']; ?>">
													<div class="dz-media">
														<img src="assets/uploads/items/<?php echo $firstImage; ?>" alt="image" class="responsive-image">

													</div>
													<div class="dz-info">

														<?php if ($item['Poster_ID'] == $userId && $item['Item_Status'] != 'Returned' && $item['Item_Status'] != 'Retrieved') : ?>
															<div class="right-content d-flex align-items-center gap-4">
																<a href="edit-item-details.php?item_id=<?php echo $item['Item_ID']; ?>">
																	<svg enable-background="new 0 0 461.75 461.75" height="18" viewBox="0 0 461.75 461.75" width="18" xmlns="http://www.w3.org/2000/svg">
																		<path d="m23.099 461.612c2.479-.004 4.941-.401 7.296-1.177l113.358-37.771c3.391-1.146 6.472-3.058 9.004-5.587l226.67-226.693 75.564-75.541c9.013-9.016 9.013-23.63 0-32.645l-75.565-75.565c-9.159-8.661-23.487-8.661-32.645 0l-75.541 75.565-226.693 226.67c-2.527 2.53-4.432 5.612-5.564 9.004l-37.794 113.358c-4.029 12.097 2.511 25.171 14.609 29.2 2.354.784 4.82 1.183 7.301 1.182zm340.005-406.011 42.919 42.919-42.919 42.896-42.896-42.896zm-282.056 282.056 206.515-206.492 42.896 42.896-206.492 206.515-64.367 21.448z" fill="#808080"></path>
																	</svg>
																</a>
															</div>
														<?php endif; ?>
														<div class="dz-head">
															<h6 class="title item-name"><a href="view-my-post-claims.php?item_id=<?php echo $item['Item_ID']; ?>"><?php echo $item['Item_Name']; ?></a></h6>
															<span class="badge badge-<?php echo ($item['Type'] == 'found') ? 'success' : 'danger'; ?>">
																<?php echo $item['Type']; ?>
															</span>
															<?php
															if ($item['Item_Status'] == 'Posted') {
																echo '<span class="badge badge-light" style="font-size: 18px; position: absolute; bottom: 0; right: 0; margin-right: 17px; margin-bottom: 14px;">Posted</span>';
															} elseif ($item['Item_Status'] == 'Claiming') {
																echo '<span class="badge badge-secondary" style="font-size: 18px; position: absolute; bottom: 0; right: 0; margin-right: 17px; margin-bottom: 14px;" >Claiming</span>';
															} elseif ($item['Item_Status'] == 'Claimed') {
																echo '<span class="badge badge-success" style="font-size: 18px; position: absolute; bottom: 0; right: 0; margin-right: 17px; margin-bottom: 14px;" >Claimed</span>';
															} elseif ($item['Item_Status'] == 'Returning' || $item['Item_Status'] == 'Retrieving') {
																echo '<span class="badge badge-warning" style="font-size: 18px; position: absolute; bottom: 0; right: 0; margin-right: 17px; margin-bottom: 14px;" >' . ucfirst($item['Item_Status']) . '</span>';
															} elseif ($item['Item_Status'] == 'Returned' || $item['Item_Status'] == 'Retrieved') {
																echo '<span class="badge badge-info" style="font-size: 18px; position: absolute; bottom: 0; right: 0; margin-right: 17px; margin-bottom: 14px;" >' . ucfirst($item['Item_Status']) . '</span>';
															}

															?>

														</div>
													</div>
												</a>
											</div>
										</div>
									<?php endforeach; ?>
								</div>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</main>
		<!-- Main Content End -->


		<!-- Menubar -->
		<?php include('menubar.php'); ?>
		<!-- Menubar -->

	</div>
	<!--**********************************
    Scripts
***********************************-->
	<script src="assets/js/jquery.js"></script>
	<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
	<script src="assets/vendor/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js"></script>
	<script src="assets/js/settings.js"></script>
	<script src="assets/js/custom.js"></script>
</body>

</html>