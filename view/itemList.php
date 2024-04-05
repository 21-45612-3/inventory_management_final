<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>Item List | INV MNG SYS</title>

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
	<div id="wrapper">

		<?php include 'components/sidebar.php'?>

		<div id="content-wrapper" class="d-flex flex-column">
			<div id="content">

				<?php include 'components/header.php';?>

				<div class="container-fluid">
					<div class="card shadow mb-4">
						<div class="card-header py-3 d-sm-flex align-items-center justify-content-between align-items-center">
							<h6 class="m-0 font-weight-bold text-primary">Item List</h6>
							<a href="addItem.php" class=" btn btn-sm btn-primary shadow-sm d-flex justify-content-center align-items-center">Add &nbsp;<i
										class="fas fa-add fa-sm text-white-50"></i>  
									</a>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-bordered" width="100%" cellspacing="0">
									<thead class="bg-primary text-white text-center">
										<tr>
											<th>SL</th>
											<th>Name</th>
											<th>Description</th>
											<th>Image</th>
											<th>Quantity</th>
											<th>Action</th>
										</tr>
									</thead>
									<tfoot class="text-center" style="color: #000;">
										<?php
											include("../model/db.php");
											$con = connection();
                      //check connection
                      if($con->connect_error) {
                          die("Connection failed: ".$con->connect_error);
                      }

                      //read all from DB table
                      $sql = "SELECT * FROM items";
                      $result = $con->query($sql);

                      if(!$result) {
                          die("Invalid query: " . $con->error);
                      }
											$serialNumber = 1;
                      while($row = $result->fetch_assoc()) {
                        echo "
                          <tr>
                              <td>{$serialNumber}</td>
                              <td class=\"text-left\">{$row['name']}</td>
                              <td class=\"text-left\">{$row['description']}</td>
                              <td><img src={$row['img_path']} style=\"object-fit: cover; border-radius: 8px;\" width=\"180\" height=\"120\"/></td>
                              <td>{$row['quantity']}</td>
                              <td>
                                  <a class=\"btn btn-success btn-sm\" href=\"../view/editItem.php?id={$row['id']}\">Edit</a>
                                  <a class=\"btn btn-danger btn-sm\" href=\"../view/deleteItem.php?id={$row['id']}\">Delete</a>
                              </td>
                          </tr>
                        ";
												$serialNumber++;
                      }
                    ?>
									</tfoot>
								</table>
							</div>
						</div>
					</div>

				</div>
				<!-- /.container-fluid -->

			</div>
			<!-- End of Main Content -->

			<?php include 'components/footer.php' ?>

		</div>
		<!-- End of Content Wrapper -->

	</div>
	<!-- End of Page Wrapper -->

	<!-- Scroll to Top Button-->
	<a class="scroll-to-top rounded" href="#page-top">
		<i class="fas fa-angle-up"></i>
	</a>

	<!-- Logout Modal-->
	<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
					<button class="close" type="button" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
				<div class="modal-footer">
					<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
					<a class="btn btn-primary" href="logout.php">Logout</a>
				</div>
			</div>
		</div>
	</div>


	<!-- JavaScript -->
	<?php include 'components/scripts.php' ?>

</body>

</html>