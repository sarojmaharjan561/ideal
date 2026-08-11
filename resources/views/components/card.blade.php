@props(['is'=>'a'])

<{{ $is }} {{ $attributes(['class'=>'order border-border rounded-lg p-4 bg-card md:text-sm block']) }}>
    {{ $slot }}
</{{ $is }}>