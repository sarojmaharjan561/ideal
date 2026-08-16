@props(['label'=>false, 'name','type' => 'text'])

<div class="space-y-2">
    @if($label)
        <label for="{{ $name }}" class="label">{{ $label }}</label>
    @endif

    @if ($type === 'textarea')
        <textarea 
            class="textarea"
            id="{{ $name }}"
            name="{{ $name }}"
            {{ $attributes }}
        >
        {{ old($name) }}
        </textarea>
    @else
        <input 
            class="input" 
            id="{{ $name }}" 
            name="{{ $name }}" 
            type="{{ $type }}" 
            value="{{ old($name) }}"        
            {{ $attributes }}
            required 
        >
    @endif

    <x-form.error name="{{ $name }}" />
</div>