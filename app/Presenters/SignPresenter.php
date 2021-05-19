<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;

class SignPresenter extends BasePresenter
{
    protected function createComponentSignInForm(): Form
    {
        $form = new Form();
        $form->addText('username', 'Username:')
            ->setRequired('Please enter your username.');

        $form->addPassword('password', 'Password:')
            ->setRequired('Please enter your password.');

        $form->addSubmit('send', 'Sign in');
        $form->addProtection();

        $form->onSuccess[] = function (\Nette\Application\UI\Form $form, \stdClass $values): void {
            $this->signInFormSucceeded($form, $values);
        };

        return $form;
    }

    public function signInFormSucceeded(Form $form, \stdClass $values): void
    {
        try {
            $this->getUser()->login($values->username, $values->password);
            $this->redirect('Homepage:');
        } catch (Nette\Security\AuthenticationException $e) {
            $form->addError('Incorrect username or password.');
        }
    }

    public function actionOut(): void
    {
        $this->getUser()->logout(true);
        $this->flashMessage('You have been signed out.');
        $this->redirect('Homepage:');
    }
}
