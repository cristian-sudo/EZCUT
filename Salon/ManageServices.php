<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <style media="screen">
    .zui-table {
  border: solid 1px #DDEEEE;
  border-collapse: collapse;
  border-spacing: 0;
  font: normal 13px Arial, sans-serif;
}
.zui-table thead th {
  background-color: #DDEFEF;
  border: solid 1px #DDEEEE;
  color: #336B6B;
  padding: 10px;
  text-align: left;
  text-shadow: 1px 1px 1px #fff;
}
.zui-table tbody td {
  border: solid 1px #DDEEEE;
  color: #333;
  padding: 10px;
  text-shadow: 1px 1px 1px #fff;
}
    </style>
  </head>
  <body>
    <?php
    require('/Applications/XAMPP/xamppfiles/htdocs/EZCUT/Salon/Menu.php');
    $stmt = $dbh->getInstance()->prepare("
    SELECT
   services.ServiceID,
   services.ServiceName,
   services.Price,
   services.TimeDurationHours,
   services.TimeDurationMinutes,
   ServiceCategories.ServiceCategoryName,
   services.ShortDescription
       FROM
       services
   INNER JOIN hairdressingsalons ON services.SalonID = hairdressingsalons.SalonID
   INNER JOIN servicecategories ON services.ServiceCategoryID = servicecategories.ServiceCategoryID
   WHERE hairdressingsalons.Name='".$_SESSION['SalonName']."' ORDER BY servicecategories.ServiceCategoryName DESC
 ");
    $stmt->execute();
    $row=$stmt;
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
   if ($row) {//if exist results
      echo "
    <table class='zui-table'><tr>
    <th>Service ID</th>
    <th>Service Name</th>
    <th>Price</th>
    <th>Time Duration Hours</th>
    <th>Time Duration Minutes</th>
    <th>Service Category Name</th>
    <th>Short Description</th>
  </tr>";//print the values
      foreach ($row as $key => $value) {
        echo "<form method='post' action='ConfirmServices.php'>";
        echo "<tr>";
        echo "<td>".$value['ServiceID']."</td>";
        echo "<td>".$value['ServiceName']."</td>";
        echo "<td>".$value['Price']."</td>";
        echo "<td>".$value['TimeDurationHours']."Hrs</td>";
        echo "<td>".$value['TimeDurationMinutes']."Min</td>";
        echo "<td>".$value['ServiceCategoryName']."</td>";
        echo "<td>".$value['ShortDescription']."</td>";
        echo "</tr>";
        //inputs
        echo "<tr>";
        echo '
        <td><input type="text" name="ServiceID" value="'.$value['ServiceID'].'" readonly></td>
        <td><input type="text" name="ServiceName"></td>
        <td><input type="number" step=0.01 min=1 name="Price"></td>
        <td><input type="number" name="TimeDurationHours"></td>
        <td><input type="text" name="TimeDurationMinutes"></td>';
        echo '
        <td>
        <select name="ServiceCategoryID">
        <option></option>';
        require('/Applications/XAMPP/xamppfiles/htdocs/EZCUT/Salon/GettingCategories.php');
        foreach ($resultCategories as $key2 => $value2) {
        echo '<option value="'.$value2['ServiceCategoryID'].'">' . $value2['ServiceCategoryName'] . '</option>';
      }
        echo '
        </select>
        </td>

        <td><input type="text" name="ShortDescription"></td>
        <td><input type="submit" value="Confirm Changes" name="Confirm"></td>
        </form>
        </tr>';}
      echo "</table>";
      echo '<form method="get" action="ConfirmServices.php">
      <button type="submit" name="Add">Add a new service</button>
      </form>';
}
     ?>
  </body>
</html>