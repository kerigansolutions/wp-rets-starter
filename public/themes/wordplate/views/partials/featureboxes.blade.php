<div class="feature-box-section bg-light">
    <div class="container">
        <div class="row align-items-center">
            @foreach($featureBoxes as $featureBox)
            <div class="col {{ $featureBox['class'] }} box-container flex-grow-1">
                <div class="feature-box" 
                style="
                    {{ ($featureBox['background_image']['url'] != '' ? 'background-image: url(' . $featureBox['background_image']['url'] . ');' : '') }}
                    {{ ($featureBox['box_color'] != '' ? 'background-color: ' . $featureBox['box_color'] . ';' : '') }}
                    {{ ($featureBox['border_color'] != '' ? 'border: 1px solid ' . $featureBox['border_color'] . ';' : '') }}
                    {{ ($featureBox['text_color'] != '' ? 'color: ' . $featureBox['text_color'] . ';' : '') }}
                ">
                    <div class="box-content text-center text-md-left">
                        <h3 class="m-0">{{ $featureBox['headline'] }}</h3>
                        <div class="box-text pt-2 pb-4">
                            {{ $featureBox['text'] }}
                        </div>
                        @if($featureBox['link'] != '')
                        <a 
                            class="btn btn-lg" 
                            href="{{ $featureBox['link'] }}"
                            style="
                                {{ ($featureBox['text_color'] != '' ? 'border: 1px solid ' . $featureBox['text_color'] . ';' : '') }}
                                {{ ($featureBox['text_color'] != '' ? 'color: ' . $featureBox['text_color'] . ';' : '') }}
                            " 
                        >{{ $featureBox['link_text'] }} &nbsp; <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                        @endif
                    </div>
                    @if($featureBox['overlay'] != '')
                    <div class="overlay" style="background-color: {{ $featureBox['overlay'] }};"></div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>