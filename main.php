<?php // sqltest.php
  require_once 'login.php';
  
//check login information
if ($_POST['name']!='ssd227'||$_POST['password']!='ssd227')
   die("your name or password is wrong");

//$un=$_POST['name'];
//$pw=$_POST['password'];


echo <<<_END
<form action="sub01.php" method="post">
      录入或修改成绩：<input type="submit" value="成绩">
</form>
<form action="sub02.php" method="post">
      录入或修改学生信息：<input type="submit" value="学生信息">
</form>
<form action="sub03.php" method="post">
      输出年级/班级报表：<input type="submit" value="年级/班级报表">
</form>
<form action="sub04.php" method="post">
      输出学生信息或成绩：<input type="submit" value="学生成绩/信息">
</form>
_END;
 

?>
