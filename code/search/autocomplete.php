<?php
//TODO: This PHP page needs to implement the template. To be fixed later. Ask Jerry if any questions.
require_once 'Configs/defineDb.php';

// if the 'term' variable is not sent with the request, exit
if ( !isset($_REQUEST['term']) )
	exit;

$dblink = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die( mysql_error() );
mysql_select_db(DB_NAME);

$rs = mysql_query('SELECT keyword from lkup_keyword where keyword like "'. mysql_real_escape_string($_REQUEST['term']) .'%" order by keyword asc limit 0,10', $dblink);

// loop through each keyword returned and format the response for jQuery
$data = array();
if ( $rs && mysql_num_rows($rs) )
{
	while( $row = mysql_fetch_array($rs, MYSQL_ASSOC) )
	{
		$data[] = array(
			'label' => $row['keyword'],
			'value' => $row['keyword']
		);
	}
}

// jQuery wants JSON data
echo json_encode($data);
flush();
?>