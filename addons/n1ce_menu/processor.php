<?php
/**
 * 个性化菜单模块处理程序
 *
 * @author n1ce   QQ：541535641
 * @url http://www.012wz.com/
 */
defined('IN_IA') or exit('Access Denied');

class N1ce_menuModuleProcessor extends WeModuleProcessor {
	public function respond() {
		$content = $this->message['content'];
		//这里定义此模块进行消息处理时的具体过程, 请查看微赞文档来编写你的代码
	}
}