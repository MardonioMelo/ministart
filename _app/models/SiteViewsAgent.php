<?php


namespace App\Models;

use CoffeeCode\DataLayer\DataLayer;

/**
 * Class SiteViewsAgent
 * @package App\Models
 */
class SiteViewsAgent extends DataLayer
{

    /**
     * Crud constructor.
     */
    public function __construct()
    {
       parent::__construct(
           "sm_siteviews_agent",
           [
               "agent_name",
               "agent_views"
           ],
           "siteviews_id",
           false);
    }

}