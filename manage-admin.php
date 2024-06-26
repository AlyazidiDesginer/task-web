<?php
require 'authentication.php'; // التحقق من المصادقة للمشرفين

// التحقق من المصادقة
$user_id = $_SESSION['admin_id'];
$user_name = $_SESSION['name'];
$security_key = $_SESSION['security_key'];
if ($user_id == NULL || $security_key == NULL) {
    header('Location: index.php');
}

// التحقق من المشرف
$user_role = $_SESSION['user_role'];
if ($user_role != 1) {
  header('Location: task-list.php');
}

$page_name = "المشرفين";
include("include/sidebar.php");
?>

<div class="row">
  <div class="col-md-12">
    <div class="well well-custom">
      <ul class="nav nav-tabs nav-justified nav-tabs-custom">
        <li class="active"><a href="manage-admin.php">إدارة المشرفين</a></li>
        <li><a href="admin-manage-user.php">إدارة المستخدمين</a></li>
      </ul>
      <div class="gap"></div>
      <div class="table-responsive">
        <table class="table table-condensed table-custom">
          <thead>
            <tr>
              <th>الرقم التسلسلي</th>
              <th>الاسم</th>
              <th>البريد الإلكتروني</th>
              <th>اسم المستخدم</th>
              <th>التفاصيل</th>
            </tr>
          </thead>
          <tbody>
            <?php 
              $sql = "SELECT * FROM tbl_admin WHERE user_role = 1";
              $info = $obj_admin->manage_all_info($sql);

              $serial = 1;
              while($row = $info->fetch(PDO::FETCH_ASSOC)){
            ?>
            <tr>
              <td><?php echo $serial; $serial++; ?></td>
              <td><?php echo $row['fullname']; ?></td>
              <td><?php echo $row['email']; ?></td>
              <td><?php echo $row['username']; ?></td>
              <td><a title="تحديث بيانات المشرف" href="update-admin.php?admin_id=<?php echo $row['user_id']; ?>"><span class="glyphicon glyphicon-edit"></span></a>&nbsp;&nbsp;</td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php
if(isset($_SESSION['update_user_pass'])){
  echo '<script>alert("تم تحديث كلمة المرور بنجاح");</script>';
  unset($_SESSION['update_user_pass']);
}
include("include/footer.php");
?>
