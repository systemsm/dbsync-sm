<?php
header('Content-type: application/json');
require_once 'google/appengine/api/log/LogService.php';
use google\appengine\api\log\LogService;

syslog(LOG_INFO, 'get datasync list '.date('Y-m-d H:i:s'));

    $DATASYNCID = file_get_contents('php://input','terima');
    mysql_connect(':/cloudsql/database-sm:database-sm', 'root', '')
      or die("MYSQLDIE Unable to connect to MySQL");
    mysql_select_db('IOTEST');

    $sql = "SELECT DATASYNC_ID FROM IOTEST.DATASYNC";		
		//  WHERE  DATASYNC.DATASYNC_ID = '$DATASYNCID' ";			
		 //  AND  IOTEST.DATASYNC.LASTCHANGE < IOTEST.DATASYNC.LASTSYNC ";

	 $sth = mysql_query($sql) or die(mysql_error());
		$row2 = array();	
		$row2 = '';
    while($r2 = mysql_fetch_array($sth)) {
        $row2[] = $r2['DATASYNC_ID'];
    }

//		print_r($row2);
		
//  $output['Datasync'] = $row2;
//  $jsonout = json_encode($row2);
  $jsonout = implode(';',$row2);
echo($jsonout);

?>