<?php
include("../model/db.php"); 

$con = connection(); 

$id = "";
$name = "";
$email = "";
$password = "";
$usertype = "";

$errormsg = "";
$successmsg = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!isset($_GET["id"])) {
        // If ID is not set in GET request, display an error message
        $errormsg = "User ID is missing";
    } else {
        $id = $_GET["id"];

        // Retrieve user data from database
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
    
            $row = $result->fetch_assoc();
            $name = $row["name"];
            $email = $row["email"];
            $password = $row["password"];
            $usertype = $row["usertype"];
        } else {
            
            $errormsg = "User not found";
        }
        $stmt->close();
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $usertype = $_POST["usertype"];

    if (empty($name) || empty($email) || empty($password) || empty($usertype)) {
        $errormsg = "All the fields are required";
    } else {
        // Update users data in the database
        $sql = "UPDATE users SET name = ?, email = ?, password = ?, usertype = ? WHERE id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ssssi", $name, $email, $password, $usertype, $id);
        if ($stmt->execute()) {
            $successmsg = "Updated successfully";
            $stmt->close();
            header("Location: userList.php"); 
            exit;
        } else {
            $errormsg = "Failed to update";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<title>Edit Seller | INV MNG SYS</title>

	<link rel="icon" href="/assets/logo.ico" />
	<link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	<link
		href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
		rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
		integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
		crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <?php
        if(!empty($errormsg)) {
            echo "
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <strong>$errormsg</strong>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
            ";
        }

        if(!empty($successmsg)) {
            echo "
            <div class='alert alert-success alert-dismissible fade show' role='alert'>
            <strong>$successmsg</strong>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
            ";
        }
    ?>

	<div id="wrapper">

		<?php include 'components/sidebar.php'?>

		<div id="content-wrapper" class="d-flex flex-column">
			<div id="content">

				<?php include 'components/header.php';?>

				<div class="container-fluid">
					<div class="card shadow mb-4">
						<div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
							<h6 class="m-0 font-weight-bold text-primary">Edit Seller</h6>
							<a href="userList.php" class="btn btn-sm btn-primary shadow-sm d-flex justify-content-center align-items-center">Back &nbsp;<i class="fas fa-circle-left fa-sm text-white-50"></i></a>
						</div>
						<div class="card-body">
                            <form action="" method="post">

                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                                <div class="mb-3">
                                    <label for="name" class="form-label" style="color: #000;">Name</label>
                                    <input type="text" class="form-control" name="name" placeholder="Name" value="<?php echo $name; ?>">
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label" style="color: #000;">Email</label>
                                    <input type="email" class="form-control" placeholder="Email" name="email" value="<?php echo $email; ?>">
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label" style="color: #000;">Password</label>
                                    <input type="password" class="form-control" placeholder="Password" name="password" value="<?php echo $password; ?>">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="usertype">Usertype</label>
                                    <select id="usertype" name="usertype" class="form-control form-select">
                                        <option value="" <?= $usertype == '' ? 'selected' : '' ?>>Select</option>
                                        <option value="user" <?= $usertype == 'user' ? 'selected' : '' ?>>User</option>
                                        <option value="admin" <?= $usertype == 'admin' ? 'selected' : '' ?>>Admin</option>
                                    </select>
                                </div>
                            
                                <div class="d-flex justify-content-center pt-1">
                                    <button type="submit" class="btn btn-sm btn-warning shadow-sm">Update &nbsp;<i class="fas fa-refresh fa-sm text-white-50"></i></button>
                                </div>
                            
                            </form>
						</div>
					</div>
				</div>
			</div>

			<?php include 'components/footer.php' ?>

		</div>
	</div>

	<!-- Scroll to Top Button-->
	<a class="scroll-to-top rounded" href="#page-top">
		<i class="fas fa-angle-up"></i>
	</a>

	<!-- JavaScript -->
	<?php include 'components/scripts.php' ?>

</body>

</html>