<div class="header-image support" style="background-image: url('{{ ($headerImage) }}');">
    <div class="container d-none d-xl-flex">
        
    </div>
    @if($headerOverlay != '')
        <div class="overlay" style="background-color: {{ $headerOverlay }};"></div>
    @endif
</div>