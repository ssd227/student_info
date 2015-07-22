<?php // sub02.php
  require_once 'login.php';
  
  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error) die($conn->connect_error);


//delete operation 
  if (isset($_POST['delete']) &&
      isset($_POST['s_id']))
  {
    $id   = get_post($conn, 's_id'); 
    
    $query  = "DELETE FROM student WHERE 
      id='$id'";
      
    $result = $conn->query($query);
  	if (!$result) echo "DELETE failed: $query<br>" .
      $conn->error . "<br><br>";
  }
  
  

  if (isset($_POST['id'])	&&
      isset($_POST['name'])     &&
      isset($_POST['sex']) 	&&
      isset($_POST['age'])     	&&
      isset($_POST['grade'])    &&
      isset($_POST['class'])    &&
      isset($_POST['punishment'])  &&
      isset($_POST['awards']) 	   &&
      isset($_POST['born']))
  {
    $id        = get_post($conn, 'id');
    $name      = get_post($conn, 'name');
    $sex       = get_post($conn, 'sex');
    $age       = get_post($conn, 'age');
    $grade     = get_post($conn, 'grade');
    $class     = get_post($conn, 'class');
    $punishment = get_post($conn, 'punishment');
    $awards    = get_post($conn, 'awards');
    $born      = get_post($conn, 'born');
    $select   = get_post($conn, 'select');
    
    if($select==1)
    {
	$query    = "INSERT INTO student VALUES" .
      	"('$id', '$name', '$sex', '$age', '$grade','$class','$punishment','$awards','$born')";
    	$result   = $conn->query($query);
  	if (!$result) echo "INSERT failed: $query<br>" .
      	$conn->error . "<br><br>";
    }
    elseif($select==2)
    {
	  $query    = "UPDATE student SET  name='$name',sex='$sex',
                       age='$age', grade='$grade',class='$class',punishment='$punishment',
                       awards='$awards',born='$born' where id='$id'";
          $result   = $conn->query($query);
	  if (!$result) echo "MODIFY failed: $query<br>" .
	  $conn->error . "<br><br>";
    
    }
  }

  echo <<<_END
  <form action="sub02.php" method="post"><pre>
     ID      <input type="text" name="id">
     NAME    <input type="text" name="name">
     SEX     <input type="text" name="sex">
     AGE     <input type="text" name="age">
     GRADE   <input type="text" name="grade">
     CLASS   <input type="text" name="class">
     PUNISHMENT   <input type="text" name="punishment">
     AWARDS  <input type="text" name="awards">
     BORN    <input type="text" name="born">
     ADD    添加 <input type="radio" name="select" value="1" checked="checked">
     MODIFY 修改 <input type="radio" name="select" value="2">
              <input type="submit" name="add" value="SUBMIT">
</pre></form>
_END;

  $query  = "SELECT * FROM student";
  $result = $conn->query($query);
  if (!$result) die ("Database access failed: " . $conn->error);

  $rows = $result->num_rows;
  
  for ($j = 0 ; $j < $rows ; ++$j)
  {
    $result->data_seek($j);
    $row = $result->fetch_array(MYSQLI_NUM);

    echo <<<_END
  <pre>
    ID    $row[0]
    NAME  $row[1]
    SEX   $row[2]
    AGE   $row[3]
    GRADE $row[4]
    CLASS $row[5]
    PUNISHMENT $row[6]
    AWARDS $row[7]
    BORN   $row[8]
  </pre>
  
  <form action="sub02.php" method="post">
  <input type="hidden" name="delete" value="yes">
  <input type="hidden" name="s_id" value="$row[0]">
  <input type="submit" value="DELETE"></form>
  
_END;

  }
  
  $result->close();
  $conn->close();
  
  function get_post($conn, $var)
  {
    return $conn->real_escape_string($_POST[$var]);
  }
?>
