<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="style.css" media="screen" />
    <title>EP-Engine Testsuite Documentation</title>
  </head>
  <body>

    <div id="wrapper">
      <?php include('includes/header.php'); ?>
      <?php include('includes/nav.php'); ?>
      <?php include('includes/sidebar.php'); ?>
      <div id="content">

        <form name="myform" action="search.php" method="POST">
          <div align="center">
            <select name="test_type">
              <option value="add">Add Operation</option>
              <option value="append">Append Operation</option>
              <option value="cas">Cas Operation</option>
              <option value="decr">Decr Operation</option>
              <option value="flush">Flush Operation</option>
              <option value="get">Get Operation</option>
              <option value="incr">Incr Operation</option>
              <option value="prepend">Prepend Operation</option>
              <option value="replace">Replace Operation</option>
              <option value="set">Set Operation</option>
              <option value="stats">Stats Operation</option>
              <option class="select-dash" disabled="disabled">---------------</option>
              <option value="basic_operation">Basic Operation</option>
              <option value="concurrency">Concurrency</option>
              <option value="engine_restart">Engine Restart</option>
              <option value="params">Configurable Parameters</option>
            </select>
            <input type="submit" />
          </div>
        </form>

        <?php
          if ($_POST["test_type"] != null) {
            $param = "\"" . $_POST["test_type"] . "\"";
            $cb = new Couchbase("127.0.0.1:8091");
            $result = $cb->view("dev_testsuite", "keywords", array("key" => $param));
            $hr = False;
            foreach($result["rows"] as $row) {
              if ($hr) {
                echo "<hr>";
              }
              $hr = True;
              $data = $cb->get($row["id"]);
              $json = json_decode($data);
              echo "<h2>" . $json->{"testname"} . "</h2>";
              echo "<i><b>" . $json->{"brief"} . "</i></b><br>";
              if ($json->{"detailed_desc"} != null) {
                echo $json->{"detailed_desc"} . "<br><br>";
              } else {
                echo "<br>";
              }
              echo "<b>Definition:</b> " . $json->{"name"} . $json->{"args"} . "<br>";
              echo "<b>Keywords:</b> ";
              foreach ($json->{"keywords"} as $keyword) {
                echo $keyword . " ";
              }
            }
          }
        ?>
      </div> <!-- end #content -->

      <?php include('includes/footer.php'); ?>
    </div> <!-- End #wrapper -->

  </body>
</html>

