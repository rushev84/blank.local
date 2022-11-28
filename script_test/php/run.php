<?
require_once 'MyGenerator.php';

$generator = new MyGenerator();

$iblocks = $generator->getIblocks();

$properties = $generator->getProperties(283);
//$fields = $generator->getFields(38);
//$generator->getFields(38);

//echo '<pre>'; print_r( $iblocks ); echo'</pre>';
//echo '<pre>'; print_r( $fields ); echo'</pre>';
//echo '<pre>'; print_r( $properties ); echo'</pre>';

//$fields = $generator->getFields(57);



