<?php
function count_account_list($search_arr, $conn) {
	$query = "SELECT count(id) AS total FROM user_accounts WHERE id_number LIKE '" . $search_arr['employee_no'] . "%' AND full_name LIKE '" . $search_arr['full_name'] . "%' AND role LIKE '" . $search_arr['user_type'] . "%'";
	$stmt = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
		foreach ($stmt->fetchALL() as $row) {
			$total = $row['total'];
		}
	} else {
		$total = 0;
	}
	return $total;
}

if (isset($_GET['search_account'])) {
	if (!isset($_GET['employee_no_search'])) {
		$employee_no = '';
	} else {
		$employee_no = $_GET['employee_no_search'];
	}

	if (!isset($_GET['full_name_search'])) {
		$full_name = '';
	} else {
		$full_name = $_GET['full_name_search'];
	}

	if (!isset($_GET['user_type_search'])) {
		$user_type = '';
	} else {
		$user_type = $_GET['user_type_search'];
	}

	if (!isset($_GET['page'])) {
		$current_page = 1;
	} else {
		$current_page = intval($_GET['page']);
	}
	
	if (!isset($_GET['order_by'])) {
		$order_by_code = 0;
	} else {
		$order_by_code = intval($_GET['order_by']);
	}

	$c = 0;

	$data = '';
	$count = 0;
	$pages = '';

	$search_arr = array(
		"employee_no" => $employee_no,
		"full_name" => $full_name,
		"user_type" => $user_type
	);

	$number_of_result = intval(count_account_list($search_arr, $conn));

	$results_per_page = 10;

	//determine the sql LIMIT starting number for the results on the displaying page
	$page_first_result = ($current_page - 1) * $results_per_page;

	$query = "SELECT * FROM user_accounts WHERE id_number LIKE '$employee_no%' AND full_name LIKE '$full_name%' AND role LIKE '$user_type%'";

	// Table Header Sort Behavior
	switch ($order_by_code) {
		case 0:
			$query = $query . " ORDER BY id ASC";
			$c = $page_first_result;
			break;
		case 1:
			$query = $query . " ORDER BY id DESC";
			$c = ($number_of_result - $page_first_result) + 1;
			break;
		case 2:
			$query = $query . " ORDER BY id_number ASC";
			$c = $page_first_result;
			break;
		case 3:
			$query = $query . " ORDER BY id_number DESC";
			$c = ($number_of_result - $page_first_result) + 1;
			break;
		case 4:
			$query = $query . " ORDER BY username ASC";
			$c = $page_first_result;
			break;
		case 5:
			$query = $query . " ORDER BY username DESC";
			$c = ($number_of_result - $page_first_result) + 1;
			break;
		case 6:
			$query = $query . " ORDER BY full_name ASC";
			$c = $page_first_result;
			break;
		case 7:
			$query = $query . " ORDER BY full_name DESC";
			$c = ($number_of_result - $page_first_result) + 1;
			break;
		case 8:
			$query = $query . " ORDER BY section ASC";
			$c = $page_first_result;
			break;
		case 9:
			$query = $query . " ORDER BY section DESC";
			$c = ($number_of_result - $page_first_result) + 1;
			break;
		case 10:
			$query = $query . " ORDER BY role ASC";
			$c = $page_first_result;
			break;
		case 11:
			$query = $query . " ORDER BY role DESC";
			$c = ($number_of_result - $page_first_result) + 1;
			break;
		default:
	}

	// MySQL
	$query = $query . " LIMIT " . $page_first_result . ", " . $results_per_page;
	// MS SQL Server
	// $query = $query . " OFFSET ".$page_first_result." ROWS FETCH NEXT ".$results_per_page." ROWS ONLY";
	$stmt = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();

	if ($stmt->rowCount() > 0) {
		foreach ($stmt->fetchALL() as $j) {
			// Table Header Sort Behavior
			switch ($order_by_code) {
				case 0:
				case 2:
				case 4:
				case 6:
				case 8:
				case 10:
					$c++;
					break;
				case 1:
				case 3:
				case 5:
				case 7:
				case 9:
				case 11:
					$c--;
					break;
				default:
			}
			$data .= '<tr>';
			$data .= '<td>' . $c . '</td>';
			$data .= '<td>' . $j['id_number'] . '</td>';
			$data .= '<td>' . $j['username'] . '</td>';
			$data .= '<td>' . $j['full_name'] . '</td>';
			$data .= '<td>' . $j['section'] . '</td>';
			$data .= '<td>' . strtoupper($j['role']) . '</td>';
			$data .= '</tr>';
		}
	} else {
		$data .= '<tr>';
		$data .= '<td colspan="6" style="text-align:center; color:red;">No Result !!!</td>';
		$data .= '</tr>';
	}

	$search_arr = array(
		"employee_no" => $employee_no,
		"full_name" => $full_name,
		"user_type" => $user_type
	);

	$count = count_account_list($search_arr, $conn);

	$results_per_page = 10;

	$number_of_result = intval($count);

	//determine the total number of pages available  
	$number_of_page = ceil($number_of_result / $results_per_page);

	if ($count > 0) {
		$url_components = parse_url($_SERVER['REQUEST_URI']);
		$next_query_params = [];

		if (isset($url_components['query'])) {
			parse_str($url_components['query'], $next_query_params);
		}

		$page_range = 2;
		$start_page = max(1, $current_page - $page_range);
		$end_page = min($number_of_page, $current_page + $page_range);

		for ($page = $start_page; $page <= $end_page; $page++) {
			$next_query_params['search_account'] = 1;
			$next_query_params['page'] = $page;
			$next_query_string = http_build_query($next_query_params);
			$next_url = $url_components['path'] . '?' . $next_query_string;

			if ($page == $current_page) {
				$pages .= '<a href="'.htmlspecialchars($next_url).'" type="button" class="btn bg-primary mr-2">' . $page . '</a>';
			} else {
				$pages .= '<a href="'.htmlspecialchars($next_url).'" type="button" class="btn bg-gray-dark mr-2">' . $page . '</a>';
			}
		}
	} else {
		$pages .= '<a href="" type="button" class="btn bg-gray-dark mr-2" disabled>...</a>';
	}

} else {
	$employee_no = '';
	$full_name = '';
	$user_type = '';

	$current_page = 1;
	$c = 0;

	$data = '';
	$count = 0;
	$pages = '';

	$results_per_page = 10;

	//determine the sql LIMIT starting number for the results on the displaying page
	$page_first_result = ($current_page - 1) * $results_per_page;

	$c = $page_first_result;
	
	$query = "SELECT * FROM user_accounts";
	// MySQL
	$query = $query . " LIMIT " . $page_first_result . ", " . $results_per_page;
	// MS SQL Server
	// $query = $query . " ORDER BY id ASC";
	// $query = $query . " OFFSET ".$page_first_result." ROWS FETCH NEXT ".$results_per_page." ROWS ONLY";
	$stmt = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
		foreach ($stmt->fetchALL() as $row) {
			$c++;
			$data .= '<tr>';
			$data .= '<td>' . $c . '</td>';
			$data .= '<td>' . $row['id_number'] . '</td>';
			$data .= '<td>' . $row['username'] . '</td>';
			$data .= '<td>' . $row['full_name'] . '</td>';
			$data .= '<td>' . $row['section'] . '</td>';
			$data .= '<td>' . strtoupper($row['role']) . '</td>';
			$data .= '</tr>';
		}
	} else {
		$data .= '<tr>';
		$data .= '<td colspan="6" style="text-align:center; color:red;">No Result !!!</td>';
		$data .= '</tr>';
	}

	$search_arr = array(
		"employee_no" => $employee_no,
		"full_name" => $full_name,
		"user_type" => $user_type
	);

	$count = count_account_list($search_arr, $conn);

	$results_per_page = 10;

	$number_of_result = intval($count);

	//determine the total number of pages available  
	$number_of_page = ceil($number_of_result / $results_per_page);

	if ($count > 0) {
		$url_components = parse_url($_SERVER['REQUEST_URI']);
		$next_query_params = [];

		if (isset($url_components['query'])) {
			parse_str($url_components['query'], $next_query_params);
		}

		$page_range = 2;
		$start_page = max(1, $current_page - $page_range);
		$end_page = min($number_of_page, $current_page + $page_range);

		for ($page = $start_page; $page <= $end_page; $page++) {
			$next_query_params['search_account'] = 1;
			$next_query_params['page'] = $page;
			$next_query_string = http_build_query($next_query_params);
			$next_url = $url_components['path'] . '?' . $next_query_string;

			if ($page == $current_page) {
				$pages .= '<a href="'.htmlspecialchars($next_url).'" type="button" class="btn bg-primary mr-2">' . $page . '</a>';
			} else {
				$pages .= '<a href="'.htmlspecialchars($next_url).'" type="button" class="btn bg-gray-dark mr-2">' . $page . '</a>';
			}
		}
	} else {
		$pages .= '<a href="" type="button" class="btn bg-gray-dark mr-2" disabled>...</a>';
	}
}
