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


/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

