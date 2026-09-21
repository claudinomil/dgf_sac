<button
    {{ $attributes }}

    type="{{ $type }}"

    class="{{ $class }}"

    @if($dataBsToggle !== null)
        data-bs-toggle="{{ $dataBsToggle }}"
    @endif

    @if($dataBsPlacement !== null)
        data-bs-placement="{{ $dataBsPlacement }}"
    @endif

    @if($dataBsTarget !== null)
        data-bs-target="{{ $dataBsTarget }}"
    @endif

    @if($dataId !== null)
        data-id="{{ $dataId }}"
    @endif

    @if($title !== null)
        title="{{ $title }}"
    @endif

    >

    @if($image !== null)
        <i class="{{ $image }}"></i>
    @endif

    {{ $label }}
</button>
