<?php

declare(strict_types=1);

namespace App\Presenters;

use Contributte\FormsBootstrap\BootstrapForm;
use Contributte\FormsBootstrap\Enums\RenderMode;
use Nette\Application\UI\Form;
use Nette\Utils\Strings;

class PostPresenter extends BasePresenter
{
    protected function startup()
    {
        parent::startup();

        if (
            'show' != $this->getAction()
            && !$this->getUser()->isLoggedIn()
        ) {
            $this->redirect('Sign:in');
        }
    }

    protected function getPost(int $id)
    {
        $post = $this->database->table('posts')->get($id);
        if (!$post) {
            $this->error('Post not found');
        }

        return $post;
    }

    public function actionCreate()
    {
        $this->title = 'Create a new post';
        $this->setView('form');
    }

    public function actionEdit(int $id)
    {
        $post = $this->getPost($id);

        $this->title = 'Post edit';

        $this['breadCrumb']->add(
            $post->title,
            $this->link('show', $post->id, Strings::webalize($post->title))
        );

        $this['postForm']->setDefaults($post->toArray());
        $this->setView('form');
    }

    public function actionDelete(int $id)
    {
        $post = $this->getPost($id);

        $post->delete();
        $this->flashMessage('Deleted successfully');
        $this->redirect('Homepage:');
    }

    public function renderShow(int $id, string $slug)
    {
        $post = $this->getPost($id);

        $this->title = $post->title;

        $this['breadCrumb']->add(
            'Blog',
            $this->link('Homepage:list')
        );

        $this->template->post = $post;
    }

    protected function createComponentPostForm()
    {
        $form = new BootstrapForm();
        $form->renderMode = RenderMode::VERTICAL_MODE;

        $form->addText('title', 'Title:')
            ->setRequired();
        $form->addTextArea('content', 'Content:')
            ->setHtmlAttribute('rows', 15)
            ->setRequired();
        $form->addText('thumbnail', 'Thumbnail:');
        $form->addText('tags', 'Tags:')
            ->setHtmlAttribute('data-role', 'tagsinput');
        $form->addProtection();

        $form->addSubmit('send', 'Save and publish');
        $form->onSuccess[] = [$this, 'postFormSucceeded'];

        return $form;
    }

    public function postFormSucceeded(Form $form, array $values)
    {
        $postId = $this->getParameter('id');

        if ($postId) {
            $post = $this->database->table('posts')->get($postId);
            $post->update($values);
        } else {
            $post = $this->database->table('posts')->insert($values);
        }

        $this->flashMessage('Post was published');
        $this->redirect('show', $post->id, Strings::webalize($post->title));
    }
}
