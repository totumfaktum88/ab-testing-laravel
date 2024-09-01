<?php

namespace App\Http\Controllers;

use App\Services\ABTest\TestService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * @param TestService $service
     */
    public function __construct(
        protected readonly TestService $service
    ) {}

    /**
     * @return array
     */
    protected function loadTests(): array {
        $hero = null;
        $contactAlignment = null;
        $pricingAlignment = null;
        $pricingButtonLabel = null;
        $featureType = null;

        if( $this->service->hasTestInStore('landing-animation') ) {
            $hero = $this->service->getVariantFromStore('landing-animation');
        }

        if( $this->service->hasTestInStore('contact-alignment') ) {
            $contactAlignment = $this->service->getVariantFromStore('contact-alignment');
        }

        if( $this->service->hasTestInStore('pricing-alignment') ) {
            $pricingAlignment = $this->service->getVariantFromStore('pricing-alignment');
        }

        if( $this->service->hasTestInStore('pricing-button-labels') ) {
            $pricingButtonLabel = $this->service->getVariantFromStore('pricing-button-labels');
        }

        if( $this->service->hasTestInStore('feature-types') ) {
            $featureType = $this->service->getVariantFromStore('feature-types');
        }

        return [
            "hero" => $hero,
            'contactAlignment' => $contactAlignment,
            'pricingAlignment' => $pricingAlignment,
            'pricingButtonLabel' => $pricingButtonLabel,
            'featureType' => $featureType,
        ];
    }
    public function __invoke(Request $request)
    {
        $params = $this->loadTests();

        return view(
            'pages.landing.index',
            $params
        );
    }
}
