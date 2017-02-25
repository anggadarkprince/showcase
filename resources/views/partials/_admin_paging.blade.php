<div class="clearfix">
    @php
        $shownItems = (($data->currentPage() - 1) * $data->perPage()) + $data->count();
        $totalItems = $data->total();
    @endphp
    <div class="pagination pull-left">
        @lang('pagination.show', ['current' => $shownItems, 'total' => $totalItems])
    </div>
    <div class="pull-right">
        {{ $data->links() }}
    </div>
</div>