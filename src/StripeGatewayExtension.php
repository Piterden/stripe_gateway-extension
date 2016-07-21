<?php namespace Anomaly\StripeGatewayExtension;

use Anomaly\PaymentsModule\Gateway\Contract\UsesOmnipay;
use Anomaly\PaymentsModule\Gateway\GatewayExtension;
use Anomaly\StripeGatewayExtension\Command\MakeStripeGateway;
use Omnipay\Common\AbstractGateway;

/**
 * Class StripeGatewayExtension
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\StripeGatewayExtension
 */
class StripeGatewayExtension extends GatewayExtension implements UsesOmnipay
{

    /**
     * The supported methods.
     *
     * @var array
     */
    protected $supports = [
        'authorize',
        'purchase',
        'refund',
        'create_card',
        'delete_card',
    ];

    /**
     * This extension provides the Stripe
     * payment gateway for the Payments module.
     *
     * @var null|string
     */
    protected $provides = 'anomaly.module.payments::gateway.stripe';

    /**
     * Return an Omnipay gateway.
     *
     * @return AbstractGateway
     * @throws \Exception
     */
    public function omnipay()
    {
        return $this->dispatch(new MakeStripeGateway($this->account));
    }
}
