const get_accounts_details = (param) => {
    var string = param.split('~!~');
    var id = string[0];
    var id_number = string[1];
    var username = string[2];
    var full_name = string[3];
    var section = string[4];
    var role = string[5];

    document.getElementById('id_account_update').value = id;
    document.getElementById('employee_no_update').value = id_number;
    document.getElementById('username_update').value = username;
    document.getElementById('full_name_update').value = full_name;
    document.getElementById('password_update').value = '';
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

// Export CSV
document.getElementById("export_csv").addEventListener("click", e => {
    e.preventDefault();
    let table_id = "accounts_table";
    let filename = 'Export-Accounts' + '_' + new Date().toLocaleDateString() + '.csv';
    export_csv(table_id, filename);
});

const popup1 = () => {
    var employee_no = document.getElementById('employee_no_search').value;
    var full_name = document.getElementById('full_name_search').value;
    PopupCenter('../../process/export/exp_accounts3.php?employee_no=' + employee_no + "&full_name=" + full_name, 'Popup Export Accounts 3', '1190', '600');
}