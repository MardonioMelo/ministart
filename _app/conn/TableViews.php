<?php


namespace App\Conn;

use CoffeeCode\DataLayer\DataLayer;

/**
 * Class TableSiteViews
 * @package App\Models
 */
class TableViews extends DataLayer
{

    /**
     * Crud constructor.
     */
    public function __construct()
    {
       parent::__construct(
           "sm_views",
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