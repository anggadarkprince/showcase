<small class="pull-right"><span class="hidden-xs">Showing</span>
    <?php
    $show = 0;
    if ($portfolios->total() < $portfolios->perPage() || $portfolios->currentPage() == $portfolios->lastPage()) {
        $show = $portfolios->total();
    } else {
        $show = $portfolios->currentPage() * $portfolios->perPage();
    }
    ?>
    {{ $show }} of {{ $portfolios->total() }}
</small>