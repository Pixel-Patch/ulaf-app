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

    document.getElementById('addImages').addEventListener('change', handleFileSelect, false);

    let removedBgImages = [];
    let processingImages = 0;

    function handleFileSelect(event) {
        const files = event.target.files;
        const previewsContainer = document.getElementById('previews');
        previewsContainer.innerHTML = '';
        removedBgImages = [];
        processingImages = files.length;

        Array.from(files).forEach(file => {
            const reader = new FileReader();
            reader.onload = (function(file) {
                return function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('img-thumbnail', 'm-2');
                    img.style.maxWidth = '150px';
                    previewsContainer.appendChild(img);

                    removeBackground(file, img);
                };
            })(file);
            reader.readAsDataURL(file);
        });
    }

    function removeBackground(file, imgElement) {
        const formData = new FormData();
        formData.append('image_file', file);
        formData.append('size', 'auto');

        fetch("https://api.remove.bg/v1.0/removebg", {
                method: 'POST',
                headers: {
                    'X-Api-Key': 'TfFJG68t6VWNWwqf2NosJWbC'
                },
                body: formData
            })
            .then(response => response.blob())
            .then(blob => {
                const url = URL.createObjectURL(blob);
                imgElement.src = url;

                const fileExtension = file.name.split('.').pop();
                const newFileName = $ {
                    Date.now()
                }.$ {
                    fileExtension
                };
                blob.name = newFileName;
                removedBgImages.push(blob);
            })
            .catch(error => {
                console.error('Error:', error);
                showErrorModal('An error occurred while removing background from an image. Please try again.');
            })
            .finally(() => {
                processingImages -= 1;
                if (processingImages === 0) {
                    document.getElementById('submitButton').disabled = false;
                }
            });
    }

    function submitItemDetails() {
        if (processingImages > 0) {
            showErrorModal('Please wait until all images are processed.');
            return;
        }

        const addType = $('input[name="addType"]:checked').val();
        const addItemName = $('#addItemName').val();
        const addCategory = $('#addCategory').val();
        const itemCurrentLocation = $('#item-current-location').val();
        const latitude = $('#pin-latitude-add').val();
        const longitude = $('#pin-longitude-add').val();
        const addDescription = $('#addDescription').val();
        const addPinLocation = $('#addpinlocation').val();

        if (!addType || !addItemName || !addCategory || !latitude || !longitude || !addDescription || removedBgImages.length === 0 || !addPinLocation) {
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

        removedBgImages.forEach((blob, index) => {
            formData.append('addImages[]', blob, blob.name);
        });

        const alertModalContent = document.getElementById('alertModalContent');
        const alertModalBody = document.getElementById('alertModalBody');

        document.getElementById('preloader').style.display = 'block';

        $.ajax({
            url: 'submit-item-details.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                document.getElementById('preloader').style.display = 'none';
                let data = JSON.parse(response);
                alertModalContent.className = data.alertClass;
                alertModalBody.innerHTML = < strong > $ {
                    data.alertTitle
                } < /strong> ${data.message};
                new bootstrap.Modal(document.getElementById('alertModal')).show();
                if (data.status === 'success') {
                    setTimeout(() => {
                        window.location.href = 'index.php';
                    }, 2000);
                }
            },
            error: function(xhr, status, error) {
                document.getElementById('preloader').style.display = 'none';
                console.error('Error:', error);
                showErrorModal('An error occurred while submitting your details. Please try again.');
            }
        });
    }

    function showErrorModal(message) {
        const alertModalBody = document.getElementById('alertModalBody');
        alertModalBody.innerHTML = message;
        new bootstrap.Modal(document.getElementById('alertModal')).show();
    }

    document.getElementById('submitButton').disabled = true;
</script>



<?php
$title = "ULAF - Add Item Details | PixelPatch";
require("header.php");
require("dbconn.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $itemName = $_POST['addItemName'];
    $type = $_POST['addType'];
    $categoryID = $_POST['addCategory'];
    $description = $_POST['addDescription'];
    $pinLocation = $_POST['addPinLocation'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $currentLocation = isset($_POST['itemCurrentLocation']) ? $_POST['itemCurrentLocation'] : null;
    $posterID = $_SESSION['user_id'];
    $postedDate = date('Y-m-d H:i:s');
    $itemStatus = 'Posted';

    $targetDir = "assets/uploads/items/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $imageNames = [];
    foreach ($_FILES['addImages']['tmp_name'] as $key => $tmpName) {
        $fileExtension = pathinfo($_FILES['addImages']['name'][$key], PATHINFO_EXTENSION);
        $fileName = date('YmdHis') . '.' . $fileExtension;
        $targetFilePath = $targetDir . $fileName;
        if (move_uploaded_file($tmpName, $targetFilePath)) {
            $imageNames[] = $fileName;
        } else {
            echo json_encode([
                'status' => 'danger',
                'alertClass' => 'alert-danger',
                'alertTitle' => 'Error!',
                'message' => 'Failed to upload image: ' . $fileName
            ]);
            exit;
        }
    }

    $imageNamesString = implode(',', $imageNames);

    $stmt = $conn->prepare("INSERT INTO items (Item_Name, Image, Type, Category_ID, Description, Pin_Location, Posted_Date, Current_Location, Poster_ID, Item_Status, Latitude, Longitude) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssssss", $itemName, $imageNamesString, $type, $categoryID, $description, $pinLocation, $postedDate, $currentLocation, $posterID, $itemStatus, $latitude, $longitude);

    if ($stmt->execute()) {
        echo json_encode([
            'status' => 'success',
            'alertClass' => 'alert-success',
            'alertTitle' => 'Success!',
            'message' => 'Item details submitted successfully.'
        ]);
    } else {
        echo json_encode([
            'status' => 'danger',
            'alertClass' => 'alert-danger',
            'alertTitle' => 'Error!',
            'message' => 'Failed to submit item details.'
        ]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode([
        'status' => 'danger',
        'alertClass' => 'alert-danger',
        'alertTitle' => 'Error!',
        'message' => 'Invalid request method.'
    ]);
}
?>