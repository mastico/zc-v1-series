<?php
/**
 * zcDashboardWidgetOrderSummary Class.
 *
 * @package classes
 * @copyright Copyright 2003-2012 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version GIT: $Id: Author: Ian Wilson  Fri Aug 17 17:42:37 2012 +0100 New in v1.5.1 $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}
/**
 * zcDashboardWidgetOrderSummary Class
 *
 * @package classes
 */
class zcDashboardWidgetOrderSummary extends zcDashboardWidgetBase
{
  public function prepareContent()
  {
    global $db;
    $tplVars = array();
    $orders_status = $db->Execute("select orders_status_name, orders_status_id from " . TABLE_ORDERS_STATUS . " where language_id = '" . $_SESSION['languages_id'] . "'");

    while (!$orders_status->EOF)
    {
      $orders_pending = $db->Execute("select count(*) as count from " . TABLE_ORDERS . " where orders_status = '" . $orders_status->fields['orders_status_id'] . "'");

      $tplVars['content'][] = array('text'=> '<a href="' . zen_href_link(FILENAME_ORDERS, 'selected_box=customers&status=' . $orders_status->fields['orders_status_id'], 'NONSSL') . '">' . $orders_status->fields['orders_status_name'] . '</a>', 'value'=>$orders_pending->fields['count']);
      $orders_status->MoveNext();
    }
    return $tplVars;
  }
}