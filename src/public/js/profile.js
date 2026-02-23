document.addEventListener('DOMContentLoaded', function () {
  const imageInput = document.getElementById('image-input');
  if (imageInput) {
    imageInput.addEventListener('change', function (e) {
      const file = e.target.files[0];
      const previewImage = document.getElementById('preview-image');

      if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
          previewImage.src = e.target.result;
          previewImage.style.display = 'block';
        }
        reader.readAsDataURL(file);
      }
    });
  }
});
