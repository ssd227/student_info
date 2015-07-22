<?php // sub01.php
  require_once 'login.php';
  
  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error) die($conn->connect_error);


//delete operation 
  if (isset($_POST['delete']) &&
      isset($_POST['g_num']))
  {
    $num   = get_post($conn, 'g_num'); 
    
    $query  = "DELETE FROM grade WHERE 
      num='$num'";
      
    $result = $conn->query($query);
  	if (!$result) echo "DELETE failed: $query<br>" .
      $conn->error . "<br><br>";
  }
  
  

  if (isset($_POST['course'])   &&
      isset($_POST['year'])    &&
      isset($_POST['term']) &&
      isset($_POST['id'])     &&
      isset($_POST['grades']))
  {
    $course   = get_post($conn, 'course');
    $year     = get_post($conn, 'year');
    $term     = get_post($conn, 'term');
    $id       = get_post($conn, 'id');
    $grades   = get_post($conn, 'grades');
    $select   = get_post($conn, 'select');
    $num      = $_POST['num'];

    if($select==1)
    {
	$query    = "INSERT INTO grade VALUES" .
      	"('$course', '$term', '$year', '$grades', '$id','NULL')";
    	$result   = $conn->query($query);
  	if (!$result) echo "INSERT failed: $query<br>" .
      	$conn->error . "<br><br>";
    }
    elseif($select==2 && $num>0)
    {
	  $query    = "UPDATE grade SET course='$course',term='$term',".
	  "year='$year',grades='$grades',id='$id'".
	  "where num='$num'";
          $result   = $conn->query($query);
	  if (!$result) echo "MODIFY failed: $query<br>" .
	  $conn->error . "<br><br>";
    
    }
  }

  echo <<<_END
  <h1>子目录1：录入和修改成绩</h1>
  <form action="sub01.php" method="post"><pre>
     Course   <input type="text" name="course"> 如：math，chinese，english
     Term     <input type="text" name="term"> 如：只可以输入 1，2
     Year     <input type="text" name="year"> 如：2014 （表示2014学年）
     Grades   <input type="text" name="grades"> 如：99 （分）单位省略
     ID       <input type="text" name="id"> 如：选课学生的ID
     NUM(仅在修改时需要填写，系统自动生成)    <input type="text" name="num" value="NULL">
     ADD    添加 <input type="radio" name="select" value="1" checked="checked">
     MODIFY 修改 <input type="radio" name="select" value="2">
     提交        <input type="submit" name="add" value="SUBMIT">
</pre></form>
<h2>结果如下：（可随意删改）</h2>
_END;

  $query  = "SELECT * FROM grade";
  $result = $conn->query($query);
  if (!$result) die ("Database access failed: " . $conn->error);

  $rows = $result->num_rows;
  
  for ($j = 0 ; $j < $rows ; ++$j)
  {
    $result->data_seek($j);
    $row = $result->fetch_array(MYSQLI_NUM);

    echo <<<_END
  <pre>
    Course $row[0]
    Term  $row[1]
    Year $row[2]
    Grade $row[3]
    ID $row[4]
    NUM $row[5]
  </pre>
  <form action="sub01.php" method="post">
  <input type="hidden" name="delete" value="yes">
  <input type="hidden" name="g_num" value="$row[5]">
  <input type="submit" value="DELETE"></form>
  -----------------------------------------------------------------------------
_END;

  }
  
  $result->close();
  $conn->close();
  
  function get_post($conn, $var)
  {
    return $conn->real_escape_string($_POST[$var]);
  }
?>
