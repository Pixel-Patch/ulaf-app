<?php $title = "ULAF - Item Details | PixelPatch";

require("head.php"); ?>
<style>
	.swiper {
		margin-bottom: 100px !important;
	}

	.dz-product-detail {
		margin-top: -122px;
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
		<header class="header header-fixed transparent">
			<div class="header-content">
				<div class="left-content">
					<a href="javascript:void(0);" class="back-btn">
						<i class="feather icon-arrow-left"></i>
					</a>
				</div>
				<div class="mid-content">
					<h4 class="title">Item Details</h4>
				</div>
				<div class="right-content d-flex align-items-center gap-4">
					<a href="javascript:void(0);" class="item-bookmark style-3">
						<i class="far fa-bookmark"></i>
						<i class="fas fa-bookmark"></i>
					</a>
				</div>
			</div>
		</header>
		<!-- Header -->

		<!-- Main Content Start -->
		<main class="page-content p-b80">
			<div class="container p-0">
				<div class="dz-product-preview bg-primary">
					<div class="swiper product-detail-swiper">
						<div class="swiper-wrapper">
							<div class="swiper-slide">
								<div class="dz-media">
									<img src="assets/images/items/product3.jpg" alt="">
								</div>
							</div>
							<div class="swiper-slide">
								<div class="dz-media">
									<img src="assets/images/items/product2.jpg" alt="">
								</div>
							</div>
							<div class="swiper-slide">
								<div class="dz-media">
									<img src="assets/images/items/product1.jpg" alt="">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="dz-product-detail">
					<div class="dz-handle"></div>
					<div class="detail-content">
						<h4 class="title">Item Name</h4>
						<span class="badge light badge-info">Posted</span>
						<p>“Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do</p>
					</div>
					<div class="item-wrapper">

						<div class="description">
							<p class="text-light">*Dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore</p>
						</div>
						<div class="description">
							<p class="text-light">*Dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore</p>
						</div>
						<div class="description">
							<p class="text-light">*Dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore</p>
						</div>
					</div>
				</div>
			</div>
		</main>
		<!-- Main Content End -->

		<div class="footer fixed bg-white">
			<div class="container">
			<button type="button" class="btn btn-primary btn-lg rounded-xl btn-thin w-100 gap-2" data-bs-toggle="modal" data-bs-target="#claimModal">Claim Item</button>
			</div>
			
		</div>
		<!-- Modal -->
		<div class="modal fade" id="claimModal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Claim Item</h5>
                <button class="btn-close" data-bs-dismiss="modal">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="claim-form">
                    <div class="mb-3">
                        <label for="distinguishableMarks" class="form-label">Distinguishable Marks</label>
                        <textarea id="distinguishableMarks" class="form-control" rows="3" placeholder="Describe any unique marks or features on the item"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="proofImage" class="form-label">Upload Proof Image</label>
                        <input type="file" class="form-control" id="proofImage">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-sm btn-primary" onclick="submitClaim()">Claim Item</button>
            </div>
        </div>
    </div>
</div>
	</div>
	<!--**********************************
    Scripts
***********************************-->
	<script src="assets/js/jquery.js"></script>
	<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="assets/vendor/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js"></script>
	<script src="assets/vendor/nouislider/nouislider.min.js"></script>
	<script src="assets/vendor/wnumb/wNumb.js"></script>
	<script src="assets/js/noui-slider.init.js"></script>
	<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
	<script src="assets/js/dz.carousel.js"></script>
	<script src="assets/js/settings.js"></script>
	<script src="assets/js/custom.js"></script>
	<!-- <script>
    function submitClaim() {
        // Example function to handle the form submission
        const form = document.getElementById('claim-form');
        const formData = new FormData(form);

        fetch('submit_claim.php', {
            method: 'POST',
            body: formData
        }).then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert('Claim submitted successfully');
                // Close the modal
                const claimModal = new bootstrap.Modal(document.getElementById('claimModal'));
                claimModal.hide();
            } else {
                alert('Error submitting claim: ' + data.message);
            }
        });
    }
</script> -->
</body>

</html>