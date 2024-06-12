const get_accounts_details = (param) => {
    var string = param.split('~!~');
    var id = string[0];
    var id_number = string[1];
    var username = string[2];
    var full_name = string[3];
    var password = string[4];
    var section = string[5];
    var role = string[6];

    document.getElementById('id_account_update').value = id;
    document.getElementById('employee_no_update').value = id_number;
    document.getElementById('username_update').value = username;
    document.getElementById('full_name_update').value = full_name;
    document.getElementById('password_update').value = password;
    document.getElementById('section_update').value = section;
    document.getElementById('user_type_update').value = role;
}

// uncheck all
const uncheck_all = () => {
    var select_all = document.getElementById('check_all');
    select_all.checked = false;
    document.querySelectorAll(".singleCheck").forEach((el, i) => {
        el.checked = false;
    });
    get_checked_length();
}
// check all
const select_all_func = () => {
    var select_all = document.getElementById('check_all');
    if (select_all.checked == true) {
        console.log('check');
        document.querySelectorAll(".singleCheck").forEach((el, i) => {
            el.checked = true;
        });
    } else {
        console.log('uncheck');
        document.querySelectorAll(".singleCheck").forEach((el, i) => {
            el.checked = false;
        });
    }
    get_checked_length();
}
// GET THE LENGTH OF CHECKED CHECKBOXES
const get_checked_length = () => {
    var arr = [];
    document.querySelectorAll("input.singleCheck[type='checkbox']:checked").forEach((el, i) => {
        arr.push(el.value);
    });
    console.log(arr);
    var numberOfChecked = arr.length;
    console.log(numberOfChecked);
    if (numberOfChecked > 0) {
        document.getElementById("id_account_delete_arr").value = JSON.stringify(arr);
        document.getElementById("count_delete_account_selected").innerHTML = `${numberOfChecked} Account Row/s Selected`;
        document.getElementById("checkbox_control").removeAttribute('disabled');
    } else {
        document.getElementById("checkbox_control").setAttribute('disabled', true);
    }
}

const export_employees = () => {
    var employee_no = document.getElementById('employee_no_search').value;
    var full_name = document.getElementById('full_name_search').value;
    window.open('../../process/export/exp_accounts.php?employee_no=' + employee_no + "&full_name=" + full_name, '_blank');
}

const export_employees3 = () => {
    var employee_no = document.getElementById('employee_no_search').value;
    var full_name = document.getElementById('full_name_search').value;
    window.open('../../process/export/exp_accounts3.php?employee_no=' + employee_no + "&full_name=" + full_name, '_blank');
}

const export_csv = (table_id, separator = ',') => {
    // Select rows from table_id
    var rows = document.querySelectorAll('table#' + table_id + ' tr');
    // Construct csv
    var csv = [];
    for (var i = 0; i < rows.length; i++) {
        var row = [], cols = rows[i].querySelectorAll('td, th');
        for (var j = 0; j < cols.length; j++) {
            var data = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, '').replace(/(\s\s)/gm, ' ')
            data = data.replace(/"/g, '""');
            // Push escaped string
            row.push('"' + data + '"');
        }
        csv.push(row.join(separator));
    }
    var csv_string = csv.join('\n');
    // Download it
    var filename = 'Export-Accounts' + '_' + new Date().toLocaleDateString() + '.csv';
    var link = document.createElement('a');
    link.style.display = 'none';
    link.setAttribute('target', '_blank');
    link.setAttribute('href', 'data:text/csv;charset=utf-8,%EF%BB%BF' + encodeURIComponent(csv_string));
    link.setAttribute('download', filename);
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

const popup1 = () => {
    var employee_no = document.getElementById('employee_no_search').value;
    var full_name = document.getElementById('full_name_search').value;
    PopupCenter('../../process/export/exp_accounts3.php?employee_no=' + employee_no + "&full_name=" + full_name, 'Popup Export Accounts 3', '1190', '600');
}