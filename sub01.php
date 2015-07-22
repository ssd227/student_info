<?php // sub01.php
  require_once 'login.php';
  
  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error) die($conn->connect_error);


//delete operation 
  if (isset($_POST['delete']) &&
      isset($_POST['g_id'])     &&
      isset($_POST['g_course'])  &&
      isset($_POST['g_year'])	&&
      isset($_POST['g_term']))
  {
    $id   = get_post($conn, 'g_id');
    $course=get_post($conn, 'g_course');
    $year=get_post($conn, 'g_year');
    $term=get_post($conn, 'g_term');

    $query  = "DELETE FROM grade WHERE 
      id='$id'         AND
      course='$course' AND
      year='$year'     AND
      term='$term'";
      
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
    $query    = "INSERT INTO grade VALUES" .
      "('$course', '$term', '$year', '$grades', '$id')";
    $result   = $conn->query($query);
  	if (!$result) echo "INSERT failed: $query<br>" .
      $conn->error . "<br><br>";
  }

  echo <<<_END
  <form action="sub01.php" method="post"><pre>
     Course   <input type="text" name="course">
     Term     <input type="text" name="term">
     Year     <input type="text" name="year">
     Grades   <input type="text" name="grades">
     ID       <input type="text" name="id">
              <input type="submit" name="add" value="ADD RECORD">
</pre></form>
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
  </pre>
  
  <form action="sub01.php" method="post">
  <input type="hidden" name="delete" value="yes">
  <input type="hidden" name="g_course" value="$row[0]">
  <input type="hidden" name="g_term" value="$row[1]">
  <input type="hidden" name="g_year" value="$row[2]">
  <input type="hidden" name="g_id" value="$row[4]">
  <input type="submit" value="DELETE RECORD"></form>
_END;
  }
  
  $result->close();
  $conn->close();
  
  function get_post($conn, $var)
  {
    return $conn->real_escape_string($_POST[$var]);
  }
?>
