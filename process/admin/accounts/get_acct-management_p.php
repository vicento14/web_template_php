<?php
if (isset($_GET['search_account'])) {
	$employee_no = $_GET['employee_no_search'];
	$full_name = $_GET['full_name_search'];
	$user_type = $_GET['user_type_search'];

	$c = 0;

	$data = "";

	// Connection Object
    $conn = null;

    // Connection Open
    $connectionArr = $db->connect();

	if ($connectionArr['connected'] == 1) {
        $conn = $connectionArr['connection'];

		$query = "SELECT * FROM user_accounts 
					WHERE id_number LIKE '$employee_no%' AND full_name LIKE '$full_name%' 
					AND role LIKE '$user_type%'";
		$stmt = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
			foreach ($stmt->fetchALL() as $row) {
				$c++;
				$data .= '<tr>';
				$data .= '<td><p class="mb-0"><label class="mb-0">';
				$data .= '<input type="checkbox" class="singleCheck" value="' . $row['id'] . '" onclick="get_checked_length()" />';
				$data .= '<span></span></label></p></td>';
				$data .= '<td style="cursor:pointer;" class="modal-trigger" data-toggle="modal" data-target="#update_account" ';
				$data .= 'onclick="get_accounts_details(&quot;' . $row['id'] . '~!~' . $row['id_number'] . '~!~' . 
						$row['username'] . '~!~' . $row['full_name'] . '~!~' . 
						$row['section'] . '~!~' . $row['role'] . '&quot;)">' . $c . '</td>';
				$data .= '<td>' . $row['id_number'] . '</td>';
				$data .= '<td>' . $row['username'] . '</td>';
				$data .= '<td>' . $row['full_name'] . '</td>';
				$data .= '<td>' . $row['section'] . '</td>';
				$data .= '<td>' . strtoupper($row['role']) . '</td>';
				$data .= '</tr>';
			}
		} else {
			$data .= '<tr>';
			$data .= '<td colspan="7" style="text-align:center; color:red;">No Result !!!</td>';
			$data .= '</tr>';
		}
	} else {
        echo $connectionArr['title'] . " " . $connectionArr['message'];
    }

	// Connection Close
    $conn = null;
} else {
	$c = 0;

	$data = "";

	// Connection Object
    $conn = null;

    // Connection Open
    $connectionArr = $db->connect();

	if ($connectionArr['connected'] == 1) {
        $conn = $connectionArr['connection'];

		$query = "SELECT * FROM user_accounts";
		$stmt = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
			foreach ($stmt->fetchALL() as $row) {
				$c++;
				$data .= '<tr>';
				$data .= '<td><p class="mb-0"><label class="mb-0">';
				$data .= '<input type="checkbox" class="singleCheck" value="' . $row['id'] . '" onclick="get_checked_length()" />';
				$data .= '<span></span></label></p></td>';
				$data .= '<td style="cursor:pointer;" class="modal-trigger" data-toggle="modal" data-target="#update_account" ';
				$data .= 'onclick="get_accounts_details(&quot;' . $row['id'] . '~!~' . $row['id_number'] . '~!~' . 
						$row['username'] . '~!~' . $row['full_name'] . '~!~' .  
						$row['section'] . '~!~' . $row['role'] . '&quot;)">' . $c . '</td>';
				$data .= '<td>' . $row['id_number'] . '</td>';
				$data .= '<td>' . $row['username'] . '</td>';
				$data .= '<td>' . $row['full_name'] . '</td>';
				$data .= '<td>' . $row['section'] . '</td>';
				$data .= '<td>' . strtoupper($row['role']) . '</td>';
				$data .= '</tr>';
			}
		} else {
			$data .= '<tr>';
			$data .= '<td colspan="7" style="text-align:center; color:red;">No Result !!!</td>';
			$data .= '</tr>';
		}
	} else {
        echo $connectionArr['title'] . " " . $connectionArr['message'];
    }

	// Connection Close
    $conn = null;
}
