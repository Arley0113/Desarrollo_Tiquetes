@props(['type' => 'info', 'dismissible' => true])

@php
$classes = [
    'info' => 'alert-info',
    'success' => 'alert-success',
    'warning' => 'alert-warning',
    'danger' => 'alert-danger',
    'error' => 'alert-danger'
][$type] ?? 'alert-info';

$icons = [
    'info' => 'bi-info-circle',
    'success' => 'bi-check-circle',
    'warning' => 'bi-exclamation-triangle',
    'danger' => 'bi-x-circle',
    'error' => 'bi-x-circle'
][$type] ?? 'bi-info-circle';
@endphp

<div class="alert {{ $classes }} {{ $dismissible ? 'alert-dismissible' : '' }} fade show" role="alert">
    <i class="bi {{ $icons }} me-2"></i>
    {{ $slot }}
    @if($dismissible)
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    @endif
</div>
