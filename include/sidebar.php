<!DOCTYPE html>
<html lang="ar">
<head>
  <title>نظام إدارة مهام </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/bootstrap.theme.min.css">
  <link rel="stylesheet" href="assets/bootstrap-datepicker/css/datepicker.css">
  <link rel="stylesheet" href="assets/bootstrap-datepicker/css/datepicker-custom.css">
  <link rel="stylesheet" href="assets/css/custom.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
  <style>
    body {
  font-family: 'Tajawal', sans-serif;
  direction: rtl;
}

.navbar-inverse {
  background: linear-gradient(to bottom, #e50914, black);
  border: none;
}

.navbar-inverse .navbar-brand span {
  color: white;
  font-weight: bold;
}

.navbar-inverse .navbar-nav > .active > a, 
.navbar-inverse .navbar-nav > .active > a:hover, 
.navbar-inverse .navbar-nav > .active > a:focus {
  background-color: transparent;
}
/* النمط العام للأجهزة الأكبر */
.navbar-brand {
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    top: 0;
    transform: translateX(-50%);
}

/* تعديل الموضع للأجهزة الأصغر (الجوال) */
@media (max-width: 768px) {
    .navbar-brand {
        top: 50%;
        transform: translate(-50%, -50%);
    }
}
.nav navbar-nav navbar-nav-custom{

  margin-right: 20px; /* تعديل المسافة حسب الرغبة */
}



  </style>
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/custom.js"></script>
  <script src="assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
  <script src="assets/bootstrap-datepicker/js/datepicker-custom.js"></script>
  <script type="text/javascript">
    /* delete function confirmation  */
    function check_delete() {
      var check = confirm('هل أنت متأكد أنك تريد حذف هذا؟');
      if (check) {
        return true;
      } else {
        return false;
      }
    }
  </script>
</head>
<body>

<nav class="navbar navbar-inverse sidebar navbar-fixed-top" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-sidebar-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="task-list.php"><span>نظام إدارة المهام</span></a>
    </div>

    <?php
    $user_role = $_SESSION['user_role'];
    if($user_role == 1){
    ?>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-sidebar-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-nav-custom">
      <li <?php if($page_name == "Task_Info" ){echo "class=\"active\"";} ?>>
      <a href="task-list.php" style="color: #FFFFFF; margin-top: 40px; display: inline-block;">إدارة المهام
    <span style="font-size: 16px; color: #FFFFFF;" class="pull-right hidden-xs showopacity fa-solid fa-list-check"></span>
</a>

</li>


       

        <li <?php if($page_name == "Admin" ){echo "class=\"active\"";} ?>>
    <a href="manage-admin.php" style="color: #FFFFFF;">الإدارة
        <span style="font-size:16px; color:#FFFFFF;" class="pull-right hidden-xs showopacity glyphicon glyphicon-user"></span>
    </a>
</li>
<li>
<a href="?logout=logout" style="color: #FFFFFF;">تسجيل الخروج
    <span style="font-size: 16px; color: #FFFFFF;" class="pull-right hidden-xs showopacity glyphicon glyphicon-log-out"></span>
</a>

</li>

    </div>
    <?php 
    } else if($user_role == 2){
    ?>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-sidebar-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-nav-custom">
        <li <?php if($page_name == "Task_Info" ){echo "class=\"active\"";} ?>><a href="task-list.php">إدارة المهام<span style="font-size:16px; color:#d4ab3a;" class="pull-right hidden-xs showopacity glyphicon glyphicon-tasks"></span></a></li>
        <li><a href="?logout=logout">تسجيل الخروج<span style="font-size:16px; color:#d4ab3a;" class="pull-right hidden-xs showopacity glyphicon glyphicon-log-out"></span></a></li>
      </ul>
    </div>
    <?php
    } else {
      header('Location: index.php');
    }
    ?>
  </div>
</nav>

<div class="main">
<!-- Rest of your content goes here -->
</div>

</body>
</html>
