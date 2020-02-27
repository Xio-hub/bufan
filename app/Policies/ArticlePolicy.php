<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\Merchant;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
{
    use HandlesAuthorization;

    public function view(Merchant $merchant, Article $article)
    {
        return $merchant->id === $article->merchant_id;
    }

    public function edit(Merchant $merchant, Article $article)
    {
        return $merchant->id === $article->merchant_id;
    }

    public function update(Merchant $merchant, Article $article)
    {
        return $merchant->id === $article->merchant_id;
    }

    public function delete(Merchant $merchant, Article $article)
    {
        return $merchant->id === $article->merchant_id;
    }
}
