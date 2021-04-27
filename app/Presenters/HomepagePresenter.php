<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette\Utils\Paginator;

class HomepagePresenter extends BasePresenter
{
    public function renderList(int $page = 1, string $search = '', $tag = 0)
    {
        $posts = $this->database->table('posts');
        if ($search) {
            $posts->where(($tag ? 'tags' : 'title').' LIKE ?', '%'.$search.'%');
        }

        $this->setView('list');
        $paginator = new Paginator();
        $paginator->setItemCount($posts->count('*'));
        $paginator->setItemsPerPage(5);
        $paginator->setPage($page);

        $this->template->posts = $posts->order('created_at DESC')
            ->limit($paginator->getLength(), $paginator->getOffset());
        $this->template->paginator = $paginator;
    }

    public function renderDefault(int $page = 1)
    {
        $this->renderList($page);
    }
}
