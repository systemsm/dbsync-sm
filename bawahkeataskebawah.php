<?php
	header('Content-type: application/json');
	require_once 'google/appengine/api/log/LogService.php';
	use google\appengine\api\log\LogService;
	
	syslog(LOG_INFO, 'earth 2 cloud 2 earth start '.date('Y-m-d H:i:s'));
	
	$DATASYNCID = file_get_contents('php://input','terima');
	mysql_connect(':/cloudsql/database-sm:database-sm', 'root', '')
	or die("MYSQLDIE Unable to connect to MySQL");
	mysql_select_db('IOTEST');
	
	
	
	$sql = "SELECT * FROM IOTEST.DATASYNC  ".
	"WHERE  DATASYNC.DATASYNC_ID = '$DATASYNCID' ";			
	//  AND  IOTEST.DATASYNC.LASTCHANGE < IOTEST.DATASYNC.LASTSYNC ";
	
	$sth = mysql_query($sql) or die(mysql_error());
	$row2 = array();
	while($r = mysql_fetch_assoc($sth)) {
		foreach($r as $synckey => $syncval) {
			$row2[$synckey] = str_replace('\\', '#', $syncval);
		}
	}
	
	// => loop for every IOTEST.DATASYNC record
	// => DATASYNC_ID
	
	$output['Datasync'] = $row2;
	
	$listfield = explode(',',$row2['DAFTARFIELD']);
	$fieldid = $row2['NAMAFIELDID'];
	
	$sql2 = $row2['SQLSELECT'];
	$sqltext1 = $row2['SQLUPDATE'];
	$row2 = '';
	$res2 = mysql_query( $sql2) or die(mysql_error());
	while($r2 = mysql_fetch_assoc($res2)) {
		$row2[] = $r2;
	}
	
	foreach($row2 as $dkey => $xval){
		$sqltext3 = array('');
		foreach($xval as $kunci => $nilai){
			if (( $nilai !== '') && ( !empty($nilai))) {
				$sqltext3[] = "'".trim($nilai)."'";
				} else {
				$sqltext3[] = "NULL";
			}
		}
		$sqltext4 = implode(',',$sqltext3);
		$sqltext4 = substr($sqltext4,1);
		$allsqltext[] = $sqltext1.$sqltext4.') MATCHING ('.$fieldid.')';
	}
	
	$updatesql = implode(';',$allsqltext);
	$output['Data'] = $updatesql;
	
	$jsonout = json_encode($output);
	echo($jsonout);
	
?>