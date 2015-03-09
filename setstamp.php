<?php
header('Content-type: application/json');
require_once 'google/appengine/api/log/LogService.php';
use google\appengine\api\log\LogService;

syslog(LOG_INFO, 'get datasync list '.date('Y-m-d H:i:s'));

    $DATASYNCID = file_get_contents('php://input','terima');
    mysql_connect(':/cloudsql/database-sm:database-sm', 'root', '')
      or die("MYSQLDIE Unable to connect to MySQL");
    mysql_select_db('IOTEST');

		 
    $sql = "UPDATE IOTEST.DATASYNC SET LASTCHANGE = $LASTCHANGE";		
		//  WHERE  DATASYNC.DATASYNC_ID =  '$DATASYNCID' ";			
		
	 $sth = mysql_query($sql) or die('SQLDIE');
echo('OK');

?>