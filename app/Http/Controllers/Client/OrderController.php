<?php

namespace App\Http\Controllers\Client;

//use App\Actions\Order\GetUserOrderAction;
use App\Actions\Client\Order\IndexOrderAction;
use App\Actions\Client\Order\ShowOrderAction;
use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Support\AuthUser;
use App\Support\OrderPresenter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * لیست سفارش‌های کاربر لاگین‌شده (با فیلتر وضعیت: ?status=...)
     * درخواست عادی => صفحه کامل | درخواست AJAX => فقط HTML لیست (JSON)
     */
    public function index(Request $request, IndexOrderAction $action): View|JsonResponse
    {
        // مقدار نامعتبر یا خالی => null => نمایش همه سفارش‌ها
        $status = OrderStatus::tryFrom((string) $request->query('status'));

        $orders = $action->execute(AuthUser::user(), $status);

        if ($request->ajax() || $request->wantsJson()) {
            return response()
                ->json([
                    'html'  => view('client.partials.order.list', compact('orders', 'status'))->render(),
                    'total' => number_format($orders->total()),
                ])
                // یک URL دو خروجی دارد (HTML/JSON)؛ تا دکمه Back مرورگر JSON کش‌شده را نشان ندهد
                ->header('Vary', 'X-Requested-With');
        }

        return view('client.pages.orders.index', [
            'orders'   => $orders,
            'status'   => $status,
            'statuses' => OrderStatus::cases(),
        ]);
    }

    /**
     * جزئیات یک سفارش (فقط اگر متعلق به همین کاربر باشد)
     */
    public function show(Request $request, string $orderNumber, ShowOrderAction $action): View
    {
        $order = $action->execute(AuthUser::user(), $orderNumber);

        return view('client.pages.orders.show', compact('order'));
    }
}
