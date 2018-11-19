<?php
if(!defined('InEmpireBak'))
{
	exit();
}
$onclickword='(???????????)';
$change=(int)$_GET['change'];
if($change==1)
{
	$onclickword='(??????)';
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>?????????????</title>
<link href="images/css.css" rel="stylesheet" type="text/css">
<script>
function ChangeSet(filename)
{
	var ok=confirm("?????????");
	if(ok)
	{
		opener.parent.ebakmain.location.href='ChangeTable.php?mydbname=<?=$mydbname?>&savefilename='+filename;
		window.close();
	}
}
</script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td>λ???<a href="ListSetbak.php">??????????</a>&nbsp;(???????<b>setsave</b>)</td>
  </tr>
</table>
<br>
<table width="500" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr bgcolor="#0472BC"> 
    <td width="63%" height="25" bgcolor="#0472BC"> <div align="center"><strong><font color="#FFFFFF">?????????????<?=$onclickword?></font></strong></div></td>
    <td width="37%"><div align="center"><font color="#FFFFFF">????</font></div></td>
  </tr>
  <?php
  while($file=@readdir($hand))
  {
  	if($file!="."&&$file!=".."&&is_file("setsave/".$file))
	{
		if($change==1)
		{
			$showfile="<a href='#ebak' onclick=\"javascript:ChangeSet('$file');\" title='$file'>$file</a>";
		}
		else
		{
			$showfile="<a href='phome.php?phome=SetGotoBak&savename=$file' title='$file'>$file</a>";
		}
		//???????
		if($file=='def')
		{
			if(empty($change))
			{
				$showfile=$file;
			}
			$showdel="<b>???????</b>";
		}
		else
		{
			$showdel="<a href=\"phome.php?phome=DoDelSave&mydbname=$mydbname&change=$change&savename=$file\" onclick=\"return confirm('?????????');\">???????</a>";
		}
	}
}
  ?>
  <tr bgcolor="#DBEAF5"> 
    <td height="25"> <div align="left"><img src="images/txt.gif" width="19" height="16">&nbsp; 
        <?=$showfile?> </div></td>
    <td><div align="center">&nbsp;[<?=$showdel?>]</div></td>
  </tr>
  <tr> 
    <td height="25" colspan="2">&nbsp;</td>
  </tr>
</table>
</body>
</html>