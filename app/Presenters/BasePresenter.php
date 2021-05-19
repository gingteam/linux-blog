<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Components\BreadCrumbControl;
use Nette;
use Nette\Database\Explorer;

class BasePresenter extends Nette\Application\UI\Presenter
{
    protected $title = 'Linux Blog';

    /** @var Explorer @inject */
    public $database;

    /** @var BreadCrumbControl @inject */
    public $breadcrumb;

    public function __construct()
    {
        parent::__construct();
        $this->absoluteUrls = true;
    }

    protected function afterRender()
    {
        $this->template->title = $this->title;
        parent::afterRender();
    }

    protected function createComponentBreadCrumb()
    {
        return $this->breadcrumb;
    }
}
