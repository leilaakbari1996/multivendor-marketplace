{{-- کادر جستجوی هدر: Enter => صفحه محصولات با ?search= | تایپ => پیشنهاد زنده --}}
<form id="site-search"
      class="search-box search-bar row bg-light rounded-4"
      role="search"
      method="GET"
      action="{{ route('products.index') }}"
      data-url="{{ route('search.suggest') }}">

    <x-client.forms.input
        name="search"
        type="search"
        :value="request('search')"
        wrapperClass="field-flush"
        class="search-input"
        placeholder="جستجوی محصولات"
        maxlength="50"
        autocomplete="off"
        role="combobox"
        aria-label="جستجوی محصولات"
        aria-autocomplete="list"
        aria-expanded="false"
        aria-controls="search-panel"
    />

    <span class="search-spinner" aria-hidden="true"></span>

    <div class="search-panel" id="search-panel" role="listbox" hidden></div>
</form>
