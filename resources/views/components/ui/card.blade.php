@props(['title' => null, 'description' => null, 'action' => null])

<div {{ $attributes->merge(['class' => 'bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col']) }}>
    @if($title || $description || $action || isset($header))
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
            <div>
                @if(isset($header))
                    {{ $header }}
                @else
                    @if($title)
                        <h3 class="text-lg font-bold text-gray-900">{{ $title }}</h3>
                    @endif
                    @if($description)
                        <p class="text-sm text-gray-500 mt-1">{{ $description }}</p>
                    @endif
                @endif
            </div>
            
            @if($action)
                <div>
                    {{ $action }}
                </div>
            @endif
        </div>
    @endif
    
    <div class="p-6 flex-1">
        {{ $slot }}
    </div>
    
    @isset($footer)
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
            {{ $footer }}
        </div>
    @endisset
</div>
