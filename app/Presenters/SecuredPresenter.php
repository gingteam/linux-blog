<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette\Http\IResponse;

class SecuredPresenter extends BasePresenter
{
    protected function startup()
    {
        parent::startup();

        if (!$this->getUser()
            ->isAllowed(
                $this->getName(),
                $this->getAction()
            )
        ) {
            $this->error(
                'You do not have permission to access this page',
                IResponse::S403_FORBIDDEN
            );
        }
    }
}
