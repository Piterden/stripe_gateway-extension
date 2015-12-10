<?php namespace Anomaly\StripeGatewayExtension;

use Anomaly\PaymentsModule\Gateway\GatewayExtension;
use Anomaly\StripeGatewayExtension\Command\MakeStripeGateway;
use Omnipay\Stripe\Gateway;

/**
 * Class StripeGatewayExtension
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\StripeGatewayExtension
 */
class StripeGatewayExtension extends GatewayExtension
{

    /**
     * This extension provides the Stripe
     * payment gateway for the Payments module.
     *
     * @var null|string
     */
    protected $provides = 'anomaly.module.payments::payment_gateway.stripe';

    /**
     * Return a new Gateway instance.
     *
     * @return Gateway
     */
    public function make()
    {
        return $this->dispatch(new MakeStripeGateway());
    }
}
