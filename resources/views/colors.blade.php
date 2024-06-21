@php
    switch ($role) {
        case 'primary-color':
            $allowed = [100, 200, 300, 400, 700, 800, 900, 1000];
            break;

        case 'secondary-color':
            // $allowed = [400, 500, 600, 700];
            $allowed = [100, 200, 300, 400, 700, 800, 900, 1000];
            break;

        case 'accent-color':
            $allowed = [300, 400, 500, 600, 700, 800];
            break;
    }
@endphp

<div class="mb-2 flex w-full overflow-hidden form-control h-auto">
    @foreach ($palette as $code => $hex)
        @if (in_array($code, $allowed))
            <div class="text-center" style="flex-grow: 1;">
                <div style="height: 50px; background-color: {{ $hex }}"></div>
            </div>
        @endif
    @endforeach
</div>

<div class="flex w-full">
    @foreach ($palette as $code => $hex)
        @if (in_array($code, $allowed))
            <div class="text-center" style="flex-grow: 1;">
                {{ $code }}
            </div>
        @endif
    @endforeach
</div>
