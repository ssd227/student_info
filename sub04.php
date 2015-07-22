<?php // sub04.php
  require_once 'login.php';
  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error) die($conn->connect_error);

  echo <<<_END
  <h1>子目录4: 学生成绩和信息查询</h1>
  <form action="sub04.php" method="post"><pre>
    ID(学号） <input type="text" name="id">
    学生成绩<input type="radio" name="select" value="1" checked="checked">
    学生信息<input type="radio" name="select" value="2" >
              <input type="submit" value="OUTPUT">
  </pre></form>
  ---------------------------------------------------------------------
_END;


  if (isset($_POST['id']))
  {
    $id   = get_post($conn, 'id');
    $select   = get_post($conn, 'select');
  
    if($select==1)
      {
	$query    = "select student.id,name,course,grades 
    	            from 
	      	      student join grade on student.id=grade.id
	      	    where
			student.id='$id'
	      	    ORDER BY course, grades DESC";
		
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
         ID       $row[0]
         NAME     $row[1]
         COURSE   $row[2]
         GRADE    $row[3]
     </pre>
   ---------------------------------------------------------------------
_END;
      }
        $result->close();
     }
   elseif($select==2)
      {
	$query    = "select student.id,name,born,sex,age,grade,class,punishment,awards 
    	            from 
	      	      student
	      	    where
			student.id='$id'";
		
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
         STUDENT_ID       $row[0]
         NAME             $row[1]
         BORN        	  $row[2]
         SEX    	  $row[3]
	 AGE    	  $row[4]
	 GRADE   	  $row[5]
	 CLASS   	  $row[6]
	 PUNISHMENT   	  $row[7]
	 AWARDS 	  $row[8]
     </pre>
_END;
      }
        $result->close();
     }
     
  }
      
  $conn->close();
  
  function get_post($conn, $var)
  {
    return $conn->real_escape_string($_POST[$var]);
  }
?>
