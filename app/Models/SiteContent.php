<?php

namespace Dowedo\Models;

class SiteContent extends \Dowedo\Core\Mvc\Model
{
    protected $id;

    public function getSource()
    {
        return 'site_contents';
    }
}