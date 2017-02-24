<small class="pull-right"><span class="hidden-xs">Showing</span>
    <?php
    $show = 0;
    if ($data->total() < $data->perPage() || $data->currentPage() == $data->lastPage()) {
        $show = $data->total();
    } else {
        $show = $data->currentPage() * $data->perPage();
    }
    ?>
    {{ $show }} of {{ $data->total() }}
</small>