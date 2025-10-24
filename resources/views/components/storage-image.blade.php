@props(['path' => null, 'alt' => '', 'default' => 'images/default-section.png'])

@php
    use App\Helpers\StorageHelper;
    $src = '';
    if ($path) {
        $src = filter_var($path, FILTER_VALIDATE_URL)
            ? $path
            : StorageHelper::getImageUrl($path, $default);
    } else {
        $src = asset($default);
    }
@endphp

<img src="{{ $src }}" alt="{{ $alt }}" {{ $attributes }}>