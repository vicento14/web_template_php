 <footer class="main-footer">
    <strong>Copyright &copy; 2023. Developed by: Vince Dale Alcantara</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0.0
    </div>
  </footer>
<?php
//MODALS
include '../../modals/logout_modal.php';
include '../../modals/new_account.php';
include '../../modals/update_account.php';
include '../../modals/import_accounts.php';
include '../../modals/confirm_delete_account_selected.php';

// Close Connection
$conn = NULL;
?>
<!-- jQuery -->
<script src="../../plugins/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="../../plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="../../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.js"></script>
<!-- Popup Center -->
<script src="../../dist/js/popup_center.js"></script>
<!-- Export CSV -->
<script src="../../dist/js/export_csv.js"></script>

<?php
$url_components = parse_url($_SERVER['REQUEST_URI']);

if ($url_components['path'] == "/web_template_php/page/admin/accounts.php") { 
?>
  <!-- Accounts Script -->
  <script src="../../dist/js/admin/accounts.js"></script>
<?php
}
?>

</body>
</html>