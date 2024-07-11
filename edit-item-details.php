<?php
require('dbconn.php'); // Include your database connection file
$title = "ULAF - Item Details | PixelPatch";
require("header.php");
require("fetch-data.php");
require('fetch-userid.php'); // Ensure this file is correctly setting the session data

$itemId = $_GET['item_id'] ?? null;
$itemData = $_SESSION['item_data'] ?? [];

// Sample query, should be in fetch-data.php
// SELECT `Item_ID`, `Item_Name`, `Image`, `Type`, `Category_ID`, `Description`, `Pin_Location`, `Posted_Date`, `Current_Location`, `Poster_ID`, `Item_Status`, `Latitude`, `Longitude`, `Retrieved_By`, `Retrieved_Date` FROM `items` WHERE `Item_ID` = ?
// Assuming the fetched data is stored in $_SESSION['item_data']
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

    .container {
        margin-bottom: -10%;
    }

    .bg-white {
        margin-top: -21px;
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
                    <h4 class="title">Edit Item Details</h4>
                </div>
                <div class="right-content"></div>
            </div>
        </header>

        <main class="page-content space-top p-b100">
            <div class="container">
                <form id="editItemForm" enctype="multipart/form-data">
                    <h6 class="dz-title my-2">Post Type</h6>
                    <div class="d-flex flex-wrap gap-2">
                        <div class="form-check style-2">
                            <input class="form-check-input" type="radio" name="editType" id="filterRadio1" value="lost" <?php echo ($itemData['Type'] == 'lost') ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="filterRadio1">Lost</label>
                        </div>
                        <div class="form-check style-2">
                            <input class="form-check-input" type="radio" name="editType" id="filterRadio2" value="found" <?php echo ($itemData['Type'] == 'found') ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="filterRadio2">Found</label>
                        </div>
                    </div>
                    <h6 class="dz-title my-2">Item Details</h6>
                    <div class="mb-3">
                        <label class="form-label" for="editItemName">Item Name</label>
                        <input type="text" id="editItemName" class="form-control" name="editItemName" value="<?php echo $itemData['Item_Name']; ?>" aria-label=" ">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="editCategory">Category</label>
                        <select id="editCategory" class="form-control" name="editCategory">
                            <?php
                            $sql = "SELECT `Category_ID`, `Category_Name` FROM `categories`";
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $selected = ($row["Category_ID"] == $itemData['Category_ID']) ? 'selected' : '';
                                    echo "<option value=\"" . $row["Category_ID"] . "\" $selected>" . $row["Category_Name"] . "</option>";
                                }
                            } else {
                                echo "<option value=\"\">No categories found</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div id="current-location-wrapper" class="mb-3" style="display: <?php echo ($itemData['Type'] == 'found') ? 'block' : 'none'; ?>">
                        <label class="form-label" for="item-current-location">Current Location</label>
                        <select class="form-control" id="item-current-location" name="itemCurrentLocation" aria-label="Current Location">
                            <option value="">Select Current Location</option>
                            <option value="reporter" <?php echo ($itemData['Current_Location'] == 'reporter') ? 'selected' : ''; ?>>In my Possession</option>
                            <option value="USF Office" <?php echo ($itemData['Current_Location'] == 'USF Office') ? 'selected' : ''; ?>>USF Office</option>
                            <option value="OAd Office" <?php echo ($itemData['Current_Location'] == 'OAd Office') ? 'selected' : ''; ?>>OAd Office</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label id="pin-location-label" class="form-label" for="pin-location-add">Pin Location</label>
                        <input type="text" id="addpinlocation" name="addpinlocation" class="form-control" placeholder="Search for a location" style="z-index: 9999 !important;" value="<?php echo $itemData['Pin_Location']; ?>">
                        <div id="map-add" style="height: 400px;"></div>
                        <input id="pin-latitude-add" type="hidden" name="latitude" value="<?php echo $itemData['Latitude']; ?>">
                        <input id="pin-longitude-add" type="hidden" name="longitude" value="<?php echo $itemData['Longitude']; ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="editImages">Images</label>
                        <input type="file" id="editImages" class="form-control" name="editImages[]" aria-label=" " multiple>
                    </div>
                    <div id="previewContainer" class="preview-container">
                        <?php
                        $images = explode(',', $itemData['Image']);
                        foreach ($images as $image) {
                            echo '<img src="assets/uploads/items/' . $image . '" alt="Item Image">';
                        }
                        ?>
                    </div>
                    <br>
                    <div class="mb-3">
                        <label class="form-label" for="editDescription">Description</label>
                        <textarea id="editDescription" class="form-control" name="editDescription" aria-label=" "><?php echo $itemData['Description']; ?></textarea>
                    </div>
                    <br>
                    <div class="bottom-0 bg-white">
                        <a href="javascript:void(0);" type="submit" class="btn btn-lg btn-thin btn-primary w-100 rounded-xl" onclick="editItemDetails()" id="submitButton">Submit</a>
                    </div>
                </form>
            </div>
            <div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="alertModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div id="alertModalContent" class="modal-content" style="padding: 20px; font-size: large;">
                        <div id="alertModalBody"></div>
                    </div>
                </div>
            </div>
        </main>


        <!-- Menubar -->
        <?php include('menubar.php'); ?>
        <!-- Menubar -->

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
                const filterRadios = document.querySelectorAll('input[name="editType"]');
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

                document.querySelector('input[name="editType"]:checked').dispatchEvent(new Event('change'));
            });

            function editItemDetails() {
                const editType = $('input[name="editType"]:checked').val();
                const editItemName = $('#editItemName').val();
                const editCategory = $('#editCategory').val();
                const itemCurrentLocation = $('#item-current-location').val();
                const latitude = $('#pin-latitude-add').val();
                const longitude = $('#pin-longitude-add').val();
                const editDescription = $('#editDescription').val();
                const editPinLocation = $('#addpinlocation').val();
                const editImages = document.getElementById('editImages').files;

                const alertModalContent = document.getElementById('alertModalContent');
                const alertModalBody = document.getElementById('alertModalBody');


                const formData = new FormData(document.getElementById('editItemForm'));
                formData.append('editType', editType);
                formData.append('latitude', latitude);
                formData.append('longitude', longitude);
                formData.append('editPinLocation', editPinLocation);
                formData.append('item_id', '<?php echo $itemData["Item_ID"]; ?>');

                document.getElementById('preloader').style.display = 'block';
                $.ajax({
                    url: 'update-item-details.php',
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
                                    window.location.href = `view-item-details.php?item_id=${data.item_id}`;
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
        <script>
            // get the textarea element for the editpinlocation field
            const pinTextarea = document.getElementById('editDescription');

            // set the height of the textarea to the height of its scrollHeight
            pinTextarea.style.height = 'auto';
            pinTextarea.style.height = pinTextarea.scrollHeight + 'px';

            // listen for changes to the textarea value and update the height accordingly
            pinTextarea.addEventListener('input', () => {
                pinTextarea.style.height = 'auto';
                pinTextarea.style.height = pinTextarea.scrollHeight + 'px';
            });

            // get the input field element for the addpinlocation field
            const pinInput = document.getElementById('addpinlocation');

            // set the height of the input field to the height of its scrollHeight
            pinInput.style.height = 'auto';
            pinInput.style.height = pinInput.scrollHeight + 'px';

            // listen for changes to the input field value and update the height accordingly
            pinInput.addEventListener('input', () => {
                pinInput.style.height = 'auto';
                pinInput.style.height = pinInput.scrollHeight + 'px';
            });
        </script>
    </div>
</body>

</html>