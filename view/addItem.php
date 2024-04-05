<?php

  $name = "";
  $description = "";
  $quantity = 0;

  $errormsg = "";
  $successmsg = "";

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $name = $_POST["name"];
      $description = $_POST["description"];
      $quantity = $_POST["quantity"];

      // File upload handling
      $targetDir = "../assets/upload/";
      $fileName = basename($_FILES["img_file"]["name"]);
      $targetFilePath =  $targetDir . $fileName ;
      $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
      $allowedTypes = array('jpg', 'png', 'jpeg', 'gif');

      if (empty($name) || empty($description) || empty($quantity)) {
          $errormsg = "All the fields are required";
      } elseif (!in_array($fileType, $allowedTypes)) {
          $errormsg = "Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.";
      } else {
          // Database connection and insertion
          include("../model/db.php");
          $con = connection();

          if (move_uploaded_file($_FILES["img_file"]["tmp_name"], $targetFilePath)) {


              $sql = "INSERT INTO items (name, description, img_path, quantity) VALUES ('$name', '$description', '$targetFilePath', '$quantity')";
              if ($con->query($sql)) {
                  $successmsg = "Item added successfully.";

                  // Reset form values
                  $name = "";
                  $description = "";
                  $quantity = 0;
                  header("Location: itemList.php"); 
              } else {
                  $errormsg = "Error inserting into database: " . $con->error;
              }
          } else {
              $errormsg = "Sorry, there was an error uploading your file.";
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

	<title>Add Item | INV MNG SYS</title>

	<link rel="icon" href="/assets/logo.ico" />
	<link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	<link
		href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
		rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
		integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
		crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">

  <style>
    .upload-style {
      display: flex;
      justify-content: center;
      align-items: center;
      text-align: center;
      background-color: #f8f8f8;
      cursor: pointer;
      padding-bottom: 100px;
      padding-left: 90px;
      padding-right: 40px;
      padding-top: 24px;
      width: 100%;
    }

    .upload-style:before {
      content: "";
      font-size: 1.1em;
      font-weight: 500;
      color: black;
      margin-bottom: 20px;
      margin-left: -56px;
    }

    input[type="file"] {
      color: #4E73DF;
    }

    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
      -webkit-appearance: none; 
      margin: 0; 
    }
  </style>

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
							<h6 class="m-0 font-weight-bold text-primary">Add Item</h6>
							<a href="itemList.php" class="btn btn-sm btn-primary shadow-sm d-flex justify-content-center align-items-center">Back &nbsp;<i
										class="fas fa-circle-left fa-sm text-white-50"></i>  
									</a>
						</div>
						<div class="card-body">
            <form action="" method="post" enctype="multipart/form-data">
              
              <div class="mb-3">
                <label for="name" class="form-label" style="color: #000;">Name</label>
                <input type="text" class="form-control" name="name" placeholder="Name" value="<?php echo $name; ?>">
              </div>

              <div class="mb-3">
                <label for="description" class="form-label" style="color: #000;">Description</label>
                <input type="text" class="form-control" placeholder="Description" name="description" value="<?php echo $description; ?>">
              </div>

              <div class="mb-3">
                <label for="img_path" class="form-label" style="color: #000;">Image</label>
                <input class="form-control upload-style" type="file" name="img_file" id="formFile">
              </div>

              <div class="mb-3">
                <label class="form-label" for="quantity" style="color: #000;">Quantity</label>
                <input type="number" class="form-control" placeholder="Quantity" name="quantity" value="<?php echo $quantity; ?>">
              </div>
            
              <div class="d-flex justify-content-center pt-1">
                <button type="submit" class="btn btn-sm btn-success shadow-sm">Save &nbsp;<i class="fas fa-save fa-sm text-white-50"></i>
                </button>
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