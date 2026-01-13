<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm border-0">
                <div class="card-body p-5">
                    @if($page)
                        {!! $page->tr('content') !!}
                    @else
                        <div class="text-center">
                            <h3 class="text-muted">Content not available</h3>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>