<?php


namespace App\Models;

use CoffeeCode\DataLayer\DataLayer;

/**
 * Class SiteViews
 * @package App\Models
 */
class SiteViews extends DataLayer
{

    /**
     * Crud constructor.
     */
    public function __construct()
    {
       parent::__construct(
           "sm_siteviews",
           [
               "siteviews_date",
               "siteviews_users",
               "siteviews_views",
               "siteviews_pages"
           ],
           "siteviews_id",
           false);
    }

}