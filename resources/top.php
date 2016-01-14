<?php
function topMenu($dbConn,$event,$quest,$stick) {
  $sql = "select trim(question) as qst, max_points as weight,filepath from assessment_questions where event ='{$event}' order by question";
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
    $out .="<li {$css}><a href='cwb.php?quest={$qst}&stick_event_repo_id={$stick}&snippets={$snip}'>{$qst}</a></li>\n";
    $resultSet->moveNext();
  }
  return $out;
}

$out= topMenu($dbConn,$event,$quest,$stick_event_repo_id);

?>
<ul>
    <li><strong>Scoring event <?= $event ?> question <?=$quest?></strong></li>
    <?= $out?>
  <li ><strong><a href='results.php'>results</a> </strong> oper=<?=$_SESSION['operator']?></li>
</ul>