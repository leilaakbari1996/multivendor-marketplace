<?php

namespace App\Http\Controllers\Admin;

use App\Constants\AdminView;
use App\Http\Requests\Admin\Contact\UpdateRequest;
use App\Models\ContactMessage;
use App\Support\DateHelper;
use App\Traits\HasDatatable;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Actions\Admin\Contact\UpdateContactAction;

class ContactController
{
    use HasDatatable;

    public function __construct(
        private readonly UpdateContactAction $updateContactAction,
    ) {}

    public function index(): View
    {
        $title = 'صندوق پیام ها';

        return view(
            AdminView::CONTACT_INDEX,
            compact('title')
        );
    }

    public function data()
    {
        return $this->renderDatatable(
            query: ContactMessage::query()
                ->select([
                    'id',
                    'name',
                    'phone',
                    'subject',
                    'status',
                    'created_at'
                ]),
            actionsView: 'admin.pages.contacts.partials._actions',
            extraColumns: [
                'status' => fn ($row) => $row->status->label($row->value),

                'subject' => fn ($row) => $row->subject->label($row->value),

                'created_at' => fn ($row) => DateHelper::toJalali(
                    $row->created_at
                ),
            ],
        );
    }

    public function edit(ContactMessage $contactMessage): View
    {
        $title = 'ویرایش کد تخفیف';

        return view(
            AdminView::CONTACT_EDIT,
            compact(
                'title',
                'contactMessage'
            )
        );
    }

    public function update(
        UpdateRequest $request,
        ContactMessage $contactMessage
    ): RedirectResponse {
        $this->updateContactAction->execute(
            $contactMessage,
            $request->validated()
        );

        return redirect()
            ->route(AdminView::PERFIX_ROUTE . 'contacts.index')
            ->with('success', 'درخواست مشتری با موفقیت ویرایش شد.');
    }
}
