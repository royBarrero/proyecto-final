@php
    $alerts = [
        'success' => 'background: #d1fae5; border: 1px solid #34d399; color: #065f46; padding: 12px; border-radius: 5px; margin-bottom: 15px;',
        'error'   => 'background: #fee2e2; border: 1px solid #f87171; color: #991b1b; padding: 12px; border-radius: 5px; margin-bottom: 15px;',
        'warning' => 'background: #fef3c7; border: 1px solid #fbbf24; color: #78350f; padding: 12px; border-radius: 5px; margin-bottom: 15px;',
        'info'    => 'background: #bfdbfe; border: 1px solid #60a5fa; color: #1e40af; padding: 12px; border-radius: 5px; margin-bottom: 15px;'
    ];
@endphp

@foreach($alerts as $type => $style)
    @if(session($type))
        <div style="{{ $style }}" role="alert">
            {{ session($type) }}
        </div>
    @endif
@endforeach
