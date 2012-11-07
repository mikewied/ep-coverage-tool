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

        <?php
          if ($_GET["test"] != null) {
            $cb = new Couchbase("127.0.0.1:8091");
            $data = $cb->get($_GET["test"]);
            $json = json_decode($data);
            if ($json->{"type"} == "testcase") {
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
            } else {
              echo "Error: Trying to view something that's not a test.";
            }
          } else {
            echo "Error: No testcase specified.";
          }
        ?>

      </div> <!-- end #content -->

      <?php include('includes/footer.php'); ?>
    </div> <!-- End #wrapper -->

  </body>
</html>

