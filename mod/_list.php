<?php

if(!defined('__KIMS__')) exit;
$bbsque0 = 'site='.$s;
$bbsque1 = 'site='.$s.' and notice=1';
$bbsque2 = 'site='.$s.' and notice=0';

if ($B['uid'])
{
	$bbsque0 .= ' and bbs='.$B['uid'];
	$bbsque1 .= ' and bbs='.$B['uid'];
	$bbsque2 .= ' and bbs='.$B['uid'];
}

$RCD = array();
$NCD = array();

$NTC = getDbArray($table[$m.'idx'],$bbsque1,'gid','gid',$orderby,0,0);
while($_R = db_fetch_array($NTC)) $NCD[] = getDbData($table[$m.'data'],'gid='.$_R['gid'],'*');
if ($sort == 'gid' && !$keyword && !$cat)

{
	  // 공회 게시판인 경우 && 회원이 접근하는 경우 회원이 정한 활동지역으로 초기 카테고리 세팅 2015. 2. 25
	  $qry=$_SERVER["QUERY_STRING"];
	  $qry_arr=explode('&',$qry);
	  $qry_n=count($qry_arr);  
	  if($c=='organization/44' && $my['uid'] && $qry_n==2){
	     $addfd=$my['addfield']; // 추가필드 값
	     $addf_arr=explode('|',$addfd);
	     $addf0=$addf_arr[0];
	     $add_arr=explode('^^^',$addf0); // 첫번째 추가필드 - 활동지역값 배열 
	     $act_area=$add_arr[1];
	     $cat=$act_area; // 회원이 설정한 활동지역을 공회 게시판 카테고리와 동기화
	     $bbsque2 .= " and category='".$cat."'";

		$NUM = getDbRows($table[$m.'data'],$bbsque2);
		$TCD = getDbArray($table[$m.'data'],$bbsque2,'*',$sort,$orderby,$recnum,$p);
		while($_R = db_fetch_array($TCD)) $RCD[] = $_R;
		// 공회 게시판인 경우 && 회원이 접근하는 경우 회원이 정한 활동지역으로 초기 카테고리 세팅 2015. 2. 25
	  
	  }else{
	  	  $NUM = getDbCnt($table[$m.'month'],'sum(num)',$bbsque0)-count($NCD);
	     $TCD = getDbArray($table[$m.'idx'],$bbsque2,'gid',$sort,$orderby,$recnum,$p);
		  while($_R = db_fetch_array($TCD)) $RCD[] = getDbData($table[$m.'data'],'gid='.$_R['gid'],'*');
	  } 
}

else {
 
	if($cat) $bbsque2 .= " and category='".$cat."'";
	if ($where && $keyword)
	{
		if (strpos('[name][nic][id][ip]',$where)) $bbsque2 .= " and ".$where."='".$keyword."'";
		else if ($where == 'term') $bbsque2 .= " and d_regis like '".$keyword."%'";
		else $bbsque2 .= getSearchSql($where,$keyword,$ikeyword,'or');
	}
	$NUM = getDbRows($table[$m.'data'],$bbsque2);
	$TCD = getDbArray($table[$m.'data'],$bbsque2,'*',$sort,$orderby,$recnum,$p);
	while($_R = db_fetch_array($TCD)) $RCD[] = $_R;
}

$TPG = getTotalPage($NUM,$recnum);

?>

