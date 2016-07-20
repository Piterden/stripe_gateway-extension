<?php namespace Anomaly\StripeGatewayExtension\Command;

use Anomaly\ConfigurationModule\Configuration\Contract\ConfigurationRepositoryInterface;
use Anomaly\EncryptedFieldType\EncryptedFieldTypePresenter;
use Anomaly\PaymentsModule\Account\Contract\AccountInterface;
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
     */
    public function handle(ConfigurationRepositoryInterface $configuration)
    {
        $mode = $configuration->get('anomaly.extension.stripe_gateway::test_mode', $this->account->getSlug());

        /* @var EncryptedFieldTypePresenter $key */
        if ($mode->getValue()) {
            $key = $configuration->presenter(
                'anomaly.extension.stripe_gateway::test_api_key',
                $this->account->getSlug()
            );
        } else {
            $key = $configuration->presenter(
                'anomaly.extension.stripe_gateway::live_api_key',
                $this->account->getSlug()
            );
        }

        $gateway = new Gateway();

        $gateway->setApiKey($key->decrypt());
        $gateway->setTestMode($mode->getValue());

        return $gateway;
    }
}
