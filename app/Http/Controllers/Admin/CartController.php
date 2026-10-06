<?php

namespace App\Http\Controllers\Admin;

use App\Constants\AdminView;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Support\DateHelper;
use App\Traits\HasDatatable;

class CartController extends Controller
{
    use HasDatatable;

    public function index()
    {
        $title = 'سبدهای خرید';

        return view(
            AdminView::CART_INDEX,
            compact('title')
        );
    }

    public function data()
    {
        return $this->renderDatatable(
            query: Cart::query()
                ->select([
                    'id',
                    'user_id',
                    'created_at',
                ])
                ->with('user')
                ->withCount('items')
            ,
            actionsView: 'admin.pages.carts.partials._actions',
            extraColumns: [
                'created_at' => fn ($row) => DateHelper::toJalali($row->created_at),
                'user' => fn ($row) => $row->user
                    ? sprintf(
                        '<a href="%s">%s</a>',
                        route('panel.user.edit', $row->user->id),
                        e($row->user->user_name ?? $row->user->mobile)
                    )
                    : '-',
            ],
        );
    }

    public function show(Cart $cart)
    {
        $title = 'جزئیات سبد خرید';

        $cart->load([
            'user',
            'items.product',
        ]);

        $totalAmount = $cart->items->sum(
            fn (CartItem $item) => $item->totalPrice()
        );

        return view(
            AdminView::CART_SHOW,
            compact(
                'title',
                'cart',
                'totalAmount'
            )
        );
    }
}
