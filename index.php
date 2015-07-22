<?php // formtest.php
echo <<<_END
  <html>
    <head>
      <title>Form Test</title>
    </head>
    <body>
    <h1>学生信息管理系统</h1>
    <form method="post" action="main.php"><pre>
      用户名： <input type="text" name="name" value='ssd227'>
      用户密码： <input type="text" name="password">
      <input type="submit" value='log in'>
    </pre></form>
    </body>
  </html>
_END;
?>
