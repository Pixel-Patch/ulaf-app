<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Progress Bar</title>
	<link rel="stylesheet" href="styles.css">
	<style>
		body {
			font-family: Arial, sans-serif;
			display: flex;
			justify-content: center;
			align-items: center;
			height: 100vh;
			margin: 0;
		}

		.progress-container {
			text-align: center;
		}

		.progress {
			width: 300px;
			height: 8px;
			background-color: #e0e0e0;
			border-radius: 4px;
			position: relative;
			margin-bottom: 20px;
		}

		.progress-bar {
			width: 50%;
			/* Adjust this value to represent the progress */
			height: 100%;
			background-color: #007b55;
			border-radius: 4px;
			position: relative;
		}

		.progress-circle {
			width: 16px;
			height: 16px;
			background-color: #007b55;
			border-radius: 50%;
			position: absolute;
			top: 50%;
			right: 0;
			transform: translate(50%, -50%);
			border: 4px solid #e0e0e0;
		}

		.labels {
			display: flex;
			justify-content: space-between;
			width: 300px;
		}

		.labels span {
			font-size: 14px;
			color: #666;
		}
	</style>
</head>

<body>
	<div class="progress-container">
		<div class="progress">
			<div class="progress-bar">
				<div class="progress-circle"></div>
			</div>
		</div>
		<div class="labels">
			<span>Claiming</span>
			<span>Claimed</span>
			<span>Retrieving</span>
			<span>Retrieved</span>
		</div>
	</div>
</body>

</html>