<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Upload or Capture Image</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
	<div class="container mt-5">
		<div class="mb-3">
			<label for="addclsuidimage" class="form-label">CLSU ID Image</label>
			<input class="form-control" type="file" id="addclsuidimage" name="addclsuidimage" accept="image/*" capture="camera" />
		</div>
		<div class="mb-3">
			<img id="preview" src="" alt="Image Preview" style="max-width: 100%; display: none;" />
		</div>
	</div>
	<script>
		document.getElementById('addclsuidimage').addEventListener('change', function(event) {
			const file = event.target.files[0];
			if (file) {
				const reader = new FileReader();
				reader.onload = function(e) {
					const preview = document.getElementById('preview');
					preview.src = e.target.result;
					preview.style.display = 'block';
				}
				reader.readAsDataURL(file);
			}
		});
	</script>
</body>

</html>