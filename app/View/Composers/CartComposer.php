<?php

namespace App\View\Composers;

use App\Queries\CartQuery;
use App\Support\AuthUser;
use Illuminate\View\View;

class CartComposer
{
    private ?array $data = null;

    public function __construct(
        private readonly CartQuery $cartQuery,
    ) {}

    public function compose(View $view): void
    {
        $this->data ??= $this->cartQuery->summary(AuthUser::id());

        $view->with($this->data);
    }
}
