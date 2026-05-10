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

  var galleryFiles = [];

  function fileKey(file) {
    return file.name + "|" + file.size + "|" + file.lastModified;
  }

  function syncGalleryInput() {
    var dt = new DataTransfer();
    galleryFiles.forEach(function (f) {
      dt.items.add(f);
    });
    galleryInput.files = dt.files;
  }

  function renderGallery() {
    var existingItems = galleryPreview.querySelectorAll(".gallery-item");
    existingItems.forEach(function (item) {
      var image = item.querySelector("img");
      if (image && image.dataset.objectUrl) {
        URL.revokeObjectURL(image.dataset.objectUrl);
      }
      item.remove();
    });

    galleryFileCount.textContent =
      galleryFiles.length +
      " image" +
      (galleryFiles.length === 1 ? "" : "s") +
      " selected";

    galleryFiles.forEach(function (file, index) {
      var item = document.createElement("div");
      item.className = "gallery-item gallery-item--preview";

      var image = document.createElement("img");
      var objectUrl = URL.createObjectURL(file);
      image.src = objectUrl;
      image.alt = file.name;
      image.dataset.objectUrl = objectUrl;

      var removeBtn = document.createElement("button");
      removeBtn.type = "button";
      removeBtn.className = "gallery-item-delete";
      removeBtn.setAttribute("aria-label", "Remove " + file.name);
      removeBtn.textContent = "×";
      removeBtn.dataset.index = String(index);

      item.appendChild(image);
      item.appendChild(removeBtn);
      galleryPreview.appendChild(item);
    });
  }

  function addGalleryFiles(incoming) {
    var existing = {};
    galleryFiles.forEach(function (f) {
      existing[fileKey(f)] = true;
    });

    incoming.forEach(function (file) {
      if (!file.type || file.type.indexOf("image/") !== 0) return;
      var key = fileKey(file);
      if (existing[key]) return;
      existing[key] = true;
      galleryFiles.push(file);
    });

    syncGalleryInput();
    renderGallery();
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
    var picked = Array.from(event.target.files || []);
    if (picked.length === 0) return;
    addGalleryFiles(picked);
  });

  galleryPreview.addEventListener("click", function (event) {
    var target = event.target;
    if (!target.classList || !target.classList.contains("gallery-item-delete")) {
      return;
    }
    var index = parseInt(target.dataset.index, 10);
    if (isNaN(index) || index < 0 || index >= galleryFiles.length) return;
    galleryFiles.splice(index, 1);
    syncGalleryInput();
    renderGallery();
  });

  var galleryDropZone = galleryInput.closest(".gallery-upload") ||
    galleryPreview.parentElement;

  if (galleryDropZone) {
    ["dragenter", "dragover"].forEach(function (evt) {
      galleryDropZone.addEventListener(evt, function (event) {
        if (!event.dataTransfer) return;
        var hasFiles = Array.from(event.dataTransfer.types || []).indexOf("Files") !== -1;
        if (!hasFiles) return;
        event.preventDefault();
        galleryDropZone.classList.add("is-dragover");
      });
    });

    ["dragleave", "dragend"].forEach(function (evt) {
      galleryDropZone.addEventListener(evt, function (event) {
        if (event.target !== galleryDropZone) return;
        galleryDropZone.classList.remove("is-dragover");
      });
    });

    galleryDropZone.addEventListener("drop", function (event) {
      if (!event.dataTransfer) return;
      var dropped = Array.from(event.dataTransfer.files || []);
      if (dropped.length === 0) return;
      event.preventDefault();
      galleryDropZone.classList.remove("is-dragover");
      addGalleryFiles(dropped);
    });
  }

  refreshAuthorButtons();
})();
