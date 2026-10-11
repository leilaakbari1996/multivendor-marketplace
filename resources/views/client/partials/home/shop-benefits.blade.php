<section class="py-5">
    <div class="container-fluid">
        <div class="row row-cols-1 row-cols-sm-3 row-cols-lg-5 g-3">
            @foreach ($shopBenefits as $benefit)
                <x-client.info-box
                    :inline="true"
                    wrapper-class="col"
                    heading-tag="h5"
                    :icon="$benefit->icon"
                    :title="$benefit->title"
                    :value="$benefit->description" />
            @endforeach
        </div>
    </div>
</section>




