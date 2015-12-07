<?php
/*
Plugin Name: 冗余数据清理
Version: 1.0
Plugin URL: http://www.stus8.com/forum.php?mod=viewthread&tid=6753
Description: 清除数据库中由于不正常操作造成的的冗余数据
Author: FYY
Author Email:fyy@l19l.com
Author URL: http://fyy.l19l.com
For: V3.8+
*/
if (!defined('SYSTEM_ROOT')) { die('FUCK!'); } 

function fyy_clean_tool() {
	?>
		<br/><br/><input type="button" onclick="location = '<?php echo SYSTEM_URL ?>index.php?pri_plugin=fyy_clean&1'" class="btn btn-primary" value="冗余数据清理（1）" style="width:170px">&nbsp;&nbsp;&nbsp;&nbsp;清除无对应绑定信息的贴吧信息
		<br/><br/><input type="button" onclick="location = '<?php echo SYSTEM_URL ?>index.php?pri_plugin=fyy_clean&2'" class="btn btn-primary" value="冗余数据清理（2）" style="width:170px">&nbsp;&nbsp;&nbsp;&nbsp;清除无对应用户信息的绑定信息和贴吧信息
	<?php
}

addAction('admin_tools_3','fyy_clean_tool');/*工具箱*/