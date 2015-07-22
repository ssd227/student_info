<?php // sub03.php
  require_once 'login.php';
  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error) die($conn->connect_error);

  echo <<<_END
  <form action="sub03.php" method="post"><pre>
    GRADE <input type="text" name="grade">
    年级成绩报表  <input type="submit" value="GRADE RECORD">
  </pre></form>
  <form action="sub03.php" method="post"><pre>
    GRADE <input type="text" name="grade1">
    CLASS <input type="text" name="class">
    班级成绩报表  <input type="submit" value="CLASS RECORD">
  </pre></form>
_END;


  if (isset($_POST['grade1']) && isset($_POST['class']))
  {
    $grade   = get_post($conn, 'grade1');
    $class   = get_post($conn, 'class');
      
    $query    = "select grade,class,student.id,name,course,grades 
    	      from 
	      	   student join grade on student.id=grade.id
	      where
		grade='$grade' AND class='$class'
	      ORDER BY id,course,grades DESC";
		
    $result   = $conn->query($query);
    if (!$result) echo "SELECT failed: $query<br>" .
      $conn->error . "<br><br>";

   //output ...
    $rows = $result->num_rows;
  
    for ($j = 0 ; $j < $rows ; ++$j)
      {
       $result->data_seek($j);
       $row = $result->fetch_array(MYSQLI_NUM);

    echo <<<_END
      <pre>
         GRADE $row[0]
         CLASS $row[1]
         ID    $row[2]
         NAME  $row[3]
         COURSE $row[4]
	 GRADES $row[5]
     </pre>
_END;
      }
        $result->close();
  }

  elseif (isset($_POST['grade']) )
  {
    $grade   = get_post($conn, 'grade');
      
    $query    = "select grade,student.id,name,course,grades 
    	      from 
	      	   student join grade on student.id=grade.id
	      where
		grade='$grade'
	      ORDER BY id,course,grades DESC";
		
    $result   = $conn->query($query);
    if (!$result) echo "SELECT failed: $query<br>" .
      $conn->error . "<br><br>";

   //output ...
    $rows = $result->num_rows;
  
    for ($j = 0 ; $j < $rows ; ++$j)
      {
       $result->data_seek($j);
       $row = $result->fetch_array(MYSQLI_NUM);

    echo <<<_END
      <pre>
         GRADE $row[0]
         ID    $row[1]
         NAME  $row[2]
         COURSE $row[3]
	 GRADES $row[4]
     </pre>
_END;
      }
        $result->close();
  }
 

  $conn->close();
  
  function get_post($conn, $var)
  {
    return $conn->real_escape_string($_POST[$var]);
  }
?>
