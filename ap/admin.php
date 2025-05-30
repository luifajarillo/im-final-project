<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>AdminHub</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Boxicons -->
	<link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css">
	<!-- My CSS -->
	<link rel="stylesheet" href="/JLougawan/css/admin.css">
</head>
<body>


	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="#" class="brand">
			<i class='bx bxs-smile'></i>
			<span class="text">AdminHub</span>
		</a>
		<ul class="side-menu top">
			<li class="active">
				<a href="#" data-section="dashboard-section">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li>
				<a href="#" data-section="store-section">
					<i class='bx bxs-shopping-bag-alt' ></i>
					<span class="text">My Store</span>
				</a>
			</li>
			<li>
				<a href="#" data-section="users-section">
					<i class='bx bxs-group' ></i>
					<span class="text">Manage Users</span>
				</a>
			</li>
			
		</ul>
		<ul class="side-menu">
			<li>
				<a href="#">
					<i class='bx bxs-cog' ></i>
					<span class="text">Settings</span>
				</a>
			</li>
			<li>
				<a href="#" class="logout">
					<i class='bx bxs-log-out-circle' ></i>
					<span class="text">Logout</span>
				</a>
			</li>
		</ul>
	</section>
	<!-- SIDEBAR -->



	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
		<nav>
			<i class='bx bx-menu' ></i>
			<a href="#" class="nav-link">Categories</a>
			<form action="#">
				<div class="form-input">
					<input type="search" placeholder="Search...">
					<button type="submit" class="search-btn"><i class='bx bx-search' ></i></button>
				</div>
			</form>
			<input type="checkbox" id="switch-mode" hidden>
			<label for="switch-mode" class="switch-mode"></label>
			<a href="#" class="notification">
				<i class='bx bxs-bell' ></i>
				<span class="num">8</span>
			</a>
			<a href="#" class="profile">
				<img src="img/people.png">
			</a>
		</nav>
		<!-- NAVBAR -->

		<!-- MAIN -->
	    <?php include("dashboard.php"); ?>
	    <?php include("store.php"); ?>
	    <?php include("users.php"); ?>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->

	<!-- delete modal funcs -->
	<script>
	function openDeleteModal(id, table) {
		document.getElementById('deleteId').value = id;
		document.getElementById('deleteTable').value = table;
		document.getElementById('deleteModal').classList.add('show');
	}

	function closeDeleteModal() {
		document.getElementById('deleteModal').classList.remove('show');
	}
	</script>

	<script>
	function openDeleteModal2(id) {
		document.getElementById('deleteId2').value = id;
		document.getElementById('deleteModal2').classList.add('show');
	}

	function closeDeleteModal2() {
		document.getElementById('deleteModal2').classList.remove('show');
	}
	</script>

	<script src="/JLougawan/js/admin.js"></script>

</body>
</html>