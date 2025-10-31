@if ($sortField !== $field)
    <i class="text-muted fa fa-sort pointer-event"></i>
@elseif ($sortAsc)
    <i class="fa fa-sort-up"></i>
@else
    <i class="fa fa-sort-down"></i>
@endif
