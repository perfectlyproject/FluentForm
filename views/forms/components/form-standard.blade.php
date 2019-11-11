@php
    $groupCss = array_merge(['row', take($class)], $group->getCss());
@endphp

<div class="{!! implode(' ', $groupCss) !!}">
    <div class="columns large-12">
        {!! $slot !!}
    </div>
</div>