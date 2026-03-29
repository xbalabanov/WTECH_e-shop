(function () {
  var coverInput = document.getElementById("cover-image-input");
  var galleryInput = document.getElementById("gallery-images-input");
  var authorsList = document.getElementById("authors-list");
  var authorAddButton = document.getElementById("author-add-btn");
  var coverFileName = document.getElementById("cover-file-name");
  var coverPreview = document.getElementById("cover-preview");
  var coverPreviewImage = document.getElementById("cover-preview-image");
  var galleryFileCount = document.getElementById("gallery-file-count");
  var galleryPreview = document.getElementById("gallery-preview");
  var saveBookButton = document.getElementById("save-book-btn");
  var coverObjectUrl = null;

  if (
    !coverInput ||
    !galleryInput ||
    !authorsList ||
    !authorAddButton ||
    !coverFileName ||
    !coverPreview ||
    !coverPreviewImage ||
    !galleryFileCount ||
    !galleryPreview ||
    !saveBookButton
  ) {
    return;
  }

  function resetGallery() {
    var existingItems = galleryPreview.querySelectorAll(".gallery-item");
    existingItems.forEach(function (item) {
      var image = item.querySelector("img");
      if (image && image.dataset.objectUrl) {
        URL.revokeObjectURL(image.dataset.objectUrl);
      }
      item.remove();
    });
  }

  function refreshAuthorButtons() {
    var rows = authorsList.querySelectorAll(".author-row");
    rows.forEach(function (row, index) {
      var removeBtn = row.querySelector(".author-remove-btn");
      removeBtn.hidden = rows.length === 1;
      removeBtn.disabled = rows.length === 1;
      removeBtn.setAttribute("aria-label", "Remove author " + (index + 1));
    });
  }

  authorAddButton.addEventListener("click", function () {
    var row = document.createElement("div");
    row.className = "author-row";

    var input = document.createElement("input");
    input.type = "text";
    input.name = "authors[]";
    input.placeholder = "Enter author name";

    var removeBtn = document.createElement("button");
    removeBtn.type = "button";
    removeBtn.className = "author-remove-btn";
    removeBtn.textContent = "Remove";

    row.appendChild(input);
    row.appendChild(removeBtn);
    authorsList.appendChild(row);
    refreshAuthorButtons();
    input.focus();
  });

  authorsList.addEventListener("click", function (event) {
    var target = event.target;
    if (!target.classList.contains("author-remove-btn")) return;

    var row = target.closest(".author-row");
    if (!row) return;
    row.remove();
    refreshAuthorButtons();
  });

  coverInput.addEventListener("change", function (event) {
    var file = event.target.files && event.target.files[0];
    if (!file) {
      coverFileName.textContent = "No cover selected";
      coverPreview.hidden = true;
      if (coverObjectUrl) {
        URL.revokeObjectURL(coverObjectUrl);
        coverObjectUrl = null;
      }
      coverPreviewImage.removeAttribute("src");
      return;
    }

    coverFileName.textContent = file.name;
    if (coverObjectUrl) {
      URL.revokeObjectURL(coverObjectUrl);
    }
    coverObjectUrl = URL.createObjectURL(file);
    coverPreviewImage.src = coverObjectUrl;
    coverPreview.hidden = false;
  });

  galleryInput.addEventListener("change", function (event) {
    var files = Array.from(event.target.files || []);
    resetGallery();
    galleryFileCount.textContent =
      files.length + " image" + (files.length === 1 ? "" : "s") + " selected";

    if (files.length === 0) return;

    files.forEach(function (file) {
      var item = document.createElement("div");
      item.className = "gallery-item";

      var image = document.createElement("img");
      var objectUrl = URL.createObjectURL(file);
      image.src = objectUrl;
      image.alt = file.name;
      image.dataset.objectUrl = objectUrl;

      item.appendChild(image);
      galleryPreview.appendChild(item);
    });
  });

  saveBookButton.addEventListener("click", function () {
    window.location.href = "admin.html";
  });

  refreshAuthorButtons();
})();
