<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Components\BreadCrumbControl;
use Nette;
use Nette\Database\Explorer;

class BasePresenter extends Nette\Application\UI\Presenter
{
    protected $title = 'Linux Blog';

    protected $database;

    public function __construct(Explorer $database)
    {
        $this->absoluteUrls = true;
        $this->database = $database;
    }

    protected function afterRender()
    {
        $this->template->title = $this->title;
    }

    protected function createComponentBreadCrumb()
    {
        $breadcrumb = new BreadCrumbControl();

        return $breadcrumb;
    }
}
