@php
    $value = (float) ($value ?? 0);
    $full = (int) floor($value);
    $empty = 5 - $full;
@endphp

<span class="me-1" aria-label="Rating {{ number_format($value, 1) }} out of 5">
    @for($i = 0; $i < $full; $i++)
        <span class="text-warning">★</span>
    @endfor
    @for($i = 0; $i < $empty; $i++)
        <span class="text-muted">☆</span>
    @endfor
</span>
<span class="text-muted small">{{ number_format($value, 1) }}</span>
