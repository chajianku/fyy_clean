<?php
if (!defined('SYSTEM_ROOT')) { die('FUCK!'); } 
loadhead();
global $m,$i;
if(isset($_GET['1'])){//清除无对应绑定信息的贴吧信息
	$cl = 0;
	if(empty($_REQUEST['t'])){
		$tables = $i['table'];
	}
	else{
		$tables = array('0' => $_REQUEST['t']);
	}
	foreach($tables as $key=>$table){
		$pids=$m->query("SELECT DISTINCT `pid` FROM `".DB_NAME."`.`".DB_PREFIX."{$table}`");
		while($pid = $m->fetch_array($pids)) {
			$pid = $pid['pid'];
			$thispid = $m->once_fetch_array("SELECT * FROM  `".DB_NAME."`.`".DB_PREFIX."baiduid` WHERE `id` = '{$pid}'");
			if(empty($thispid)){
				$c = $m->once_fetch_array("SELECT COUNT(*) AS `c` FROM `".DB_PREFIX."{$table}` WHERE `pid` = '{$pid}'");
				$cl = $cl + $c['c'];
				$m->query("DELETE FROM `".DB_NAME."`.`".DB_PREFIX."{$table}` WHERE `pid` = '{$pid}'");
			}
		}
	}
	if(!empty($cl)){
		if(!empty($_REQUEST['t'])){
			$_REQUEST['t'] = " {$_REQUEST['t']} 数据表中的";
		}
		echo '</br><div class="alert alert-success">为您删除了'.$_REQUEST['t'].$cl.'条贴吧信息</div>';
	}
	else{
		if(empty($_REQUEST['t'])){ echo '</br><div class="alert alert-success">看样子您的数据库很干净~</div>'; }
		else { echo "</br><div class='alert alert-success'>看样子您的 {$_REQUEST['t']} 数据表很干净~</div>"; }
	}
	
	?>
		<h4>接下来您可以：</h4>
		<br/><input type="button" onclick="location = '<?php echo SYSTEM_URL ?>index.php?pri_plugin=fyy_clean&2'" class="btn btn-primary" value="冗余数据清理（2）" style="width:170px">&nbsp;&nbsp;&nbsp;&nbsp;清除无对应用户信息的绑定信息和贴吧信息
	<?php
		$pluginfo = getPluginData('fyy_clean/fyy_clean.php');
		echo '<br/><br/><br/><br/><br/>'.$pluginfo['Name'].' V'.$pluginfo['Version'].' // 插件作者：<a href="'.$pluginfo['AuthorUrl'].'" target="_blank">'.$pluginfo['Author'].'</a><br/>'.SYSTEM_FN.' V'.SYSTEM_VER.' // 程序作者: <a href="http://zhizhe8.net" target="_blank">无名智者</a> &amp; <a href="http://www.longtings.com/" target="_blank">mokeyjay</a>';
	die;
}
elseif(isset($_GET['2'])){//清除无对应用户信息的绑定信息和贴吧信息(其实主要是绑定信息)
	$cl1 = 0;
	$cl2 = 0;
	$uids = $m->query("SELECT DISTINCT `uid` FROM `".DB_NAME."`.`".DB_PREFIX."baiduid`");
	while($uid = $m->fetch_array($uids)) {
		$uid = $uid['uid'];
		$thisuid = $m->once_fetch_array("SELECT * FROM  `".DB_NAME."`.`".DB_PREFIX."users` WHERE `id` = '{$uid}'");
		if(empty($thisuid)){
			$c1 = $m->once_fetch_array("SELECT COUNT(*) AS `c` FROM `".DB_PREFIX."baiduid` WHERE `uid` = '{$uid}'");
			$m->query("DELETE FROM `".DB_NAME."`.`".DB_PREFIX."baiduid` WHERE `uid` = '{$uid}'");
			$cl1 = $cl1 + $c1['c'];
			//蛋疼的找表。。
			foreach($i['table'] as $key=>$table){
				$c2 = $m->once_fetch_array("SELECT COUNT(*) AS `c` FROM `".DB_PREFIX."{$table}` WHERE `uid` = '{$uid}'");
				if(!empty($c2)){
					break;
				}
			}
			$cl2 = $cl2 + $c2['c'];
			$m->query("DELETE FROM `".DB_NAME."`.`".DB_PREFIX."{$table}` WHERE `uid` = '{$uid}'");
		}
	}
	if(!empty($cl1) || !empty($cl2)){
		echo "</br><div class='alert alert-success'>为您删除了{$cl1}条绑定信息 和 {$cl2}条贴吧信息</div>";
	}
	else{
		echo '</br><div class="alert alert-success">看样子您的数据库很干净~</div>';
	}
	
	?>
		<h4>接下来您可以：</h4>
		<br/><input type="button" onclick="location = '<?php echo SYSTEM_URL ?>index.php?pri_plugin=fyy_clean&1'" class="btn btn-primary" value="冗余数据清理（1）" style="width:170px">&nbsp;&nbsp;&nbsp;&nbsp;清除无对应绑定信息的贴吧信息
	<?php
		$pluginfo = getPluginData('fyy_clean/fyy_clean.php');
		echo '<br/><br/><br/><br/><br/>'.$pluginfo['Name'].' V'.$pluginfo['Version'].' // 插件作者：<a href="'.$pluginfo['AuthorUrl'].'" target="_blank">'.$pluginfo['Author'].'</a><br/>'.SYSTEM_FN.' V'.SYSTEM_VER.' // 程序作者: <a href="http://zhizhe8.net" target="_blank">无名智者</a> &amp; <a href="http://www.longtings.com/" target="_blank">mokeyjay</a>';
	die;
}
else{ die('Undefined operation,you must give some fucking parameters'); }
