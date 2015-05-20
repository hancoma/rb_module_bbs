<?php
if(!defined('__KIMS__')) exit;
checkAdmin(0);

$U = getUidData($table[$m.'upload'],$uid);
if ($U['uid'])
{
	getDbUpdate($table['s_numinfo'],'upload=upload-1',"date='".substr($U['d_regis'],0,8)."' and site=".$U['site']);
	getDbDelete($table[$m.'upload'],'uid='.$U['uid']);
	if ($U['url']==$d['mediaset']['ftp_urlpath'])
	{
		$FTP_CONNECT = ftp_connect($d['mediaset']['ftp_host'],$d['mediaset']['ftp_port']); 
		$FTP_CRESULT = ftp_login($FTP_CONNECT,$d['mediaset']['ftp_user'],$d['mediaset']['ftp_pass']); 
		if (!$FTP_CONNECT) getLink('','','FTP서버 연결에 문제가 발생했습니다.','');
		if (!$FTP_CRESULT) getLink('','','FTP서버 아이디나 패스워드가 일치하지 않습니다.','');
		if($d['mediaset']['ftp_pasv']) ftp_pasv($FTP_CONNECT, true);
		ftp_delete($FTP_CONNECT,$d['mediaset']['ftp_folder'].$U['folder'].'/'.$U['tmpname']);
		if($U['type']==2) ftp_delete($FTP_CONNECT,$d['mediaset']['ftp_folder'].$U['folder'].'/'.$U['thumbname']);
		ftp_close($FTP_CONNECT);
	}
	else {
		unlink('./modules/bbs/upload/'.$U['folder'].'/'.$U['tmpname']);
		if($U['type']==2) unlink('./modules/bbs/upload/'.$U['folder'].'/'.$U['thumbname']);
	}
}
getLink('reload','parent.','','');
?>