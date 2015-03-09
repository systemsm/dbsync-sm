<?PHP
	date_default_timezone_set('Asia/Bangkok');
	require_once 'google/appengine/api/mail/Message.php';
	require_once 'google/appengine/api/log/LogService.php';

	use google\appengine\api\log\LogService;
	use google\appengine\api\mail\Message;

	syslog(LOG_INFO, ' test start '.date('Y-m-d H:i:s'));

	$json = stripcslashes($_POST['json']);
	$data = json_decode($json,true);

	$stores = $data['Data'];

$values=array();
$i = 0;
foreach($stores as $store){
    $line="(";
    foreach($store as $key => $value){
        $line = $line. "'". $value . "',";
    }
    $line = substr($line, 0, strlen($line)-1).")";
    $values[$i] = $line;
    ++$i;
}
$values = implode(",", $values);
mysql_connect(':/cloudsql/database-sm:database-sm', 'root', '') or die("MYSQLDIE Unable to connect to MySQL");
mysql_select_db('SIMIS');
$replacesql = $data['REPLACESQL'];
if (count($stores) !== 0 ) {
mysql_query("START TRANSACTION;");
$db_insert = mysql_query("$replacesql $values;");
mysql_query("COMMIT;");
 if (!$db_insert) { die('MYSQLDIE Could not connect - event insert failed: ' . mysql_error()); }
}
	syslog(LOG_INFO, ' kirim '.$values);
	syslog(LOG_INFO, ' test end '.date('Y-m-d H:i:s'));
	echo __line__ ." selesai <br />".date('Y-m-d H:i:s');
?>
