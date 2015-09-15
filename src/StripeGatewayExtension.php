<?php namespace Anomaly\StripeGatewayExtension;

use Anomaly\Streams\Platform\Addon\Extension\Extension;

/**
 * Class StripeGatewayExtension
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\StripeGatewayExtension
 */
class StripeGatewayExtension extends Extension
{

    /**
     * This extension provides the Stripe
     * payment gateway for the Payments module.
     *
     * @var null|string
     */
    protected $provides = 'anomaly.module.payments::payment_gateway.stripe';

}
