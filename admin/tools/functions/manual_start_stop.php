<body style="background-color: black; color: white;">
  <?php
  $act=$_GET['action'];
  if($act=='1'){
      system("/var/www/html/blind.sh");
  }elseif ($act=='0') {
      system("/var/www/html/blind.sh e");
  }

  
  ?>  
</body>


