<?php
/**
 * 女神来了模块定义
 *
 * @author 微赞科技
 * @url http://bbs.012wz.com/
 */
defined('IN_IA') or exit('Access Denied');
		$reply = pdo_fetch("select * from ".tablename($this->table_reply)." where rid = :rid", array(':rid' => $rid));
		$rdisplay = pdo_fetch("select * from ".tablename($this->table_reply_display)." where rid = :rid", array(':rid' => $rid));
        if (empty($reply)) {
            $this->webmessage('抱歉，要修改的活动不存在或是已经被删除！');
        }
		
		
        foreach ($_GPC['idArr'] as $k => $id) {
			
			
            $id = intval($id);
			
			
            if ($id == 0)
                continue;
			 
			$fans = pdo_fetch("select from_user,photosnum,xnphotosnum,hits,xnhits from ".tablename($this->table_users)." where id = :id", array(':id' => $id));
           
			
			if (empty($fans)) {
                $this->webmessage('抱歉，选中的粉丝数据不存在！');
            }
			
			//删除粉丝参与记录
			pdo_delete($this->table_users, array('id' => $id));
			pdo_delete($this->table_users_picarr, array('from_user' => $fans['from_user'], 'rid' => $rid));
			pdo_delete($this->table_users_voice, array('from_user' => $fans['from_user'], 'rid' => $rid));
			pdo_delete($this->table_users_name, array('from_user' => $fans['from_user'], 'rid' => $rid));
			pdo_delete($this->table_log, array('from_user' => $fans['from_user'], 'rid' => $rid));
			pdo_delete($this->table_log, array('tfrom_user' => $fans['from_user'], 'rid' => $rid));
			pdo_delete($this->table_bbsreply, array('from_user' => $fans['from_user'], 'rid' => $rid));
			pdo_delete($this->table_data, array('from_user' => $fans['from_user'], 'rid' => $rid));
			pdo_delete($this->table_order, array('from_user' => $fans['from_user'], 'rid' => $rid));
			$date = array(
				'ljtp_total' => $rdisplay['ljtp_total']-$fans['photosnum'],
				'xunips' => $rdisplay['xunips']-$fans['xnphotosnum'],
				'cyrs_total' => $rdisplay['cyrs_total']-$fans['hits'],
				'xuninum' => $rdisplay['xuninum']-$fans['xnhits'],
				'csrs_total' => $rdisplay['csrs_total']-1,
			);
			pdo_update($this->table_reply_display,$date, array('rid' => $rid));
			
        }
        $this->webmessage('粉丝记录删除成功！', '', 0);
    