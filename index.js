// Register Service worker to control making site work offline
if ("serviceWorker" in navigator) {
  navigator.serviceWorker.register("app.js").then(() => {
    console.log("Service Worker Registered");
  });
}

// Variables for managing the PWA prompt and registration status
let deferredPrompt;
const pwaBtn = document.querySelector(".pwa-btn");
const PwaKey = "pwa-modal";
let PwaValue = getCookie(PwaKey);

// Event listener for the beforeinstallprompt event
window.addEventListener("beforeinstallprompt", (e) => {
  e.preventDefault();
  deferredPrompt = e;

  if (!PwaValue) {
    setTimeout(checkRegistrationStatus, 3000);
  }

  pwaBtn.addEventListener("click", () => {
    deferredPrompt.prompt();
    deferredPrompt.userChoice.then((choiceResult) => {
      if (choiceResult.outcome === "accepted") {
        setCookie(PwaKey, false);
      }
      deferredPrompt = null;
    });
  });
});

// Function to check registration status
function checkRegistrationStatus() {
  $.ajax({
    url: "check-registration-status.php",
    type: "GET",
    success: function (response) {
      try {
        const data = JSON.parse(response);
        if (data.isRegistered) {
          console.log("User is registered.");
          localStorage.setItem("isRegistered", "true");
        } else {
          console.log("User is not registered.");
          localStorage.removeItem("isRegistered");
          jQuery(".dz-pwa-modal").modal("show");
        }
      } catch (error) {
        console.error("Error parsing response:", error);
      }
    },
    error: function (error) {
      console.error("Error with AJAX call:", error);
    },
  });
}

// Complete registration and hide the modal
function completeRegistration() {
  localStorage.setItem("isRegistered", "true");
  jQuery(".dz-pwa-modal").modal("hide");
}

// Logout button click event
jQuery(document).ready(function () {
  // Logout button click event
  jQuery("#logoutButton").on("click", function (e) {
    // Prevent the default behavior of the link
    e.preventDefault();

    // Clear isRegistered from localStorage
    localStorage.removeItem("isRegistered");

    // Redirect to the logout.php to handle server-side logout
    window.location.href = "logout.php";
  });

  // PWA button click event
  jQuery(".pwa-btn").on("click", function () {
    jQuery(".dz-pwa-modal").modal("hide");
    setCookie(PwaKey, true);
  });

  // Check registration status on page load
  if (!localStorage.getItem("isRegistered")) {
    setTimeout(checkRegistrationStatus, 3000);
  }
});

// Helper functions for setting and getting cookies
function setCookie(name, value) {
  document.cookie = name + "=" + value + ";path=/";
}

function getCookie(name) {
  const value = `; ${document.cookie}`;
  const parts = value.split(`; ${name}=`);
  if (parts.length === 2) return parts.pop().split(";").shift();
}
