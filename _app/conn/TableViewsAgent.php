<?php


namespace App\Conn;

use CoffeeCode\DataLayer\DataLayer;

/**
 * Class TableSiteViewsAgent
 * @package App\Models
 */
class TableViewsAgent extends DataLayer
{

    /**
     * Crud constructor.
     */
    public function __construct()
    {
       parent::__construct(
           "sm_views_agent",
           [
               "agent_name",
               "agent_views"
           ],
           "siteviews_id",
           false);
    }

}