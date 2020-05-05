<?php


namespace App\Conn;

use CoffeeCode\DataLayer\DataLayer;

/**
 * Class TableSiteViewsOnline
 * @package App\Models
 */
class TableViewsOnline extends DataLayer
{

    /**
     * Crud constructor.
     */
    public function __construct()
    {
       parent::__construct(
           "sm_views_online",
           [
               "online_session",
               "online_startview",
               "online_endview",
               "online_ip",
               "online_url",
               "online_agent",
               "online_name"
           ],
           "siteviews_id",
           false);
    }

}