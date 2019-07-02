<?php
declare(strict_types=1);

namespace Trejjam\ComgateApi\Contract;

use Trejjam\ComgateApi\Annotation\Getter;
use Trejjam\ComgateApi\Configuration\Integration;
use Trejjam\ComgateApi\Property\Country;
use Trejjam\ComgateApi\Property\Language;
use Trejjam\ComgateApi\Property\ResponseType;

final class Method
{
    /**
     * identifikátor e-shopu v systému ComGate
     *
     * @var string
     */
    private $merchant;

    /**
     * heslo pro komunikaci na pozadí
     *
     * @var string
     */
    private $secret;

    /**
     * Formát vrácených dat („xml“ nebo „json“). Pokud nebude vyplněno, použije se „xml“.
     *
     * @var ResponseType|null
     */
    private $type;

    /**
     * Výběr, v jakém jazyce budou popisy metod. Povolené hodnoty jsou „cs“, „en“, „pl“. Pokud nebude vyplněno, použije se „cs“.
     *
     * @Getter("getLanguage")
     * @var Language|null
     */
    private $lang;

    /**
     * Vyplněním parametru na hodnoty CZK nebo EUR dojde k vrácení metod, které podporují zadanou měnu.
     *
     * @Getter("getCurrency")
     * @var string|null
     */
    private $curr;

    /**
     * kód země („CZ“, „SK“), parametr slouží k omezení výběru platebních metod pro zadanou zemi
     *
     * @var Country|null
     */
    private $country;

    public function __construct(
        Integration $integration
    ) {
        $this->merchant = $integration->getMerchant();
        $this->secret = $integration->getSecret();
    }

    public function getMerchant() : string
    {
        return $this->merchant;
    }

    public function getSecret() : string
    {
        return $this->secret;
    }

    public function getType() : ?ResponseType
    {
        return $this->type;
    }

    public function getLanguage() : ?Language
    {
        return $this->lang;
    }

    public function getCurrency() : ?string
    {
        return $this->curr;
    }

    public function getCountry() : ?Country
    {
        return $this->country;
    }

    public function setType(?ResponseType $type) : self
    {
        $this->type = $type;
        return $this;
    }

    public function setLanguage(?Language $lang) : self
    {
        $this->lang = $lang;
        return $this;
    }

    public function setCurrency(?string $curr) : self
    {
        //TODO validate currency?

        $this->curr = $curr;
        return $this;
    }

    public function setCountry(?Country $country) : self
    {
        $this->country = $country;
        return $this;
    }
}
