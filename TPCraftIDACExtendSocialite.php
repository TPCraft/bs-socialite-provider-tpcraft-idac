<?php

namespace TPCraft\BsSocialiteProviderTPCraftIDAC;

use SocialiteProviders\Manager\SocialiteWasCalled;

class TPCraftIDACExtendSocialite
{
    /**
     * Execute the provider.
     */
    public function handle(SocialiteWasCalled $socialiteWasCalled)
    {
        $socialiteWasCalled->extendSocialite("tpcraft_idac", __NAMESPACE__."\Provider");
    }
}
