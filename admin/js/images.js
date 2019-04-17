window.onload = function() {

		var fileInput = document.getElementById('fileInput');
		var fileDisplayArea = document.getElementById('psp');


		fileInput.addEventListener('change', function(e) {
			var file = fileInput.files[0];
			var imageType = /image.*/;

			if (file.type.match(imageType)) {
				var reader = new FileReader();

				reader.onload = function(e) {
					fileDisplayArea.src = reader.result;
				}

				reader.readAsDataURL(file);
			} else {
				fileDisplayArea.innerHTML = "File not supported!";
			}
		});

}
