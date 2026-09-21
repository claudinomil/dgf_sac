<button

    {{ $attributes }}

    @if($type !== null)
        type="{{ $type }}"
    @endif

    @if($class !== null)
        class="{{ $class }}"
    @endif

    @if($dataBsToggle !== null)
        data-bs-toggle="{{ $dataBsToggle }}"
    @endif

    @if($dataBsPlacement !== null)
        data-bs-placement="{{ $dataBsPlacement }}"
    @endif

    @if($dataId !== null)
        data-id="{{ $dataId }}"
    @endif

    @if($title !== null)
        title="{{ $title }}"
    @endif

    >

    @if($imageAwesome !== null)
        <i class="{{ $imageAwesome }}"></i>
    @endif

    {{ $label }}
</button>
