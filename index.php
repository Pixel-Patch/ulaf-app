<?php
$title = "ULAF - Home | PixelPatch";

require("header.php");
require("fetch-userid.php");

$userData = $_SESSION['user_data'] ?? []; // Retrieve user data from session

function fetchData($conn, $query)
{
	$data = [];
	if ($stmt = $conn->prepare($query)) {
		$stmt->execute();
		$result = $stmt->get_result();
		while ($row = $result->fetch_assoc()) {
			$data[] = $row;
		}
	} else {
		error_log("Database Query Error: " . $conn->error);
	}
	return $data;
}

// Fetch recently added 10 items
$recentItemsQuery = "SELECT items.*, categories.Category_Name 
                     FROM items 
                     LEFT JOIN categories ON items.Category_ID = categories.Category_ID 
                     ORDER BY items.Posted_Date DESC 
                     LIMIT 10";
$recentItems = fetchData($conn, $recentItemsQuery);

// Fetch categories with the count of items
$categoriesQuery = "
    SELECT categories.*, COUNT(items.Category_ID) as ItemCount
    FROM categories
    LEFT JOIN items ON categories.Category_ID = items.Category_ID
    GROUP BY categories.Category_ID";
$categories = fetchData($conn, $categoriesQuery);

// Fetch items posted in the last 7 days
$last7DaysQuery = "
    SELECT items.*, categories.Category_Name 
    FROM items 
    LEFT JOIN categories ON items.Category_ID = categories.Category_ID 
    WHERE items.Posted_Date >= DATE_SUB(NOW(), INTERVAL 7 DAY) 
    AND items.Item_Status = 'Posted'
    ORDER BY items.Posted_Date DESC";
$last7DaysItems = fetchData($conn, $last7DaysQuery);

// Fetch the 10 oldest "Posted" items
$oldestItemsQuery = "
    SELECT items.*, categories.Category_Name 
    FROM items 
    LEFT JOIN categories ON items.Category_ID = categories.Category_ID 
    WHERE items.Item_Status = 'Posted'
    ORDER BY items.Posted_Date ASC 
    LIMIT 5";
$oldestItems = fetchData($conn, $oldestItemsQuery);

?>

<style>
	del {
		text-decoration: none;
	}

	.dz-media {
		border-radius: 50px;
	}

	.overlay-swiper1 .swiper-slide {
		width: 225px;
	}

	.overlay-swiper2 .swiper-slide {
		width: 350px;
	}

	.dz-card-overlay a {
		margin-left: 10px;
	}

	ul {
		padding: 0px 10px 0px 10px;
	}

	p {
		margin: 5px 0 0 10px;
	}

	.truncated {
		display: -webkit-box;
		-webkit-line-clamp: 3;
		-webkit-box-orient: vertical;
		overflow: hidden;
		text-overflow: ellipsis;
	}

	.responsive-image {
		max-height: 125px;
		max-width: 150px;
		object-fit: cover;
	}

	.responsive-imagee {
		max-height: 180px;
		max-width: 150px;
		object-fit: cover;
	}

	.description {
		display: -webkit-box;
		-webkit-box-orient: vertical;
		-webkit-line-clamp: 2;
		overflow: hidden;
		text-overflow: ellipsis;
	}

	.item-name {
		white-space: nowrap;
		text-overflow: ellipsis;
		overflow: hidden;
		display: inline-block;
		max-width: 100%;
	}
</style>

</head>

<body>
	<div class="page-wrapper">
		<?php include "pre-loader.php"; ?>
		<?php include("sidebar.php"); ?>

		<div class="dz-nav-floting">
			<header class="header py-2 mx-auto">
				<div class="header-content">
					<div class="left-content">
						<div class="info">
							<p class="text m-b10" id="greeting">Good Morning/Afternoon/Evening</p>
							<h3 class="title"><?php echo $username ?? 'N/A'; ?></h3>
						</div>
					</div>
					<div class="mid-content"></div>
					<div class="right-content d-flex align-items-center gap-4">
						<a href="notification.php" class="notification-badge font-20 badge-active">
							<svg width="30" height="30" viewBox="0 0 24 24" class="svg-primary" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M21.7329 21.68C21.8273 21.5791 21.8998 21.4597 21.9457 21.3295C21.9917 21.1992 22.0101 21.0608 21.9999 20.923L20.9999 7.92299C20.9805 7.67134 20.8666 7.43634 20.6811 7.26515C20.4957 7.09396 20.2523 6.99924 19.9999 6.99999H16.9999C16.9999 5.67391 16.4731 4.40214 15.5355 3.46446C14.5978 2.52677 13.326 1.99999 11.9999 1.99999C10.6738 1.99999 9.40207 2.52677 8.46438 3.46446C7.5267 4.40214 6.99992 5.67391 6.99992 6.99999H3.99992C3.74752 6.99924 3.50417 7.09396 3.3187 7.26515C3.13323 7.43634 3.01935 7.67134 2.99992 7.92299L1.99992 20.923C1.98929 21.0606 2.00727 21.199 2.05275 21.3294C2.09822 21.4597 2.17019 21.5792 2.26413 21.6804C2.35807 21.7816 2.47194 21.8622 2.59858 21.9172C2.72521 21.9722 2.86186 22.0004 2.99992 22H20.9999C21.1375 22 21.2737 21.9715 21.3998 21.9165C21.5259 21.8614 21.6393 21.7809 21.7329 21.68ZM11.9999 3.99999C12.7956 3.99999 13.5586 4.31606 14.1212 4.87867C14.6838 5.44128 14.9999 6.20434 14.9999 6.99999H8.99992C8.99992 6.20434 9.31599 5.44128 9.8786 4.87867C10.4412 4.31606 11.2043 3.99999 11.9999 3.99999ZM4.07992 20L4.92592 8.99999H6.99992V11C6.99992 11.2652 7.10527 11.5196 7.29281 11.7071C7.48035 11.8946 7.7347 12 7.99992 12C8.26513 12 8.51949 11.8946 8.70702 11.7071C8.89456 11.5196 8.99992 11.2652 8.99992 11V8.99999H14.9999V11C14.9999 11.2652 15.1053 11.5196 15.2928 11.7071C15.4803 11.8946 15.7347 12 15.9999 12C16.2651 12 16.5195 11.8946 16.707 11.7071C16.8946 11.5196 16.9999 11.2652 16.9999 11V8.99999H19.0739L19.9199 20H4.07992Z" fill="#04764E"></path>
							</svg>
						</a>
						<a href="javascript:void(0);" class="icon dz-floating-toggler">
							<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
								<rect y="2" width="20" height="3" rx="1.5" fill="#5F5F5F" />
								<rect y="18" width="20" height="3" rx="1.5" fill="#5F5F5F" />
								<rect x="4" y="10" width="20" height="3" rx="1.5" fill="#5F5F5F" />
							</svg>
						</a>
					</div>
				</div>
			</header>

			<main class="page-content bg-white p-b60">
				<div class="container">
					<div class="search-box">
						<form action="items-search.php" method="get">
							<div class="input-group input-radius input-rounded input-lg">
								<input type="text" name="search" placeholder="Search item..." class="form-control">
								<button type="submit" class="input-group-text">
									<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M9.65925 19.3102C11.8044 19.3103 13.8882 18.5946 15.5806 17.2764L21.9653 23.6612C22.4423 24.1218 23.2023 24.1086 23.663 23.6316C24.1123 23.1664 24.1123 22.4288 23.663 21.9635L17.2782 15.5788C20.5491 11.3682 19.7874 5.30333 15.5769 2.03243C11.3663 -1.23848 5.30149 -0.476799 2.03058 3.73374C-1.24033 7.94428 -0.478646 14.0092 3.73189 17.2801C5.42702 18.5969 7.51269 19.3113 9.65925 19.3102ZM4.52915 4.5273C7.36245 1.69394 11.9561 1.69389 14.7895 4.5272C17.6229 7.3605 17.6229 11.9542 14.7896 14.7876C11.9563 17.6209 7.36261 17.621 4.52925 14.7877C4.5292 14.7876 4.5292 14.7876 4.52915 14.7876C1.69584 11.9749 1.67915 7.39794 4.49181 4.56464C4.50424 4.55216 4.51667 4.53973 4.52915 4.5273Z" fill="#C9C9C9" />
									</svg>
								</button>
							</div>
						</form>
					</div>


					<div class="swiper overlay-swiper1" style="padding-top: 20px;">
						<div class="title-bar mb-0">
							<h5 class="title">Recently Added</h5>
							<a href="items.php">load more</a>
						</div>

						<div class="swiper-wrapper">
							<?php foreach ($recentItems as $item) :
								$images = explode(',', $item['Image']);
								$firstImage = trim($images[0]);
							?>
								<div class="swiper-slide">
									<div class="dz-card-overlay style-1" style="border-radius: 50px;">
										<div class="dz-media ">
											<a href="view-item-details.php?item_id=<?php echo $item['Item_ID']; ?>">
												<img src="assets/uploads/items/<?php echo $firstImage; ?>" alt="image" class="responsive-imagee">
											</a>
										</div>
										<div class="dz-info">
											<h6 class="title">
												<span class="badge badge-<?php echo ($item['Type'] == 'found') ? 'success' : 'danger'; ?>">
													<?php echo $item['Type']; ?>
												</span><br>
												<a href="view-item-details.php?item_id=<?php echo $item['Item_ID']; ?>" class="item-name">
													<?php echo $item['Item_Name']; ?>
												</a>
											</h6>
											<ul class="dz-meta">
												<li class="dz-price">
													<del class="no-line"><?php echo $item['Category_Name']; ?></del>
												</li>
											</ul>
										</div>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					</div>

					<div class="title-bar mb-0">
						<h5 class="title">Categories</h5>
					</div>
					<div class="swiper categories-swiper dz-swiper m-b20">
						<div class="swiper-wrapper">
							<?php
							$icons = [
								'electronics' => 'fa-tv',
								'musical-instruments' => 'fa-music',
								'toys' => 'fa-puzzle-piece',
								'documents' => 'fa-file-alt',
								'cameras' => 'fa-camera',
								'wallets' => 'fa-wallet',
								'headphones' => 'fa-headphones',
								'school-supplies' => 'fa-pencil-ruler',
								'miscellaneous' => 'fa-box',
								'clothing' => 'fa-shirt',
								'books' => 'fa-book',
								'keys' => 'fa-key',
								'bags' => 'fa-briefcase',
								'water-bottles' => 'fa-water',
								'glasses' => 'fa-glasses',
								'umbrellas' => 'fa-umbrella',
								'sports-equipment' => 'fa-football-ball'
							];
							foreach ($categories as $category) :
								$categoryName = strtolower(str_replace(' ', '-', $category['Category_Name']));
								$iconClass = isset($icons[$categoryName]) ? $icons[$categoryName] : 'fa-box';
							?>
								<div class="swiper-slide">
									<div class="dz-categories-bx">
										<div class="icon-bx">
											<a href="cat-<?php echo $categoryName; ?>.php">
												<i style="font-size: 24px;" class="fa-regular <?php echo $iconClass; ?>"></i>
											</a>
										</div>
										<div class="dz-content">
											<h6 class="title"><a href="cat-<?php echo $categoryName; ?>.php"><?php echo $category['Category_Name']; ?></a></h6>
											<span class="menus text-primary"><?php echo $category['ItemCount']; ?> Items</span>
										</div>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					</div>

					<div class="title-bar mb-0">
						<h5 class="title">Last 7 days <br></h5>
						<a href="items.php">load more</a>
					</div>
					<div class="swiper overlay-swiper2" style="padding-top: 25px;">
						<div class="swiper-wrapper">
							<?php foreach ($last7DaysItems as $item) :
								$images = explode(',', $item['Image']);
								$firstImage = trim($images[0]);
							?>
								<div class="swiper-slide">
									<div class="dz-wishlist-bx">
										<div class="dz-media">
											<a href="view-item-details.php?item_id=<?php echo $item['Item_ID']; ?>">
												<img src="assets/uploads/items/<?php echo $firstImage; ?>" alt="image" class="responsive-image">
											</a>
										</div>
										<div class="dz-info">
											<div class="dz-head">
												<h6 class="title item-name" style="padding-right:40%;"> <a href="view-item-details.php?item_id=<?php echo $item['Item_ID']; ?>"><?php echo $item['Item_Name']; ?></a></h6>
												<span class="badge badge-<?php echo ($item['Type'] == 'Found') ? 'success' : 'danger'; ?>"><?php echo $item['Type']; ?></span>
												<span class="badge light badge-light"><?php echo $item['Posted_Date']; ?></span>
												<p class="description" style="padding-right:10%;"><?php echo $item['Description']; ?></p>
											</div>
										</div>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					</div>

					<div class="accordion-item accordion-primary">
						<div class="accordion-header" id="headingOne" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-controls="collapseOne" aria-expanded="true" role="button">
							<span class="accordion-header-icon"></span>
							<span class="accordion-header-text">Unclaimed Found Items</span>
							<span class="accordion-header-indicator"></span>
						</div>
						<div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-bs-parent="#accordion-one">
							<div class="accordion-body-text">
								Attention: Unclaimed items in the lost and found will be donated or recycled at the end of the semester. Please check for any missing items and claim them before then. Go to USF Office for more details.
							</div>
						</div>
					</div>

					<p></p>

					<ul class="featured-list">
						<div class="row g-3">
							<?php foreach ($oldestItems as $item) :
								$images = explode(',', $item['Image']);
								$firstImage = trim($images[0]);
							?>
								<div class="col-12 col-sm-12">
									<div class="dz-wishlist-bx">
										<div class="dz-media">
											<a href="view-item-details.php?item_id=<?php echo $item['Item_ID']; ?>"><img src="assets/uploads/items/<?php echo $firstImage; ?>" alt="image" class="responsive-image"></a>
										</div>
										<div class="dz-info">
											<div class="dz-head">
												<h6 class="title item-name"><a href="view-item-details.php?item_id=<?php echo $item['Item_ID']; ?>"><?php echo $item['Item_Name']; ?></a></h6>
												<span class="badge badge-<?php echo ($item['Type'] == 'found') ? 'success' : 'danger'; ?>" style="margin-right: 100%;"><?php echo $item['Type']; ?></span>
												<span class="badge light badge-light"><?php echo $item['Posted_Date']; ?></span>
												<p class="description">
													<?php echo htmlspecialchars($item['Description'], ENT_QUOTES, 'UTF-8'); ?>
												</p>
											</div>
										</div>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					</ul>
					<a href="unclaimed-found-item.php" class="btn mb-2 me-2 btn-block btn-secondary">Load More</a>
				</div>
			</main>

			<div class="menubar-area footer-fixed">
				<div class="toolbar-inner menubar-nav">
					<a href="index.php" class="nav-link active">
						<i class="fi fi-rr-home"></i>
					</a>
					<a href="view-my-lists.php" class="nav-link">
						<i class="fa-regular fa-clipboard-list"></i>
					</a>
					<a href="view-user-profile.php" class="nav-link">
						<i class="fi fi-rr-user"></i>
					</a>
					<a href="add-item-details.php" class="nav-link">
						<i class="fa-regular fa-file-circle-plus"></i>
					</a>
				</div>
			</div>
		</div>

		<div class="modal fade dz-pwa-modal" id="pwaModal" tabindex="-1" aria-labelledby="pwaModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<img class="logo dark" src="assets/images/app-logo/logo.png" alt="">
					<img class="logo light" src="assets/images/app-logo/logo-white.png" alt="">
					<h5 class="title">ULAF - University Lost and Found</h5>
					<p class="pwa-text">To fully utilize the app's features, including posting and claiming items, please complete the registration process.</p>
					<a href="add-user-details.php" class="btn pwa-btn" onclick="completeRegistration()">
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M12 16.0001V13.0001M12 13.0001V10.0001M12 13.0001H9M12 13.0001H15M4 16.8002V11.4522C4 10.9179 4 10.6506 4.06497 10.4019C4.12255 10.1816 4.2173 9.97307 4.34521 9.78464C4.48955 9.57201 4.69064 9.39569 5.09277 9.04383L9.89436 4.84244C10.6398 4.19014 11.0126 3.86397 11.4324 3.73982C11.8026 3.63035 12.1972 3.63035 12.5674 3.73982C12.9875 3.86406 13.3608 4.19054 14.1074 4.84383L18.9074 9.04383C19.3096 9.39569 19.5102 9.57201 19.6546 9.78464C19.7825 9.97307 19.8775 10.1816 19.9351 10.4019C20 10.6505 20 10.9184 20 11.4522V16.8037C20 17.9216 20 18.4811 19.7822 18.9086C19.5905 19.2849 19.2842 19.5906 18.9079 19.7823C18.4805 20.0001 17.9215 20.0001 16.8036 20.0001H7.19691C6.07899 20.0001 5.5192 20.0001 5.0918 19.7823C4.71547 19.5906 4.40973 19.2849 4.21799 18.9086C4 18.4807 4 17.9203 4 16.8002Z" stroke="#03764D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
						</svg>
						<span>Complete Registration</span>
					</a>
				</div>
			</div>
		</div>
	</div>

	<script src="assets/js/jquery.js"></script>
	<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
	<script src="assets/js/dz.carousel.js"></script>
	<script src="assets/js/settings.js"></script>
	<script src="assets/js/custom.js"></script>
	<script src="index.js"></script>
	<script>
		function getPhilippineTime() {
			const now = new Date();
			const utcOffset = now.getTimezoneOffset() * 60000;
			const philippinesOffset = 8 * 60 * 60000; // UTC+8 for PHT
			const pht = new Date(now.getTime() + utcOffset + philippinesOffset);
			return pht;
		}

		function getGreeting() {
			const currentHour = getPhilippineTime().getHours();
			let greeting;

			if (currentHour < 12) {
				greeting = "Good Morning";
			} else if (currentHour < 18) {
				greeting = "Good Afternoon";
			} else {
				greeting = "Good Evening";
			}

			return greeting;
		}

		document.getElementById('greeting').innerText = getGreeting();
		document.getElementById('username').innerText = username;
	</script>
</body>

</html>