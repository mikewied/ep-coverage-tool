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
          $plan = $_GET["plan"];
          if ($plan != null) {
            $cb = new Couchbase("127.0.0.1:8091");
            $data = $cb->get("add_test_plan");
            $json = json_decode($data);

            if ($json->{"type"} == "plan") {
              echo "<table id=\"testplan\"><tr><th>Testcase</th><th>Implementation</th></tr>";
              $tests = $json->{"test_definitions"};
              $alt = False;
              foreach ($tests as $test) {
                if ($alt) {
                  echo "<tr class=\"alt\"><td>";
                } else {
                  echo "<tr><td>";
                }
                echo "<b>Name:</b> " . $test->{"name"} . "<br>";
                echo "<b>Description:</b> " . $test->{"desc"};
                echo "</td><td>";
                $testcase = $cb->get($test->{"link"});
                if ($testcase != null) {
                  $link = $test->{"link"};
                  echo "<a href=\"single_test?test=" . $link . "\">" . $link . "</a>";
                } else {
                  echo $test->{"link"};
                }
                echo "</td></tr>";
                $alt = !$alt;
              }
              echo "</table>";
            } else {
              echo "Error: Tring to view something that's not a test plan!";
            }
          } else {
            echo "Error: No plan specified!";
          }
        ?>

      </div> <!-- end #content -->

      <?php include('includes/footer.php'); ?>
    </div> <!-- End #wrapper -->

  </body>
</html>

