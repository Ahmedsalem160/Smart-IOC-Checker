const scrollToTopBtn = document.getElementById("chevron-up");

// Show/hide button on scroll
window.onscroll = function () {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    scrollToTopBtn.style.display = "flex";
  } else {
    scrollToTopBtn.style.display = "none";
  }
};

// Scroll to top when button is clicked
scrollToTopBtn.onclick = function () {
  window.scrollTo({ top: 0, behavior: "smooth" });
};

// Filter
document
  .querySelectorAll(".dropdown-menu .form-check")
  .forEach(function (element) {
    element.addEventListener("click", function (e) {
      e.stopPropagation();
    });
  });

// Handel when use select-all in filter
document.addEventListener("DOMContentLoaded", () => {
  const selectAllCheckbox = document.getElementById("select-all");
  const checkboxes = document.querySelectorAll(
    ".dropdown-menu .form-check-input:not(#select-all)"
  );

  selectAllCheckbox.addEventListener("change", () => {
    checkboxes.forEach((checkbox) => {
      checkbox.checked = selectAllCheckbox.checked;
    });
  });

  // Optional: If any checkbox is unchecked, uncheck the 'select all' checkbox
  checkboxes.forEach((checkbox) => {
    checkbox.addEventListener("change", () => {
      if (!checkbox.checked) {
        selectAllCheckbox.checked = false;
      } else {
        // Optional: Check if all checkboxes are checked to check 'select all'
        const allChecked = Array.from(checkboxes).every((cb) => cb.checked);
        selectAllCheckbox.checked = allChecked;
      }
    });
  });
});

// Alert
function showToast(message, type = "success") {
  const toastContainer = document.getElementById("toast-container");

  const toast = document.createElement("div");
  toast.className = `toast toast-${type}`;
  toast.style = `
      display: flex;
      align-items: center;
      justify-content: space-between;
      background-color: ${type === "success" ? "#d4edda" : "#f8d7da"};
      color:  ${type === "success" ? "#155724" : "#721c24"};;
      padding: 10px 20px;
      margin-bottom: 10px;
      border-radius: 5px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      opacity: 0;
      transition: opacity 0.3s ease-in-out;
      border:1px solid;
       border-color: ${type === "success" ? "#c3e6cb" : "#f5c6cb"};
    `;

  toast.innerText = message;

  const closeButton = document.createElement("span");
  closeButton.innerText = "✖";
  closeButton.style = "cursor: pointer; margin-left: 15px;";
  closeButton.onclick = () => {
    toast.style.opacity = "0";
    setTimeout(() => toastContainer.removeChild(toast), 300);
  };

  toast.appendChild(closeButton);
  toastContainer.appendChild(toast);

  setTimeout(() => {
    toast.style.opacity = "1";
  }, 100);

  setTimeout(() => {
    toast.style.opacity = "0";
    setTimeout(() => toastContainer.removeChild(toast), 300);
  }, 3000); // Toast duration
}

document.getElementById("search").addEventListener("click", () => {
  // for success
  showToast("This is a success message!", "success");
  // for error
  showToast("This is an error message!", "error");
});

// Search input effect
document.getElementById("searchInput").addEventListener("focus", function () {
  document.querySelector(".selectBox").classList.add("shadow-effect");
});

document.getElementById("searchInput").addEventListener("blur", function () {
  document.querySelector(".selectBox").classList.remove("shadow-effect");
});

// show file name
document.getElementById("upload-file").addEventListener("change", function () {
  var fileName = this.files[0]?.name || "No file selected";
  document.getElementById("file-name").textContent = fileName;
});

// register
document
  .getElementById("register-btn")
  .addEventListener("click", function (event) {
    var password = document.getElementById("register-password").value;
    var confirmPassword = document.getElementById("confirmpassword").value;
    var errorMessage = document.getElementById("error-message");

    if (password !== confirmPassword) {
      event.preventDefault();
      errorMessage.textContent = "Passwords do not match.";
    } else {
      errorMessage.textContent = ""; //
    }
  });
