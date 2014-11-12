<?php
//connect to database
$db = new SQLite3('CB_array.sqlite');
if(!$db) die($error); 
//select data
//take mean of probes with the same gene symbol
//$res = $db->query("SELECT *,AVG(Sox9Hi),AVG(CD24),AVG(Fr1),AVG(Duct),AVG(Ngn3),AVG(P0_Gluc),AVG(Adult_Gcg),
//AVG(E15_MIP),AVG(E17_MIP),AVG(P0_MIP),AVG(P15_MIP),AVG(MaleAdult_MIP) FROM cb_sem group by GeneSymbol");
$res = $db->query("SELECT *, Sox9Hi+CD24+Fr1+Duct+Ngn3+P0_Gluc+Adult_Gcg+
E15_MIP+E17_MIP+P0_MIP+P15_MIP+MaleAdult_MIP as sum_cells FROM cb_sem group by GeneSymbol order by sum_cells desc");


$table = array();
$table['cols'] = array(
	array("id"=>"","label"=>"AffyID","pattern"=>"","type"=>"string"),
	array("id"=>"","label"=>"GeneSymbol","pattern"=>"","type"=>"string"),
	array("id"=>"","label"=>"Sox9Hi","pattern"=>"","type"=>"number"),
	array("id"=>"Sox9Hi_sem","label"=>"","pattern"=>"","type"=>"number","role"=>'interval'),
	array("id"=>"","label"=>"CD24","pattern"=>"","type"=>"number"),
	array("id"=>"CD24_sem","label"=>"","pattern"=>"","type"=>"number","role"=>'interval'),
	array("id"=>"","label"=>"Fr1","pattern"=>"","type"=>"number"),
	array("id"=>"Fr1_sem","label"=>"","pattern"=>"","type"=>"number","role"=>'interval'),
	array("id"=>"","label"=>"Duct","pattern"=>"","type"=>"number"),
	array("id"=>"Duct_sem","label"=>"","pattern"=>"","type"=>"number","role"=>'interval'),
	array("id"=>"","label"=>"Ngn3","pattern"=>"","type"=>"number"),
	array("id"=>"Ngn3_sem","label"=>"","pattern"=>"","type"=>"number","role"=>'interval'),
	array("id"=>"","label"=>"P0_Gluc","pattern"=>"","type"=>"number"),
	array("id"=>"P0_Gluc_sem","label"=>"","pattern"=>"","type"=>"number","role"=>'interval'),
	array("id"=>"","label"=>"Adult_Gcg","pattern"=>"","type"=>"number"),
	array("id"=>"Adult_Gcg_sem","label"=>"","pattern"=>"","type"=>"number","role"=>'interval'),
	array("id"=>"","label"=>"E15_MIP","pattern"=>"","type"=>"number"),
	array("id"=>"E15_MIP_sem","label"=>"","pattern"=>"","type"=>"number","role"=>'interval'),
	array("id"=>"","label"=>"E17_MIP","pattern"=>"","type"=>"number"),
	array("id"=>"E17_MIP_sem","label"=>"","pattern"=>"","type"=>"number","role"=>'interval'),
	array("id"=>"","label"=>"P0_MIP","pattern"=>"","type"=>"number"),
	array("id"=>"P0_MIP_sem","label"=>"","pattern"=>"","type"=>"number","role"=>'interval'),
	array("id"=>"","label"=>"P15_MIP","pattern"=>"","type"=>"number"),
	array("id"=>"P15_MIP_sem","label"=>"","pattern"=>"","type"=>"number","role"=>'interval'),
	array("id"=>"","label"=>"MaleAdult_MIP","pattern"=>"","type"=>"number"),
	array("id"=>"MaleAdult_MIP_sem","label"=>"","pattern"=>"","type"=>"number","role"=>'interval'),
	array("id"=>"foo_sem","label"=>"","pattern"=>"","type"=>"number","role"=>'interval')
	);
	
	
$rows = array();

while($r =$res->fetchArray(SQLITE3_ASSOC)) {
    $temp = array();
	// each column needs to have data inserted via the $temp array
	$temp[] = array('v' => $r['AffyID']);
	$temp[] = array('v' => $r['GeneSymbol']);
	$temp[] = array('v' => (float) $r['Sox9Hi']); // typecast all numbers to the appropriate type (int or float) as needed - otherwise they are input as strings
	$temp[] = array('v' => (float) $r['Sox9Hi_sem']);
	$temp[] = array('v' => (float) $r['CD24']);
	$temp[] = array('v' => (float) $r['CD24_sem']);
	$temp[] = array('v' => (float) $r['Fr1']);
	$temp[] = array('v' => (float) $r['Fr1_sem']);
	$temp[] = array('v' => (float) $r['Duct']);
	$temp[] = array('v' => (float) $r['Duct_sem']);
	$temp[] = array('v' => (float) $r['Ngn3']);
	$temp[] = array('v' => (float) $r['Ngn3_sem']);
	$temp[] = array('v' => (float) $r['P0_Gluc']);
	$temp[] = array('v' => (float) $r['P0_Gluc_sem']);
	$temp[] = array('v' => (float) $r['Adult_Gcg']);
	$temp[] = array('v' => (float) $r['Adult_Gcg_sem']);
	$temp[] = array('v' => (float) $r['E15_MIP']);
	$temp[] = array('v' => (float) $r['E15_MIP_sem']);
	$temp[] = array('v' => (float) $r['E17_MIP']);
	$temp[] = array('v' => (float) $r['E17_MIP_sem']);
	$temp[] = array('v' => (float) $r['P0_MIP']);
	$temp[] = array('v' => (float) $r['P0_MIP_sem']);
	$temp[] = array('v' => (float) $r['P15_MIP']);
	$temp[] = array('v' => (float) $r['P15_MIP_sem']);
	$temp[] = array('v' => (float) $r['MaleAdult_MIP']);
	$temp[] = array('v' => (float) $r['MaleAdult_MIP_sem']);
	$temp[] = array('v' => (float) $r['foo_sem']);
	
	// insert the temp array into $rows
    $rows[] = array('c' => $temp);
}

// populate the table with rows of data
$table['rows'] = $rows;

// encode the table as JSON
$jsonTable = json_encode($table);

// set up header; first two prevent IE from caching queries
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');

// return the JSON data
echo $jsonTable;
?>
