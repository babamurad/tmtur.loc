<div class="social-links">
    @foreach($socialLinks as $link)
        <a href="{{ $link->url }}" target="_blank" class="text-white me-3" title="{{ $link->name }}">
            @if($link->icon)
                <i class="{{ $link->icon }}"></i>
            @else
                <i class="fas fa-share-alt"></i>
            @endif
        </a>
    @endforeach
</div>