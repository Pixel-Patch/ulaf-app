<?php
$title = "ULAF - Add Item Details | PixelPatch";
require("header.php");





?>

<!-- Include the Select2 CSS file -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCzWcAbNuR8iS50rrGnYD-aLfuULyuaQ9s&libraries=places" async></script>

<!-- Custom CSS for Select2 -->
<style>
	#map-add {
		height: 300px;
		width: 100%;
	}

	.select2-container .select2-results__option--highlighted[aria-selected] {
		background-color: #8FCCA7 !important;
	}

	.select2-container--default .select2-results__option {
		height: 40px;
		line-height: 30px;
	}

	.select2-container--default .select2-selection--single {
		height: 40px;
		line-height: 40px;
	}

	.select2-container--default .select2-selection--single .select2-selection__rendered {
		line-height: 40px;
	}

	.preview-container {
		display: flex;
		flex-wrap: wrap;
		gap: 10px;
	}

	.preview-container img {
		max-width: 200px;
		max-height: 200px;
		object-fit: cover;
		border: 2px solid #ddd;
		border-radius: 5px;
		padding: 5px;
		background: #fff;
	}
</style>

</head>

<body class="bg-light">
    <div class="page-wrapper">
        <div id="preloader">
            <div class="loader">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>

        <header class="header header-fixed border-bottom">
            <div class="header-content">
                <div class="mid-content">
                    <h4 class="title">Post Item Details</h4>
                </div>
                <div class="right-content"></div>
            </div>
        </header>

        <main class="page-content space-top p-b100">
            <div class="container">
                <form id="addItemForm" enctype="multipart/form-data">
                    <h6 class="dz-title my-2">Post Type</h6>
                    <div class="d-flex flex-wrap gap-2">
                        <div class="form-check style-2">
                            <input class="form-check-input" type="radio" name="addType" id="filterRadio1" value="lost" checked="">
                            <label class="form-check-label" for="filterRadio1">Lost</label>
                        </div>
                        <div class="form-check style-2">
                            <input class="form-check-input" type="radio" name="addType" id="filterRadio2" value="found">
                            <label class="form-check-label" for="filterRadio2">Found</label>
                        </div>
                    </div>
                    <h6 class="dz-title my-2">Item Details</h6>
                    <div class="mb-3">
                        <label class="form-label" for="addItemName">Item Name</label>
                        <input type="text" id="addItemName" class="form-control" name="addItemName" aria-label=" ">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="addCategory">Category</label>
                        <select id="addCategory" class="form-control" name="addCategory">
                            <?php
                            $sql = "SELECT `Category_ID`, `Category_Name` FROM `categories`";
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value=\"" . $row["Category_ID"] . "\">" . $row["Category_Name"] . "</option>";
                                }
                            } else {
                                echo "<option value=\"\">No categories found</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div id="current-location-wrapper" class="mb-3">
                        <label class="form-label" for="item-current-location">Current Location</label>
                        <select class="form-control" id="item-current-location" name="itemCurrentLocation" aria-label="Current Location">
                            <option value="" disabled selected>Select Current Location</option>
                            <option value="reporter">In my Possession</option>
                            <option value="USF Office">USF Office</option>
                            <option value="OAd Office">OAd Office</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label id="pin-location-label" class="form-label" for="pin-location-add">Pin Location</label>
                        <input type="text" id="addpinlocation" name="addpinlocation" class="form-control" placeholder="Search for a location" style="z-index: 9999 !important;">
                        <div id="map-add" style="height: 400px;"></div>
                        <input id="pin-latitude-add" type="hidden" name="latitude">
                        <input id="pin-longitude-add" type="hidden" name="longitude">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="addImages">Images</label>
                        <input type="file" id="addImages" class="form-control" name="addImages[]" aria-label=" " multiple>
                    </div>
                    <div id="previewContainer" class="preview-container"></div>
                    <div class="mb-3">
                        <label class="form-label" for="addDescription">Description</label>
                        <textarea id="addDescription" class="form-control" name="addDescription" aria-label=" "></textarea>
                    </div>
                    <div class="footer-fixed-btn bottom-0 bg-white">
                        <a href="javascript:void(0);" type="submit" class="btn btn-lg btn-thin btn-primary w-100 rounded-xl" onclick="submitItemDetails()" id="submitButton">Submit</a>
                    </div>
                </form>
            </div>
        </main>

        <div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="alertModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div id="alertModalContent" class="modal-content" style="padding: 20px; font-size: large;">
                    <div id="alertModalBody"></div>
                </div>
            </div>
        </div>

        <script src="assets/js/jquery.js"></script>
        <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
        <script src="assets/vendor/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js"></script>
        <script src="assets/js/dz.carousel.js"></script>
        <script src="assets/js/settings.js"></script>
        <script src="assets/js/custom.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="assets/js/select2.js"></script>
        <script src="assets/js/pin-maps.js"></script>
      
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const filterRadios = document.querySelectorAll('input[name="addType"]');
                const currentLocationWrapper = document.getElementById('current-location-wrapper');
                const pinLocationLabel = document.getElementById('pin-location-label');

                filterRadios.forEach(radio => {
                    radio.addEventListener('change', function() {
                        if (this.value === 'lost') {
                            currentLocationWrapper.style.display = 'none';
                            pinLocationLabel.textContent = 'Pin Lost Location';
                        } else if (this.value === 'found') {
                            currentLocationWrapper.style.display = 'block';
                            pinLocationLabel.textContent = 'Pin Found Location';
                        }
                    });
                });

                document.querySelector('input[name="addType"]:checked').dispatchEvent(new Event('change'));
            });

            function submitItemDetails() {
                const addType = $('input[name="addType"]:checked').val();
                const addItemName = $('#addItemName').val();
                const addCategory = $('#addCategory').val();
                const itemCurrentLocation = $('#item-current-location').val();
                const latitude = $('#pin-latitude-add').val();
                const longitude = $('#pin-longitude-add').val();
                const addDescription = $('#addDescription').val();
                const addPinLocation = $('#addpinlocation').val();
                const addImages = document.getElementById('addImages').files;

                const alertModalContent = document.getElementById('alertModalContent');
                const alertModalBody = document.getElementById('alertModalBody');

                if (!addType || !addItemName || !addCategory || !latitude || !longitude || !addDescription || !addPinLocation) {
                    showErrorModal('All fields are required');
                    return;
                }

                if (addType === 'found' && !itemCurrentLocation) {
                    showErrorModal('All fields are required');
                    return;
                }

                const formData = new FormData(document.getElementById('addItemForm'));
                formData.append('addType', addType);
                formData.append('latitude', latitude);
                formData.append('longitude', longitude);
                formData.append('addPinLocation', addPinLocation);
 
                document.getElementById('preloader').style.display = 'block';
                $.ajax({
                    url: 'submit-item-details.php',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        document.getElementById('preloader').style.display = 'none';
                        try {
                            let data = JSON.parse(response);
                            alertModalContent.className = data.alertClass;
                            alertModalBody.innerHTML = `<strong>${data.alertTitle}</strong> ${data.message}`;
                            new bootstrap.Modal(document.getElementById('alertModal')).show();
                            if (data.status === 'success') {
                                setTimeout(() => {
                                    window.location.href = 'index.php';
                                }, 2000);
                            }
                        } catch (error) {
                            console.error('Invalid JSON response:', error);
                            showErrorModal('An error occurred while processing the response. Please try again.');
                        }
                    },
                    error: function(xhr, status, error) {
                        document.getElementById('preloader').style.display = 'none';
                        console.error('Error:', error);
                        showErrorModal('An error occurred while submitting your details. Please try again.');
                    }
                });
            }

            function showErrorModal(message, noRedirect = false) {
                const alertModalContent = document.getElementById('alertModalContent');
                const alertModalBody = document.getElementById('alertModalBody');
                alertModalContent.className = 'modal-content alert alert-danger alert-dismissible alert-alt fade show';
                alertModalBody.innerHTML = `<strong>Error!</strong> ${message}`;
                new bootstrap.Modal(document.getElementById('alertModal')).show();
                if (!noRedirect) {
                    document.getElementById('preloader').style.display = 'none';
                }
            }

            document.getElementById('submitButton').disabled = true;
        </script>
    </div>
</body>

</html>