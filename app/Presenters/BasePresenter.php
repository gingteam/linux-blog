<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Components\BreadCrumbControl;
use Nette;
use Nette\Database\Explorer;

class BasePresenter extends Nette\Application\UI\Presenter
{
    protected $title = 'Linux Blog';

    /** @var Explorer */
    protected $database;

    public function __construct()
    {
        parent::__construct();
        $this->absoluteUrls = true;
    }

    public function injectDatabase(Explorer $database)
    {
        $this->database = $database;
    }

    protected function afterRender()
    {
        $this->template->title = $this->title;
        parent::afterRender();
    }

    protected function createComponentBreadCrumb()
    {
        $breadcrumb = new BreadCrumbControl();

        return $breadcrumb;
    }
}
