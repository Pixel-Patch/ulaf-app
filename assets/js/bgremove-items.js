document
  .getElementById("addImages")
  .addEventListener("change", async function (event) {
    const files = event.target.files;
    const previewsContainer = document.getElementById("previews");
    previewsContainer.innerHTML = ""; // Clear existing previews

    // Replace with your remove.bg API key
    const apiKey = "uwb2Q2vyL85aXAHuHs1PA9qE";

    for (let i = 0; i < files.length; i++) {
      const file = files[i];
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
        const previewImage = document.createElement("img");
        previewImage.src = imageUrl;
        previewImage.style.maxWidth = "100%";
        previewImage.style.display = "block";
        previewImage.style.marginBottom = "10px";
        previewsContainer.appendChild(previewImage);

        // Upload the background-removed image directly to the server
        await uploadImage(result);
      } catch (error) {
        console.error("Error removing background:", error);
      }
    }
  });

async function uploadImage(imageBlob) {
  const formData = new FormData();
  formData.append("file", imageBlob, "removed-bg.png");

  try {
    const response = await fetch("submit-item-details.php", {
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
