<?php
$title = "ULAF - Item Page | PixelPatch";
require("header.php");
$search = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_STRING);

function fetchData($conn, $query, $params = [])
{
	$data = [];
	if ($stmt = $conn->prepare($query)) {
		if (!empty($params)) {
			$stmt->bind_param(...$params);
		}
		$stmt->execute();
		$result = $stmt->get_result();
		if ($result) {
			while ($row = $result->fetch_assoc()) {
				$data[] = $row;
			}
		} else {
			error_log("Database Query Error: " . $stmt->error);
		}
		$stmt->close();
	} else {
		error_log("Database Query Error: " . $conn->error);
	}
	return $data;
}

$searchQuery = "
    SELECT Item_ID, Item_Name, Image, Type, Category_ID, Description, Pin_Location, Posted_Date, Current_Location, Poster_ID, Item_Status, Latitude, Longitude, Retrieved_By, Retrieved_Date 
    FROM items 
    WHERE Item_Name LIKE CONCAT('%', ?, '%')";
$searchResults = fetchData($conn, $searchQuery, ['s', $search]);

foreach ($searchResults as $item) {
	// Assuming $item['Category_ID'] contains the category ID
	$categoryQuery = "SELECT Category_Name FROM categories WHERE Category_ID = ?";
	$categoryResult = fetchData($conn, $categoryQuery, ['i', $item['Category_ID']]);
	$categoryName = $categoryResult[0]['Category_Name']; // Assuming only one result is expected
}

?>

<style>
	.mySwiper {
		position: -webkit-sticky;
		position: sticky;
		top: 0;
		z-index: 1000;
		background-color: white;
		border-bottom: 1px solid #ccc;
	}

	.dz-categories-bx.active {
		border: 2px solid darkgreen;
	}

	.dz-categories-bx .title.active-title a {
		color: #04764e;
	}

	.m-b20 {
		margin-bottom: -10px;
	}

	.suggestions-box {
		position: absolute;
		background-color: white;
		border: 1px solid #ccc;
		border-top: 1px solid #fff;
		border-bottom: 1px solid #fff;
		border-radius: 5px;
		max-height: 200px;
		max-width: 90%;
		overflow-y: auto;
		width: 90%;
		z-index: 1000;
		margin-left: 10px;
	}

	.suggestion-item {
		padding: 10px;
		cursor: pointer;
	}

	.suggestion-item:hover {
		background-color: #f0f0f0;
	}

	.responsive-image {
		max-height: 140px;
		max-width: 150px;
		object-fit: cover;
	}
</style>

</head>

<body>
	<div class="page-wrapper">
		<!-- Preloader -->
		<!-- <?php include "pre-loader.php"; ?> -->
		<!-- Preloader end-->
		<!-- Header -->
		<header class="header header-fixed">
			<div class="header-content">
				<div class="left-content">
					<a href="index.php" class="back-btn">
						<i class="feather icon-arrow-left"></i>
					</a>
				</div>
				<div class="mid-content">
					<h4 class="title">Items</h4>
				</div>
				<div class="right-content d-flex align-items-center gap-4">
					<a href="javascript:void(0);" class="font-24">
						<i class="font-w700 feather icon-more-vertical-"></i>
					</a>
				</div>
			</div>
		</header>
		<!-- Header -->
		<!-- Main Content Start -->
		<main class="page-content space-top">
			<div class="container">
				<!-- SearchBox -->
				<form method="GET" action="items-search.php">
					<div class="search-box">
						<div class="input-group input-radius input-rounded input-lg">
							<input type="text" id="search-input" name="search" placeholder="Search item..." class="form-control" value="<?php echo htmlspecialchars($search, ENT_QUOTES, 'UTF-8'); ?>">
							<button type="submit" class="input-group-text">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M9.65925 19.3102C11.8044 19.3103 13.8882 18.5946 15.5806 17.2764L21.9653 23.6612C22.4423 24.1218 23.2023 24.1086 23.663 23.6316C24.1123 23.1664 24.1123 22.4288 23.663 21.9635L17.2782 15.5788C20.5491 11.3682 19.7874 5.30333 15.5769 2.03243C11.3663 -1.23848 5.30149 -0.476799 2.03058 3.73374C-1.24033 7.94428 -0.478646 14.0092 3.73189 17.2801C5.42702 18.5969 7.51269 19.3113 9.65925 19.3102ZM4.52915 4.5273C7.36245 1.69394 11.9561 1.69389 14.7895 4.5272C17.6229 7.3605 17.6229 11.9542 14.7896 14.7876C11.9563 17.6209 7.36261 17.621 4.52925 14.7877C4.5292 14.7876 4.5292 14.7876 4.52915 14.7876Z" fill="#C9C9C9" />
								</svg>
							</button>
						</div>
						<div class="suggestions-box" id="suggestions-box"></div>
					</div>
				</form>
				<!-- SearchBox -->

				<ul class="featured-list">
					<div class="row g-3">
						<?php if (count($searchResults) > 0) : ?>
							<?php foreach ($searchResults as $item) :
								$images = explode(',', $item['Image']);
								$firstImage = trim($images[0]);
							?>
								<div class="col-12 col-sm-12">
									<div class="dz-wishlist-bx">
										<div class="dz-media">
											<a href="view-item-details.php?item_id=<?php echo $item['Item_ID']; ?>"><img src="assets/uploads/items/<?php echo $firstImage; ?>" alt="image" class="responsive-image"></a>
										</div>
										<?php foreach ($searchResults as $item) {
											// Assuming $item['Category_ID'] contains the category ID
											$categoryQuery = "SELECT Category_Name FROM categories WHERE Category_ID = ?";
											$categoryResult = fetchData($conn, $categoryQuery, ['i', $item['Category_ID']]);
											$categoryName = $categoryResult[0]['Category_Name']; // Assuming only one result is expected

											// Displaying item information
										?>
											<div class="dz-info">
												<div class="dz-head">
													<h6 class="title item-name"><a href="view-item-details.php?item_id=<?php echo $item['Item_ID']; ?>"><?php echo $item['Item_Name']; ?></a></h6>
													<p style="padding-bottom: 5%;"><?php echo $categoryName; ?></p>
													<span class="badge badge-<?php echo ($item['Type'] == 'found') ? 'success' : 'danger'; ?>"><?php echo $item['Type']; ?></span>
													<span class="badge light badge-light"><?php echo $item['Posted_Date']; ?></span>
													<p class=" description" style="padding-top: 5%;">
														<?php echo htmlspecialchars($item['Description'], ENT_QUOTES, 'UTF-8'); ?>
													</p>
												</div>
											</div>
										<?php
										}
										?>
									</div>
								</div>
							<?php endforeach; ?>
						<?php else : ?>
							<div class="col-12 col-sm-12">
								<p>No items found.</p>
							</div>
						<?php endif; ?>
					</div>
				</ul>

			</div>
		</main>
		<!-- Main Content End -->
	</div>
	<!--**********************************
    Scripts
***********************************-->
	<script src="assets/js/jquery.js"></script>
	<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="assets/vendor/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js"></script>
	<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
	<script src="assets/vendor/wnumb/wNumb.js"></script>
	<script src="assets/vendor/nouislider/nouislider.min.js"></script>
	<script src="assets/js/noui-slider.init.js"></script>
	<script src="assets/js/dz.carousel.js"></script>
	<script src="assets/js/settings.js"></script>
	<script src="assets/js/custom.js"></script>
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			const searchInput = document.getElementById('search-input');
			const suggestionsBox = document.getElementById('suggestions-box');

			searchInput.addEventListener('input', function() {
				const query = searchInput.value;

				if (query.length > 2) {
					fetch(`search_suggestions.php?search=${query}`)
						.then(response => response.json())
						.then(data => {
							suggestionsBox.innerHTML = '';
							if (data.length > 0) {
								data.forEach(item => {
									const suggestionItem = document.createElement('div');
									suggestionItem.className = 'suggestion-item';
									suggestionItem.textContent = item.Item_Name;
									suggestionItem.addEventListener('click', () => {
										searchInput.value = item.Item_Name;
										suggestionsBox.innerHTML = '';
										window.location.href = `items-search.php?search=${item.Item_Name}`;
									});
									suggestionsBox.appendChild(suggestionItem);
								});
								suggestionsBox.style.display = 'block';
							} else {
								suggestionsBox.style.display = 'none';
							}
						})
						.catch(error => {
							console.error('Error fetching suggestions:', error);
							suggestionsBox.innerHTML = '';
							suggestionsBox.style.display = 'none';
						});
				} else {
					suggestionsBox.innerHTML = '';
					suggestionsBox.style.display = 'none';
				}
			});

			document.addEventListener('click', function(event) {
				if (!event.target.closest('.search-box')) {
					suggestionsBox.innerHTML = '';
					suggestionsBox.style.display = 'none';
				}
			});
		});
	</script>

</body>

</html>