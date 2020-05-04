<?php


namespace App\Models;

use CoffeeCode\DataLayer\DataLayer;

/**
 * Class SiteViewsOnline
 * @package App\Models
 */
class SiteViewsOnline extends DataLayer
{

    /**
     * Crud constructor.
     */
    public function __construct()
    {
       parent::__construct(
           "sm_siteviews_online",
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