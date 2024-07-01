document
  .getElementById("addclsuidimage")
  .addEventListener("change", function (event) {
    const file = event.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function (e) {
        const preview = document.getElementById("preview");
        preview.src = e.target.result;
        preview.style.display = "block";
      };
      reader.readAsDataURL(file);
    }
  });

// Replace with your remove.bg API key
const apiKey = "TfFJG68t6VWNWwqf2NosJWbC";

document
  .getElementById("addclsuidimage")
  .addEventListener("change", async function (event) {
    const file = event.target.files[0];
    const formData = new FormData();
    formData.append("image_file", file);

    try {
      const response = await fetch("https://api.remove.bg/v1.0/removebg", {
        method: "POST",
        headers: {
          "X-Api-Key": apiKey,
        },
        body: formData,
      });

      if (!response.ok) {
        throw new Error("Failed to remove background");
      }

      const result = await response.blob();
      const imageUrl = URL.createObjectURL(result);

      // Display the preview with the background removed
      const previewImage = document.getElementById("preview");
      previewImage.src = imageUrl;
      previewImage.style.display = "block";

      // Upload the background-removed image directly to the server
      uploadImage(result);
    } catch (error) {
      console.error("Error removing background:", error);
    }
  });

async function uploadImage(imageBlob) {
  const formData = new FormData();
  formData.append("file", imageBlob, "removed-bg.png");

  try {
    const response = await fetch("submit-user-details.php", {
      method: "POST",
      body: formData,
    });

    if (!response.ok) {
      throw new Error("Failed to upload image");
    }

    const result = await response.json();
    console.log("Image uploaded successfully:", result);
  } catch (error) {
    console.error("Error uploading image:", error);
  }
}
