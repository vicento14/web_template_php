<?php include 'plugins/navbar.php';?>
<?php include 'plugins/sidebar/admin_bar.php';?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Account Management</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
            <li class="breadcrumb-item active">Account Management</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-2">
          <a href="#" class="btn btn-success btn-block" data-toggle="modal" data-target="#new_account"><i class="fas fa-plus-circle mr-2"></i>Register Account</a>
        </div>
        <div class="col-2">
          <a href="#" class="btn btn-warning btn-block" data-toggle="modal" data-target="#import_accounts"><i class="fas fa-upload mr-2"></i>Import Account</a>
        </div>
        <div class="col-2">
          <a href="#" class="btn btn-secondary btn-block" onclick="export_employees()"><i class="fas fa-download mr-2"></i>Export Account</a>
        </div>
        <div class="col-2">
          <a href="#" class="btn btn-info btn-block" onclick="export_csv('accounts_table')"><i class="fas fa-download mr-2"></i>Export Account 2</a>
        </div>
        <div class="col-2">
          <a href="#" class="btn btn-primary btn-block" onclick="export_employees3()"><i class="fas fa-download mr-2"></i>Export Account 3</a>
        </div>
        <div class="col-2">
          <a href="#" class="btn btn-info btn-block" onclick="popup1()"><i class="fas fa-download mr-2"></i>Export Account 3 Popup</a>
        </div>
      </div>
      <div class="row mb-2">
        <div class="col-2">
          <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#confirm_delete_account_selected" id="checkbox_control" disabled><i class="fas fa-trash mr-2"></i>Delete Checked</button>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="card card-gray-dark card-outline">
            <div class="card-header">
              <h3 class="card-title"><i class="fas fa-user"></i> Accounts Table</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                  <i class="fas fa-expand"></i>
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <form class="mb-0" action="<?=htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="GET">
                <div class="row mb-4">
                  <div class="col-sm-3">
                    <label>Employee No:</label>
                    <input type="text" id="employee_no_search" name="employee_no_search" class="form-control" autocomplete="off">
                  </div>
                  <div class="col-sm-3">
                    <label>Full Name:</label>
                    <input type="text" id="full_name_search" name="full_name_search" class="form-control" autocomplete="off">
                  </div>
                  <div class="col-sm-3">
                    <label>User Type:</label>
                    <select id="user_type_search" name="user_type_search" class="form-control">
                      <option value="">Select User Type</option>
                      <option value="admin">Admin</option>
                      <option value="user">User</option>
                    </select>
                  </div>
                  <div class="col-sm-3">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn btn-block btn-primary" id="btnSearchAccount" name="search_account" value="1"><i class="fas fa-search mr-2"></i>Search</button>
                  </div>
                </div>
              </form>
              <div class="table-responsive" style="height: 500px; overflow: auto; display:inline-block;">
                <table class="table table-head-fixed text-nowrap table-hover" id="accounts_table">
                  <thead style="text-align:center;">
                    <th>
                      <input type="checkbox" name="" id="check_all"  onclick="select_all_func()">
                    </th>
                    <th> # </th>
                    <th> Employee No. </th>
                    <th> Username </th>
                    <th> Full Name </th>
                    <th> Section </th>
                    <th> User Type </th>
                  </thead>
                  <tbody id="list_of_accounts" style="text-align:center;"><?=$data?></tbody>
                </table>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <!-- /.row -->
    </div>
  </section>
</div>

<?php include 'plugins/footer.php';?>