<?php

	include('config/db_connect.php');

	$email = $title = $ingredients = '';
	$errors = array('email' => '', 'title' => '', 'ingredients' => '');

	if(isset($_POST['submit'])){
		
		// check email
		if(empty($_POST['email'])){
			$errors['email'] = 'Email wajib diisi';
		} else{
			$email = $_POST['email'];
			if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				$errors['email'] = 'Email harus valid';
			}
		}

		// check title
		if(empty($_POST['title'])){
			$errors['title'] = 'Nama mahasiswa wajib diisi';
		} else{
			$title = $_POST['title'];
			if(!preg_match('/^[a-zA-Z\s]+$/', $title)){
				$errors['title'] = 'Nama mahasiswa harus menggunakan letter dan spasi';
			}
		}

		// check ingredients
		if(empty($_POST['ingredients'])){
			$errors['ingredients'] = 'Minimal mengisi 1 mata kuliah';
		} else{
			$ingredients = $_POST['ingredients'];
			if(!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $ingredients)){
				$errors['ingredients'] = 'Mata kuliah harus dipisahkan memakai comma';
			}
		}

		if(array_filter($errors)){
			//echo 'errors in form';
		} else {
			// escape sql chars
			$email = mysqli_real_escape_string($conn, $_POST['email']);
			$title = mysqli_real_escape_string($conn, $_POST['title']);
			$ingredients = mysqli_real_escape_string($conn, $_POST['ingredients']);

			// create sql
			$sql = "INSERT INTO pizzas(title,email,ingredients) VALUES('$title','$email','$ingredients')";

			// save to db and check
			if(mysqli_query($conn, $sql)){
				// success
				header('Location: index.php');
			} else {
				echo 'query error: '. mysqli_error($conn);
			}
			
		}

	} // end POST check

?>

<!DOCTYPE html>
<html>
	
	<?php include('templates/header.php'); ?>

	<section class="container grey-text">
		<h4 class="center">Pendaftaran</h4>
		<form class="white" action="add.php" method="POST">
			<label>Alamat Email</label>
			<div class="red-text"><?php echo $errors['email']; ?></div>
			<input type="text" name="email" value="<?php echo htmlspecialchars($email) ?>">
			<label>Nama Mahasiswa</label>
			<div class="red-text"><?php echo $errors['title']; ?></div>
			<input type="text" name="title" value="<?php echo htmlspecialchars($title) ?>">
			<label>Mata Kuliah yang diambil (dipisahkan memakai tanda koma ' , ' )</label>
			<div class="red-text"><?php echo $errors['ingredients']; ?></div>
			<input type="text" name="ingredients" value="<?php echo htmlspecialchars($ingredients) ?>">
			<div class="center">
				<input type="submit" name="submit" value="Tambahkan" class="btn brand z-depth-0">
			</div>
		</form>
	</section>

	<?php include('templates/footer.php'); ?>

</html>