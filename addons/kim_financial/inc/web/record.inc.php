<?php
/**
 * 会员财务中心
 *
 * 作者:Kim
 * 模块定制QQ: 800083075
 * 后台体验地址: http://www.012wz.com
 */
defined('IN_IA') or exit('Access Denied');
global $_W,$_GPC;
checklogin();
$_W['page']['title'] = "消费记录";
$ops = array("record","cz");
$op = in_array($_GPC["op"], $ops) ? $_GPC["op"] : "record";
if("record" == $op) {
    $type = $_GPC["type"];
    $types = array("credit1","credit2");
    if(in_array($type,$types)) {
        list($list,$pager) = getAllRecords("users_credits_record",array("credittype"=>array("op"=>"=","val"=>$type),"num"=>array("op"=>">","val"=>0)));
    }else{
        list($list,$pager) = getAllRecords("users_credits_record");
    }
}elseif("cz" == $op) {
    $index = max(1, intval($_GPC['page']));
    $size = 15;
    $page = ($index - 1) * $size;
    $list = pdo_fetchall("SELECT * FROM ".tablename("uni_payorder")." WHERE uid=:uid ORDER BY order_time DESC LIMIT $page,$size",array(":uid"=>$_W["uid"]));
    $total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename("uni_payorder")." WHERE uid=:uid", array(":uid"=>$_W["uid"]));
    $pager = pagination($total, $index, $size);
}
include $this->template('financial_record');