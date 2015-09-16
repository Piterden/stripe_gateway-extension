<?php namespace Anomaly\StripeGatewayExtension\Command;

use Anomaly\EncryptedFieldType\EncryptedFieldTypePresenter;
use Anomaly\SettingsModule\Setting\Contract\SettingRepositoryInterface;
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
     * Handle the command.
     *
     * @param SettingRepositoryInterface $settings
     */
    public function handle(SettingRepositoryInterface $settings)
    {
        $live = $settings->get('anomaly.extension.stripe_gateway::live');

        if (!$live) {
            throw new \Exception('Please configure the Stripe gateway before using.');
        }

        /* @var EncryptedFieldTypePresenter $key */
        if ($live && $live->getValue()) {
            $key = $settings->value('anomaly.extension.stripe_gateway::live_api_key');
        } else {
            $key = $settings->value('anomaly.extension.stripe_gateway::test_api_key');
        }

        $gateway = new Gateway();

        $gateway->setApiKey($key->decrypted());
        $gateway->setTestMode(!$live->getValue());

        return $gateway;
    }
}