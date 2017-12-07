<?php

namespace App\Admin\Extensions\Tools;

use Encore\Admin\Grid\Tools\AbstractTool;

class AllTopics extends AbstractTool
{

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        return '<button type="button" class="btn btn-sm btn-default">Action</button>';
    }
}