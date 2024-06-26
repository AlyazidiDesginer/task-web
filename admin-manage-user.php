<?php
require 'authentication.php'; // التحقق من المصادقة للمشرفين

// التحقق من المصادقة
$user_id = $_SESSION['admin_id'];
$user_name = $_SESSION['name'];
$security_key = $_SESSION['security_key'];

if ($user_id == NULL || $security_key == NULL) {
    header('Location: index.php');
    exit();
}

// التحقق من المشرف
$user_role = $_SESSION['user_role'];
if ($user_role != 1) {
    header('Location: task-list.php');
    exit();
}

// حذف مستخدم
if (isset($_GET['delete_user'])) {
    $action_id = $_GET['admin_id'];

    // حذف المهام الخاصة بالمستخدم
    $task_sql = "DELETE FROM task_info WHERE t_user_id = :action_id";
    $delete_task = $obj_admin->db->prepare($task_sql);
    $delete_task->bindParam(':action_id', $action_id);
    $delete_task->execute();

    // حذف الحضور الخاص بالمستخدم
    $attendance_sql = "DELETE FROM attendance_info WHERE atn_user_id = :action_id";
    $delete_attendance = $obj_admin->db->prepare($attendance_sql);
    $delete_attendance->bindParam(':action_id', $action_id);
    $delete_attendance->execute();
  
    // حذف المستخدم من الجدول
    $sql = "DELETE FROM tbl_admin WHERE user_id = :id";
    $sent_po = "admin-manage-user.php";
    $obj_admin->delete_data_by_this_method($sql, $action_id, $sent_po);
}

$page_name = "المشرفين";
include("include/sidebar.php");

// إضافة مستخدم جديد
if (isset($_POST['add_new_employee'])) {
    $error = $obj_admin->add_new_user($_POST);
}
?>
<head>
  <!-- بقية وسوم الـhead -->
  <style>
    .add-user-button {
      margin-top: 40px; /* لتحريك الزر إلى أسفل */
      margin-left: 10px; /* لتحريك الزر إلى اليمين */
      /* يمكنك ضبط القيم حسب حاجتك */
      
      /* أو يمكنك استخدام position لتحديد موقع الزر بدقة أكبر */
      /* position: relative; */
      /* top: 20px; */
      /* left: 10px; */
    }
  </style>
</head>


<!-- Modal لإضافة مستخدم جديد -->
<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog">
    <!-- محتوى الـModal -->
     
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        
        <h2 class="modal-title text-center">إضافة معلومات مستخدم</h2>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <?php if (isset($error)) { ?>
              <h5 class="alert alert-danger"><?php echo $error; ?></h5>
            <?php } ?>
            <form role="form" action="" method="post" autocomplete="off">
              <div class="form-horizontal">
                <div class="form-group">
                  <label class="control-label col-sm-4">الاسم الكامل</label>
                  <div class="col-sm-8">
                    <input type="text" placeholder="ادخل اسم مستخدم" name="em_fullname" list="expense" class="form-control input-custom" id="default" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-4">اسم المستخدم</label>
                  <div class="col-sm-8">
                    <input type="text" placeholder="ادخل اسم المستخدم" name="em_username" class="form-control input-custom" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-4">البريد الإلكتروني</label>
                  <div class="col-sm-8">
                    <input type="email" placeholder="ادخل البريد الإلكتروني للمستخدم" name="em_email" class="form-control input-custom" required>
                  </div>
                </div>
                <div class="form-group"></div>
                <div class="form-group">
                  <div class="col-sm-offset-4 col-sm-4">
                    <button type="submit" name="add_new_employee" class="btn btn-success-custom btn-block">إضافة مستخدم</button>
                  </div>
                  <div class="col-sm-4">
                    <button type="button" class="btn btn-danger-custom btn-block" data-dismiss="modal">إلغاء</button>
                  </div>
                </div>
              </div>
            </form> 
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- نهاية الـModal -->

<div class="row">
  <div class="col-md-12">
    <div class="row">
      <div class="well well-custom">
        <?php if (isset($error)) { ?>
          <script type="text/javascript">
            $('#myModal').modal('show');
          </script>
        <?php } ?>
        <?php if ($user_role == 1) { ?>
          
          <div class="btn-group">
          <button class="btn btn-success btn-menu add-user-button" data-toggle="modal" data-target="#myModal">إضافة مستخدم جديد</button>
          </div>
        <?php } ?>
        <ul class="nav nav-tabs nav-justified nav-tabs-custom">
          <li><a href="manage-admin.php">إدارة المشرفين</a></li>
          <li class="active"><a href="admin-manage-user.php">إدارة مستخدمين</a></li>
        </ul>
        <div class="gap"></div>
        <div class="table-responsive">
          <table class="table table-condensed table-custom">
            <thead>
              <tr>
                <th>الرقم التسلسلي</th>
                <th>الاسم الكامل</th>
                <th>البريد الإلكتروني</th>
                <th>اسم المستخدم</th>
                <th>كلمة المرور المؤقتة</th>
                <th>التفاصيل</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                $sql = "SELECT * FROM tbl_admin WHERE user_role = 2 ORDER BY user_id DESC";
                $info = $obj_admin->manage_all_info($sql);
                $serial  = 1;
                $num_row = $info->rowCount();
                if ($num_row == 0) {
                  echo '<tr><td colspan="7">لا توجد بيانات</td></tr>';
                } else {
                  while ($row = $info->fetch(PDO::FETCH_ASSOC)) {
              ?>
              <tr>
                <td><?php echo $serial; $serial++; ?></td>
                <td><?php echo $row['fullname']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['temp_password']; ?></td>
                <td>
                  <a title="تحديث بيانات مستخدم" href="update-employee.php?admin_id=<?php echo $row['user_id']; ?>"><span class="glyphicon glyphicon-edit"></span></a>
                  &nbsp;&nbsp;
                  <a title="حذف" href="?delete_user=delete_user&admin_id=<?php echo $row['user_id']; ?>" onclick="return check_delete();"><span class="glyphicon glyphicon-trash"></span></a>
                </td>
              </tr>
              <?php 
                  } 
                } 
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
if (isset($_SESSION['update_user_pass'])) {
  echo '<script>alert("تم تحديث كلمة المرور بنجاح");</script>';
  unset($_SESSION['update_user_pass']);
}
include("include/footer.php");
?>
