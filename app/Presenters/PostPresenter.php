<?php

declare(strict_types=1);

namespace App\Presenters;

use Contributte\FormsBootstrap\BootstrapForm;
use Contributte\FormsBootstrap\Enums\RenderMode;
use Nette\Application\UI\Form;
use Nette\Utils\Strings;

class PostPresenter extends BasePresenter
{
    public function actionCreate()
    {
        if (!$this->getUser()->isLoggedIn()) {
            $this->redirect('Sign:in');
        }

        $this['breadCrumb']->add('Create a new post');
        $this->setView('form');
        $this->template->title = 'Create a new post';
    }

    public function actionEdit(int $id)
    {
        if (!$this->getUser()->isLoggedIn()) {
            $this->redirect('Sign:in');
        }

        $post = $this->database->table('posts')->get($id);
        if (!$post) {
            $this->error('Post not found');
        }

        $this['breadCrumb']->add(
            $post->title,
            $this->link('show', $post->id, Strings::webalize($post->title))
        )->add('Edit post');

        $this->setView('form');
        $this->template->title = 'Edit post';
        $this['postForm']->setDefaults($post->toArray());
    }

    public function actionDelete(int $id)
    {
        $post = $this->database->table('posts')->get($id);
        if (!$post) {
            $this->error('Post not found');
        }

        $post->delete();
        $this->flashMessage('Deleted successfully');
        $this->redirect('Homepage:');
    }

    public function renderShow(int $id, string $slug = '')
    {
        $post = $this->database->table('posts')->get($id);
        if (!$post) {
            $this->error('Post not found');
        }

        $this['breadCrumb']->add(
            'Blog',
            $this->link('Homepage:list')
        )->add($post->title);

        $this->template->post = $post;
    }

    protected function createComponentPostForm()
    {
        if (!$this->getUser()->isLoggedIn()) {
            $this->error('You need to log in to create or edit posts');
        }

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
