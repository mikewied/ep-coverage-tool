
<div id="sidebar">
  <h3>Test Plans</h3>
  <?php
    $cb = new Couchbase("127.0.0.1:8091");
    $result = $cb->view("dev_testsuite", "test_plans");
    foreach($result["rows"] as $row) {
      $id = $row["id"];
      $name = $row["value"]["name"];
      echo "<li><a href=\"single_plan?plan=" . $id . "\">" . $name . "</a></li>";
    }
  ?>
</div> <!-- end #sidebar -->

