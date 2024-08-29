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

        if( $this->service->hasTestForSession('landing-animation') ) {
            $hero = $this->service->getVariantFromSession('landing-animation');
        }

        if( $this->service->hasTestForSession('contact-alignment') ) {
            $contactAlignment = $this->service->getVariantFromSession('contact-alignment');
        }

        if( $this->service->hasTestForSession('pricing-alignment') ) {
            $pricingAlignment = $this->service->getVariantFromSession('pricing-alignment');
        }

        if( $this->service->hasTestForSession('pricing-button-labels') ) {
            $pricingButtonLabel = $this->service->getVariantFromSession('pricing-button-labels');
        }

        if( $this->service->hasTestForSession('feature-types') ) {
            $featureType = $this->service->getVariantFromSession('feature-types');
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
