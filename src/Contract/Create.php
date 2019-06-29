<?php
declare(strict_types=1);

namespace Trejjam\ComgateApi\Contract;

use Trejjam\ComgateApi\Annotation\Getter;
use Trejjam\ComgateApi\Configuration\Integration;
use Trejjam\ComgateApi\Property\Country;

final class Create
{
    /**
     * identifikátor e-shopu v systému ComGate - naleznete v Klientském portálu v sekci Nastaveni obchodů - Propojeni obchodu.
     *
     * @var string
     */
    private $merchant;

    /**
     * Hodnota „true“ znamená, že platba bude založena jako testovací, hodnota „false“ znamená produkční verzi. Pokud parametr chybí, založí se platba jako produkční.
     *
     * @var bool|null
     */
    private $test;

    /**
     * kód země („CZ“, „SK“, „PL“, „ALL“), pokud parametr chybí, použije se „CZ“, parametr slouží k omezení výběru platebních metod na ComGate platební bráně
     *
     * @var Country|null
     */
    private $country;

    /**
     * Cena za produkt v centech nebo haléřích.
     *
     * Musí být min. 10 CZK (včetně), max. neomezeno.
     *
     * @var int
     */
    private $price;

    /**
     * kód měny dle ISO 4217, standardně „CZK“
     *
     * @Getter("getCurrency")
     * @var string
     */
    private $curr;

    /**
     * krátký popis produktu (1-16 znaků); dle této položky je možné filtrovat platby v Klientském portálu
     *
     * @var string
     */
    private $label;

    /**
     * parametr vhodný k zadaní variabilního symbolu nebo čísla objednávky na straně Klienta (nemusí být unikátní, tzn., že lze založit více plateb se stejným refId); v Klientském portálu a denním csv. je parametr označen jako ID Klienta
     *
     * @var string
     */
    private $refId;

    /**
     * Identifikátor Plátce v systému Klienta. Identifikátor musí být ověřen například přihlášením Plátce do systému Klienta pomocí hesla, pokud není, tak parametr nevyplňujte. Používá se při platbě kartou, kde platební brána ukládá čísla karet Plátců, takže při další platbě Plátce nemusí číslo karty znovu zadávat. Tato funkce musí být pro konkrétního Klienta povolena v systému karetního zpracovatele.
     *
     * @var string|null
     */
    private $payerId;

    /**
     * metoda platby, z tabulky platebních metod, hodnota „ALL“ v případě, že si má metodu vybrat plátce, nebo jednoduchý výraz s výběrem metod (popsáno níže)
     *
     * @var string
     */
    private $method;

    /**
     * identifikátor bankovního účtu Klienta, na který ComGate Payments převede peníze. Pokud parametr nevyplníte, použije se výchozí účet Klienta. Seznam účtů Klienta najdete na https://portal.comgate.cz/
     *
     * @var string|null
     */
    private $account;

    /**
     * kontaktní email na Plátce (pro účely případné reklamace)
     *
     * @var string
     */
    private $email;

    /**
     * kontaktní telefon na Plátce (pro účely případné reklamace)
     *
     * @var string|null
     */
    private $phone;


    /**
     * identifikátor produktu - tato položka se nachází v denním csv. Klienta pod názvem Produkt
     *
     * @var string|null
     */
    private $name;

    /**
     * kód jazyka (ISO 639-1), ve kterém budou Plátci zobrazeny instrukce pro dokončení platby, povolené hodnoty („cs”, „sk“, „en”), pokud parametr chybí, použije se „cs“
     *
     * @Getter("getLanguage")
     * @var string|null
     */
    private $lang;

    /**
     * V případě zakládání platby na pozadí vyplňte „true“. Při zakládání platby přesměrováním vyplňte buď „false“ nebo parametr nepoužívejte.
     *
     * @var bool|null
     */
    private $prepareOnly;

    /**
     * V případě zakládání platby na pozadí vyplňte heslo pro komunikaci na pozadí. Při zakládání platby přesměrováním parametr ponechte prázdný, nebo jej nepoužívejte.
     *
     * @var string|null
     */
    private $secret;

    /**
     * V případě požadavku na předautorizaci platby kartou nastavte na „true“. V případě normální platby vyplňte „false“ nebo parametr nepoužívejte. Pouze pro platby kartou.
     *
     * @var bool|null
     */
    private $preauth;

    /**
     * Příznak pro založení iniciační transakce pro opakované platby. Pouze pro Klienty, kteří mají službu povolenou.
     *
     * @var bool|null
     */
    private $initRecurring;

    /**
     * Parametr ověřovací platby, v případě požadavku na založení ověřovací platby (hodnota „true“) není nutné posílat parametr initRecurring.
     *
     * @var bool|null
     */
    private $verification;


    /**
     * Parametr se používá při platbě kartou na bráně ČSOB (metoda CARD_CZ_CSOB_2). Hodnota „true“ zajistí zobrazení karetní brány v iframe. Pokud chcete zobrazit standardní bránu, parametr nevyplňujte nebo zadejte hodnotu „false“. Tato funkcionalita je na speciální povolení.
     *
     * @var bool|null
     */
    private $embedded;

    /**
     * Příznak odeslání dat do EET. Pokud je vyplněno, přetěžuje nastavení EET v konfiguraci obchodu v Klientském Portálu.
     *
     * @var bool|null
     */
    private $eetReport;

    /**
     * Struktura s daty pro zaevidování platby do EET. Odpovídá parametrům ze specifikace protokolu EET. Pokud má e-shop nastaveno odesílání tržby do EET a parametr nebude vyplněn, použije se výchozí nastavení z konfigurace v Klientském Portálu.
     *
     * JSON
     * @var object|null
     */
    private $eetData;

    public function __construct(
        Integration $integration,
        int $price,
        string $curr,
        string $label,
        string $refId,
        string $method,
        string $email
    ) {
        $this->merchant = $integration->getMerchant();
        $this->test = $integration->isTestEnvironment();
        $this->price = $price;
        $this->curr = $curr;
        $this->label = $label;
        $this->refId = $refId;
        $this->method = $method;
        $this->email = $email;
    }

    public function getMerchant() : string
    {
        return $this->merchant;
    }

    public function getTest() : ?bool
    {
        return $this->test;
    }

    public function getCountry() : ?Country
    {
        return $this->country;
    }

    public function getPrice() : int
    {
        return $this->price;
    }

    public function getCurrency() : string
    {
        return $this->curr;
    }

    public function getLabel() : string
    {
        return $this->label;
    }

    public function getRefId() : string
    {
        return $this->refId;
    }

    public function getPayerId() : ?string
    {
        return $this->payerId;
    }

    public function getMethod() : string
    {
        return $this->method;
    }

    public function getAccount() : ?string
    {
        return $this->account;
    }

    public function getEmail() : string
    {
        return $this->email;
    }

    public function getPhone() : ?string
    {
        return $this->phone;
    }

    public function getName() : ?string
    {
        return $this->name;
    }

    public function getLanguage() : ?string
    {
        return $this->lang;
    }

    public function getPrepareOnly() : ?bool
    {
        return $this->prepareOnly;
    }

    public function getSecret() : ?string
    {
        return $this->secret;
    }

    public function getPreauth() : ?bool
    {
        return $this->preauth;
    }

    public function getInitRecurring() : ?bool
    {
        return $this->initRecurring;
    }

    public function getVerification() : ?bool
    {
        return $this->verification;
    }

    public function getEmbedded() : ?bool
    {
        return $this->embedded;
    }

    public function getEetReport() : ?bool
    {
        return $this->eetReport;
    }

    public function getEetData() : ?object
    {
        return $this->eetData;
    }
}
