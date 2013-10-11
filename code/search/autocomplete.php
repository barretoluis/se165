<?php
// if the 'term' variable is not sent with the request, exit
if ( !isset($_REQUEST['term']) )
	exit;
 
$dblink = mysql_connect('localhost', 'tackster', '4tackster2use') or die( mysql_error() );
mysql_select_db('db_tackster');
 
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