@extends("master")

@section("content")
    @include("pages.landing.hero", ["hero" => $hero])
    @include("pages.landing.features")
    @include("pages.landing.about-us")

    @if(isset($pricingAlignment) && $pricingAlignment == "after-about-us")
        @include("pages.landing.pricing", ['buttonLabel' => $pricingButtonLabel])
    @endif

    @if(isset($featureType) && $featureType == "tabs")
        @include("pages.landing.features-tabs")
    @elseif(isset($featureType) && $featureType == "services")
        @include("pages.landing.services")
    @else
        @include("pages.landing.features-tabs")
    @endif
    @include("pages.landing.testemonials")

    @if(!isset($pricingAlignment) || (isset($pricingAlignment) && $pricingAlignment == "before-faq"))
        @include("pages.landing.pricing", ['pricingButtonLabel' => $pricingButtonLabel])
    @endif

    @include("pages.landing.faq")
    @include("pages.landing.portfolio")

    @if(isset($contactAlignment))
        @switch($contactAlignment)
            @case("map-top-form-right")
                @include("pages.landing.contact.map-top-form-right")
                @break
            @case("map-bottom-form-left")
                @include("pages.landing.contact.map-bottom-form-left")
                @break
            @case("map-hidden-form-right")
                @include("pages.landing.contact.map-hidden-form-right")
                @break
            @case("map-hidden-form-left")
                @include("pages.landing.contact.map-hidden-form-left")
                @break
        @endswitch
    @else
        @include("pages.landing.contact.map-top-form-right")
    @endif
@endsection
