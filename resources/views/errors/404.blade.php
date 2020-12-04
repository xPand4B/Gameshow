@php
    $templates = [
        'heart',
        'lost',
        'space',
        'space-invader',
        'vampire',
    ];

    $randIndex = array_rand($templates);
    $include = 'errors.404-templates.'.$templates[$randIndex];
@endphp

@include($include)
