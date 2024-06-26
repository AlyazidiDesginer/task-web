<?php

require 'authentication.php'; // التحقق من مصادقة المسؤول

// التحقق من المصادقة
$user_id = $_SESSION['admin_id'];
$user_name = $_SESSION['name'];
$security_key = $_SESSION['security_key'];
if ($user_id == NULL || $security_key == NULL) {
    header('Location: index.php');
}

// التحقق من دور المسؤول
$user_role = $_SESSION['user_role'];

// التعامل مع حذف المهام
if(isset($_GET['delete_task'])){
  $action_id = $_GET['task_id'];
  
  $sql = "DELETE FROM task_info WHERE task_id = :id";
  $sent_po = "task-list.php";
  $obj_admin->delete_data_by_this_method($sql,$action_id,$sent_po);
}

// التعامل مع إضافة مهمة جديدة
if(isset($_POST['add_task_post'])){
    $obj_admin->add_new_task($_POST);
}

// التحقق من التصفية
$filter_status = isset($_GET['filter_status']) ? $_GET['filter_status'] : '';

// بناء استعلام SQL حسب التصفية
if($user_role == 1){
    $sql = "SELECT a.*, b.fullname 
            FROM task_info a
            INNER JOIN tbl_admin b ON(a.t_user_id = b.user_id)";
    
    if ($filter_status !== '') {
        $sql .= " WHERE a.status = $filter_status";
    }

    $sql .= " ORDER BY a.task_id DESC";
}else{
    $sql = "SELECT a.*, b.fullname 
            FROM task_info a
            INNER JOIN tbl_admin b ON(a.t_user_id = b.user_id)
            WHERE a.t_user_id = $user_id";
    
    if ($filter_status !== '') {
        $sql .= " AND a.status = $filter_status";
    }

    $sql .= " ORDER BY a.task_id DESC";
}

$page_name="Task_Info";
include("include/sidebar.php");

?>
<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة المهام</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="path/to/your/rtl.css"> <!-- تعديل المسار حسب مكان ملف الـ RTL CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"> <!-- لإضافة أيقونات FontAwesome -->
    <style>
        /* تعديلات إضافية إذا لزم الأمر */
        body {
            font-family: 'Tajawal', sans-serif; /* استخدام خط تجاوال */
            background-color: #2c2525; /* لون خلفية الصفحة */
        }
        /* تحسين التصميم للأزرار */
        .btn-custom {
            background-color: #5cb85c;
            color: white;
            border-color: #4cae4c;
        }
        .btn-custom:hover {
            background-color: #4cae4c;
            border-color: #398439;
        }

        /* تحسين تصميم الجدول */
        .table-custom {
            background-color: #333; /* لون خلفية الجدول */
            border-radius: 5px; /* حواف مستديرة */
            box-shadow: 0 0 10px rgba(0,0,0,0.1); /* ظل للجدول */
            color: #fff; /* لون نص الجدول */
        }
        .table-custom th,
        .table-custom td {
            text-align: center; /* محاذاة النصوص في الخلايا */
            padding: 10px; /* تباعد داخلي */
        }
        .table-custom thead {
            background-color: #d9534f; /* لون خلفية العناوين في الجدول (أحمر) */
        }
        .table-custom tbody tr:nth-child(even) {
            background-color: #555; /* لون خلفية الصفوف الزوجية (أسود) */
        }
        .table-custom tbody tr:hover {
            background-color: #777; /* لون خلفية الصفوف عند التحويم */
        }
        .form-group {
      margin-top: 20px; /* لتحريك العنصر إلى أسفل */
      margin-left: 10px;
        }
    </style>
</head>
<body>

<!-- Modal لإضافة مهمة جديدة -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog add-category-modal">
    
        <!-- محتوى المودال -->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="modal-title text-center">تعيين مهمة جديدة</h2>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form role="form" action="" method="post" autocomplete="off">
                            <div class="form-horizontal">
                                <div class="form-group">
                                    <label class="control-label col-sm-5">عنوان المهمة</label>
                                    <div class="col-sm-7">
                                        <input type="text" placeholder="عنوان المهمة" id="task_title" name="task_title" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-5">وصف المهمة</label>
                                    <div class="col-sm-7">
                                        <textarea name="task_description" id="task_description" placeholder="وصف المهمة" class="form-control" rows="5" required></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-5">وقت البدء</label>
                                    <div class="col-sm-7">
                                        <input type="text" name="t_start_time" id="t_start_time" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-5">وقت الانتهاء</label>
                                    <div class="col-sm-7">
                                        <input type="text" name="t_end_time" id="t_end_time" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-5">تعيين إلى</label>
                                    <div class="col-sm-7">
                                        <?php 
                                            $sql_users = "SELECT user_id, fullname FROM tbl_admin WHERE user_role = 2";
                                            $info = $obj_admin->manage_all_info($sql_users);   
                                        ?>
                                        <select class="form-control" name="assign_to" id="assign_to" required>
                                            <option value="">اختر مستخدم...</option>
                                            <?php while($row = $info->fetch(PDO::FETCH_ASSOC)){ ?>
                                            <option value="<?php echo $row['user_id']; ?>"><?php echo $row['fullname']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-3">
                                        <button type="submit" name="add_task_post" class="btn btn-custom">تعيين مهمة</button>
                                    </div>
                                    <div class="col-sm-3">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">إلغاء</button>
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

<!-- تصفية المهام -->
<div class="row">
    <div class="col-md-12">
        <div class="well well-custom">
            <div class="gap"></div>
            <div class="row">
                <div class="col-md-8">
                    <div class="btn-group">
                        <?php if($user_role == 1){ ?>
                        <div class="btn-group">
                            <button class="btn btn-warning btn-menu" data-toggle="modal" data-target="#myModal"><i class="fas fa-plus"></i> تعيين مهمة جديدة</button>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <form method="get" action="">
                        <div class="form-group">
                            <label for="filter_status">تصفية حسب الحالة:</label>
                            <select class="form-control" id="filter_status" name="filter_status" onchange="this.form.submit()">
                                <option value="">الكل</option>
                                <option value="0" <?php if($filter_status === '0') echo 'selected'; ?>>غير مكتملة</option>
                                <option value="1" <?php if($filter_status === '1') echo 'selected'; ?>>قيد التنفيذ</option>
                                <option value="2" <?php if($filter_status === '2') echo 'selected'; ?>>مكتملة</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
            
            <center><h3>قسم إدارة المهام</h3></center>
            <div class="gap"></div>
            <div class="table-responsive">
                <table class="table table-condensed table-custom">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>عنوان المهمة</th>
                            <th>المسندة إلى</th>
                            <th>وقت البدء</th>
                            <th>وقت الانتهاء</th>
                            <th>الحالة</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $info = $obj_admin->manage_all_info($sql);
                        $serial  = 1;
                        $num_row = $info->rowCount();
                        if($num_row == 0){
                            echo '<tr><td colspan="7">لا توجد بيانات</td></tr>';
                        }
                        while($row = $info->fetch(PDO::FETCH_ASSOC)){
                        ?>
                        <tr>
                            <td><?php echo $serial; $serial++; ?></td>
                            <td><?php echo $row['t_title']; ?></td>
                            <td><?php echo $row['fullname']; ?></td>
                            <td><?php echo $row['t_start_time']; ?></td>
                            <td><?php echo $row['t_end_time']; ?></td>
                            <td>
                                <?php  
                                if($row['status'] == 1){
                                    echo "قيد التنفيذ <i class='fas fa-spinner' style='color:#d4ab3a;'></i>";
                                }elseif($row['status'] == 2){
                                    echo "مكتملة <i class='fas fa-check-circle' style='color:#00af16;'></i>";
                                }else{
                                    echo "غير مكتملة <i class='fas fa-times-circle' style='color:#d00909;'></i>";
                                } 
                                ?>
                            </td>
                            <td>
                                <a title="تحديث المهمة" href="edit-task.php?task_id=<?php echo $row['task_id'];?>"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;
                                <a title="عرض" href="task-details.php?task_id=<?php echo $row['task_id']; ?>"><i class="fas fa-folder-open"></i></a>&nbsp;&nbsp;
                                <?php if($user_role == 1){ ?>
                                <a title="حذف" href="?delete_task=delete_task&task_id=<?php echo $row['task_id']; ?>" onclick="return check_delete();"><i class="fas fa-trash"></i></a>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<?php include("include/footer.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>

<script type="text/javascript">
  flatpickr('#t_start_time', {
    enableTime: true,
    dateFormat: "Y-m-d H:i"
  });

  flatpickr('#t_end_time', {
    enableTime: true,
    dateFormat: "Y-m-d H:i"
  });
</script>
<footer class="footer" style="background-color: white;">
  <div class="container">
    <p class="text-muted text-center" style="color: black;">مطور محمد اليزيدي  </p>
  </div>
</footer>


</body>
</html>

