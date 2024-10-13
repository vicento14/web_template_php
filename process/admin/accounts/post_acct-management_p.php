<?php
if (isset($_POST['btn_add_account'])) {
	$employee_no = trim($_POST['employee_no']);
	$full_name = trim($_POST['full_name']);
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);
	$section = trim($_POST['section']);
	$user_type = trim($_POST['user_type']);

	// Connection Object
    $conn = null;

    // Connection Open
    $connectionArr = $db->connect();

	if ($connectionArr['connected'] == 1) {
        $conn = $connectionArr['connection'];
		
		$check = "SELECT id FROM user_accounts WHERE username = ?";
		$stmt = $conn->prepare($check, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
		$params = array($username);
		$stmt->execute($params);
		if ($stmt->rowCount() > 0) {
			$_SESSION['message'] = 'Already Exist';
		} else {
			$stmt = NULL;
			$query = "INSERT INTO user_accounts (id_number, full_name, username, password, section, role)
						VALUES (?, ?, ?, ?, ?, ?)";
			$stmt = $conn->prepare($query);
			$params = array($employee_no, $full_name, $username, $password, $section, $user_type);
			if ($stmt->execute($params)) {
				$_SESSION['message'] = 'Succesfully Recorded!!!';
			} else {
				$_SESSION['message'] = 'Error !!!';
			}
		}
	} else {
        $_SESSION['message'] = $connectionArr['title'] . " " . $connectionArr['message'];
    }

	// Connection Close
    $conn = null;

	header('location:' . $_SERVER['REQUEST_URI']);
}

if (isset($_POST['btn_update_account'])) {
	$id = $_POST['id_account_update'];
	$id_number = trim($_POST['employee_no_update']);
	$username = trim($_POST['username_update']);
	$full_name = trim($_POST['full_name_update']);
	$password = trim($_POST['password_update']);
	$section = trim($_POST['section_update']);
	$role = trim($_POST['user_type_update']);

	// Connection Object
    $conn = null;

    // Connection Open
    $connectionArr = $db->connect();

	if ($connectionArr['connected'] == 1) {
        $conn = $connectionArr['connection'];
		
		$query = "SELECT id FROM user_accounts 
				WHERE username = '$username' AND id_number = '$id_number' 
				AND full_name = '$full_name' AND section = '$section'";
		$stmt = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
			$_SESSION['message'] = 'Duplicate Data !!!';
		} else {
			$stmt = NULL;

			$query = "UPDATE user_accounts SET id_number = '$id_number', username = '$username', 
						full_name = '$full_name', section = '$section', role = '$role'";
			if (!empty($password)) {
				$query .= ", password = '$password'";
			}
			$query .= " WHERE id = '$id'";

			$stmt = $conn->prepare($query);
			if ($stmt->execute()) {
				$_SESSION['message'] = 'Succesfully Updated!!!';
			} else {
				$_SESSION['message'] = 'Error !!!';
			}
		}
	} else {
        $_SESSION['message'] = $connectionArr['title'] . " " . $connectionArr['message'];
    }

	// Connection Close
    $conn = null;

	header('location:' . $_SERVER['REQUEST_URI']);
}

if (isset($_POST['btn_delete_account'])) {
	$id = $_POST['id_account_update'];

	// Connection Object
    $conn = null;

    // Connection Open
    $connectionArr = $db->connect();

	if ($connectionArr['connected'] == 1) {
        $conn = $connectionArr['connection'];

		$query = "DELETE FROM user_accounts WHERE id = '$id'";
		$stmt = $conn->prepare($query);
		if ($stmt->execute()) {
			$_SESSION['message'] = 'Succesfully Deleted!!!';
		} else {
			$_SESSION['message'] = 'Error !!!';
		}
	} else {
        $_SESSION['message'] = $connectionArr['title'] . " " . $connectionArr['message'];
    }

	// Connection Close
    $conn = null;

	header('location:' . $_SERVER['REQUEST_URI']);
}

if (isset($_POST['btn_delete_account_selected'])) {
	$id_arr = [];
	$id_arr = json_decode(stripslashes(html_entity_decode($_POST['id_account_delete_arr'])), true);

	if (json_last_error() === JSON_ERROR_NONE) {

		// Connection Object
		$conn = null;

		// Connection Open
		$connectionArr = $db->connect();

		if ($connectionArr['connected'] == 1) {
			$conn = $connectionArr['connection'];
			
			$isTransactionActive = false;
			$chunkSize = 100; // Define the size of each chunk

			try {
				if (!$isTransactionActive) {
					$conn->beginTransaction();
					$isTransactionActive = true;
				}

				// Process the IDs in chunks
				foreach (array_chunk($id_arr, $chunkSize) as $chunk) {
					// Create a placeholder string for the IDs
					$placeholders = implode(',', array_fill(0, count($chunk), '?'));

					// Prepare the DELETE statement
					$stmt = $conn->prepare("DELETE FROM user_accounts WHERE id IN ($placeholders)");

					// Execute the statement with the chunk of IDs
					$stmt->execute($chunk);

					// echo "Deleted " . count($chunk) . " records.\n";
				}

				$conn->commit();
				$isTransactionActive = false;
				$_SESSION['message'] = 'Succesfully Deleted!!!';
			} catch (Exception $e) {
				if ($isTransactionActive) {
					$conn->rollBack();
					$isTransactionActive = false;
				}
				$_SESSION['message'] = 'Failed. Please Try Again or Call IT Personnel Immediately!: ' . $e->getMessage();
				// Connection Close
				$conn = null;
				exit();
			}
		} else {
			$_SESSION['message'] = $connectionArr['title'] . " " . $connectionArr['message'];
		}

		// Connection Close
		$conn = null;

	} else {
		$_SESSION['message'] = 'Error !!! JSON Decode Error: ' . json_last_error();
	}

	header('location:' . $_SERVER['REQUEST_URI']);
}
