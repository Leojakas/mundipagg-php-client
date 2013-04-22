<?php

namespace MundiPagg\Test;

use MundiPagg\Client;
use MundiPagg\Entity\CreateOrderRequest;
use MundiPagg\Entity\CreditCardTransaction;
use MundiPagg\Entity\CreditCardTransactionCollection;
use MundiPagg\Entity\Enum\CreditCardBrandEnum;
use MundiPagg\Entity\Enum\CreditCardOperationEnum;
use MundiPagg\Entity\Enum\CurrencyIsoEnum;
use MundiPagg\Entity\Enum\EmailUpdateToBuyerEnum;

/**
 * Client Test
 *
 * @author Carlos Cima
 */
class ClientTest extends \PHPUnit_Framework_TestCase
{
    const FIXTURE_MERCHANT_KEY = 'FB76E29D-427F-45B2-AD49-F99715EF46B5';

    /**
     * MundiPagg Client
     * 
     * @var \MundiPagg\Client
     */
    protected $client;

    protected function setUp()
    {
        parent::setUp();
        $this->client = new Client(self::FIXTURE_MERCHANT_KEY, Client::WSDL_PRODUCTION_URL);
        $this->client->getSoapClient()->setDebug(true);
        $this->client->getSoapClient()->setDebugLogFilePath(__DIR__ . '/../../../log/debug.log');
    }

    public function testGetSoapClient()
    {
        $this->assertInstanceOf('\Camcima\Soap\Client', $this->client->getSoapClient());
    }

    public function testCreateOrder()
    {
        $createOrderRequest = new CreateOrderRequest();
        $createOrderRequest
            ->setMerchantKey(self::FIXTURE_MERCHANT_KEY)
            ->setOrderReference('TESTESERVICOPHP')
            ->setAmountInCents(9)
            ->setAmountInCentsToConsiderPaid(0)
            ->setEmailUpdateToBuyerEnum(EmailUpdateToBuyerEnum::NO)
            ->setCurrencyIsoEnum(CurrencyIsoEnum::BRAZILIAN_REAL)
            ->setCreditCardTransactionCollection(new CreditCardTransactionCollection());

        $creditCardTransaction = new CreditCardTransaction();
        $creditCardTransaction
            ->setAmountInCents(100)
            ->setCreditCardNumber('5212701315496781')
            ->setInstallmentCount(0)
            ->setHolderName('Carlos Teste')
            ->setSecurityCode('081')
            ->setExpMonth('09')
            ->setExpYear('14')
            ->setCreditCardBrandEnum(CreditCardBrandEnum::MASTERCARD)
            ->setPaymentMethodCode(1)
            ->setCreditCardOperationEnum(CreditCardOperationEnum::AUTHORIZE_ONLY);

        $creditCardTransaction2 = new CreditCardTransaction();
        $creditCardTransaction2
            ->setAmountInCents(100)
            ->setCreditCardNumber('5212701315496781')
            ->setInstallmentCount(0)
            ->setHolderName('Carlos Teste')
            ->setSecurityCode('081')
            ->setExpMonth('09')
            ->setExpYear('14')
            ->setCreditCardBrandEnum(CreditCardBrandEnum::MASTERCARD)
            ->setPaymentMethodCode(1)
            ->setCreditCardOperationEnum(CreditCardOperationEnum::AUTHORIZE_ONLY);

        $createOrderRequest
            ->getCreditCardTransactionCollection()
            ->addCreditCardTransaction($creditCardTransaction)
            ->addCreditCardTransaction($creditCardTransaction2);


        $createOrderResult = $this->client->createOrder($createOrderRequest);
        /* @var $createOrderResult \MundiPagg\Entity\CreateOrderResult */
        $this->assertInstanceOf('\MundiPagg\Entity\CreateOrderResult', $createOrderResult);
        $this->assertInstanceOf('\MundiPagg\Entity\BoletoTransactionResultCollection', $createOrderResult->BoletoTransactionResultCollection);
        $this->assertInstanceOf('\MundiPagg\Entity\CreditCardTransactionResultCollection', $createOrderResult->CreditCardTransactionResultCollection);
        $creditCardTransactionResultCollection = $createOrderResult->CreditCardTransactionResultCollection;
        /* @var $creditCardTransactionResultCollection \MundiPagg\Entity\CreditCardTransactionResultCollection */
        $creditCardTransactionResult = $creditCardTransactionResultCollection->CreditCardTransactionResult;
        $this->assertInternalType('array', $creditCardTransactionResult);
        $this->assertCount(2, $creditCardTransactionResult);
        $firstTransactionResult = reset($creditCardTransactionResult);
        /* @var $firstTransactionResult \MundiPagg\Entity\CreditCardTransactionResult */
        $this->assertInstanceOf('\MundiPagg\Entity\CreditCardTransactionResult', $firstTransactionResult);
        $this->assertEquals('521270****6781', $firstTransactionResult->CreditCardNumber);
        $this->assertEquals('AuthOnly', $firstTransactionResult->CreditCardOperationEnum);
        $this->assertEquals('AuthorizedPendingCapture', $firstTransactionResult->CreditCardTransactionStatusEnum);
        $this->assertTrue($firstTransactionResult->Success);
    }

}
