<?php namespace Anomaly\StripeGatewayExtension\Command;

use Anomaly\ConfigurationModule\Configuration\Contract\ConfigurationRepositoryInterface;
use Anomaly\PaymentsModule\Account\Contract\AccountInterface;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Config\Repository;
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
     * The account instance.
     *
     * @var AccountInterface
     */
    protected $account;

    /**
     * Create a new MakeStripeGateway instance.
     *
     * @param AccountInterface $account
     */
    public function __construct(AccountInterface $account)
    {
        $this->account = $account;
    }

    /**
     * Handle the command.
     *
     * @param ConfigurationRepositoryInterface $configuration
     * @param Repository                       $config
     * @return Gateway
     */
    public function handle(ConfigurationRepositoryInterface $configuration, Repository $config)
    {
        $testMode = $config->get('anomaly.module.payments::config.test_mode');

        if ($testMode) {
            $key = $configuration->presenter(
                'anomaly.extension.stripe_gateway::test_api_key',
                $this->account->getSlug()
            )->__value();
        } else {
            $key = $configuration->presenter(
                'anomaly.extension.stripe_gateway::live_api_key',
                $this->account->getSlug()
            )->__value();
        }

        $gateway = new Gateway();

        $gateway->setApiKey($key);
        $gateway->setTestMode($testMode);

        return $gateway;
    }
}
