<?php
function topMenu($dbConn,$event,$quest,$stick) {
  global $catMap;
  $sql = "select trim(question) as qst, max_points as weight,category,filepath \n"
    ."from assessment_questions where event ='{$event}' order by question";
  $resultSet = $dbConn->Execute( $sql );
  if ( $resultSet === null ) {
    die( 'query failed with ' . $dbConn->ErrorMsg() );
  }
  $out = '';
  while ( !$resultSet->EOF ) {
    extract( $resultSet->fields );
    if ($qst==$quest) {
      $css="class='quest selected'";
    } else {
      $css="class='quest'";
    }
    $snip=$_SESSION['snippets'];
#    $linkText= "{$catMap[$category]}".str_replace('TASK_','',$qst);
    $linkText= str_replace('TASK_','',$qst);
    $out .="<li {$css}><a href='cwb.php?quest={$qst}&stick_event_repo_id={$stick}&snippets={$snip}'>{$linkText}</a><sup style='font-size:80%'>{$weight}</sup></li>\n";
    $resultSet->moveNext();
  }
  return $out;
}

$out= topMenu($dbConn,$event,$quest,$stick_event_repo_id);

?>
<ul>
    
    <?= $out?>
</ul>
