<?php

declare(strict_types=1);

namespace App\Components;

use Nette\Application\UI\Control;

class BreadCrumbControl extends Control
{
    private $breadcrumbs = [];

    public function add(string $title, string $link = '#')
    {
        $breadcrumb = new \stdClass();
        $breadcrumb->title = $title;
        $breadcrumb->link = $link;

        $this->breadcrumbs[] = $breadcrumb;

        return $this;
    }

    public function render()
    {
        $this->template->breadcrumbs = $this->breadcrumbs;
        $this->template->render(__DIR__.'/breadcrumb.latte');
    }
}
