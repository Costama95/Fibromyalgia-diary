<?php
session_start(); 
// Connect to MySQL

$link = new mysqli( 'mysql.metropolia.fi', 'jonathac', 'Jonathan1995', 'jonathac' );

if ( $link->connect_errno ) {
  die( "Failed to connect to MySQL: (" . $link->connect_errno . ") " . $link->connect_error );
}

// Fetch the data
$query = "
SELECT  timestamp, level, comment 
FROM diaryentry  
WHERE userId = {$_SESSION["id"]} AND type = '$type'
ORDER BY timestamp";
$result = $link->query( $query );

// All good?
if ( !$result ) {
  // Nope
  $message  = 'Invalid query: ' . $link->error . "n";
  $message .= 'Whole query: ' . $query;
  die( $message );
}

// Set proper HTTP response headers
//header( 'Content-Type: application/json' );

// Print out rows
$data = array();
while ( $row = $result->fetch_assoc() ) {
    /*if($data[$row['timestamp']] === null) { 
        $data[$row['timestamp']] = array();
    }
    //$data[$row['timestamp']]['level_'.$row['type']]=$row['level'];
    //$data[$row['timestamp']]['type']=$row['type'];
    //$data[$row['timestamp']]['comment_'.$row['type']]=$row['comment'];
  */
    $data[] = $row;
}
$out = json_encode( $data );
// Close the connection
//mysqli_close($link);
