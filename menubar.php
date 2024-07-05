 <!-- Menubar -->
 <div class="menubar-area footer-fixed">
 	<div class="toolbar-inner menubar-nav">
 		<a href="index.php" class="nav-link">
 			<i class="fi fi-rr-home"></i>
 		</a>
 		<a href="view-my-lists.php" class="nav-link">
 			<i class="fa-regular fa-clipboard-list"></i>
 		</a>
 		<a href="view-user-profile.php" class="nav-link">
 			<i class="fi fi-rr-user"></i>
 		</a>
 		<a href="add-item-details.php" class="nav-link">
 			<i class="fa-regular fa-file-circle-plus"></i>
 		</a>
 	</div>
 </div>
 <!-- Menubar -->

 <script>
 	document.addEventListener('DOMContentLoaded', function() {
 		const currentUrl = window.location.pathname.split('/').pop();
 		const navLinks = document.querySelectorAll('.nav-link');

 		navLinks.forEach(link => {
 			const linkUrl = link.getAttribute('href').split('/').pop();
 			if (linkUrl === currentUrl) {
 				link.classList.add('active');
 			}
 		});
 	});
 </script>