<?php namespace Anomaly\StripeGatewayExtension\Command;

use Anomaly\ConfigurationModule\Configuration\Contract\ConfigurationRepositoryInterface;
use Anomaly\EncryptedFieldType\EncryptedFieldTypePresenter;
use Anomaly\PaymentsModule\Gateway\Contract\GatewayInterface;
use Illuminate\Contracts\Bus\SelfHandling;
use Omnipay\Stripe\Gateway;

/**
 * Class MakeStripeGateway
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\StripeGatewayExtension\Command
 */
class MakeStripeGateway implements SelfHandling
{

    /**
     * The gateway instance.
     *
     * @var GatewayInterface
     */
    protected $gateway;

    /**
     * Create a new MakePaypalProGateway instance.
     *
     * @param GatewayInterface $gateway
     */
    public function __construct(GatewayInterface $gateway)
    {
        $this->gateway = $gateway;
    }

    /**
     * Handle the command.
     *
     * @param ConfigurationRepositoryInterface $configuration
     */
    public function handle(ConfigurationRepositoryInterface $configuration)
    {
        $mode = $configuration->get('anomaly.extension.stripe_gateway::test_mode', $this->gateway->getSlug());

        /* @var EncryptedFieldTypePresenter $key */
        if ($mode->getValue()) {
            $key = $configuration->presenter(
                'anomaly.extension.stripe_gateway::test_api_key',
                $this->gateway->getSlug()
            );
        } else {
            $key = $configuration->presenter(
                'anomaly.extension.stripe_gateway::live_api_key',
                $this->gateway->getSlug()
            );
        }

        $gateway = new Gateway();

        $gateway->setApiKey($key->decrypted());
        $gateway->setTestMode($mode->getValue());

        return $gateway;
    }
}
