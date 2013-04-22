<?php

namespace MundiPagg\Entity;

/**
 * CreateOrderResponse Entity
 *
 * @author Carlos Cima
 */
class CreateOrderResponse extends AbstractEntity
{
    /**
     * Coleção de BoletosTransactionResult que contém os resultados dos boletos que foram solicitados no Request.
     * 
     * @see \MundiPagg\Entity\BoletoTransactionResult
     * @var array 
     */
    public $BoletoTransactionResultCollection;

    /**
     * Identificação do Buyer na plataforma One. (GUID)
     * 
     * @var string 
     */
    public $BuyerKey;

    /**
     * Coleção de CreditCardTransactionResult que contém os resultados das operações que foram solicitadas no Request.
     * 
     * @see \MundiPagg\Entity\CreditCardTransactionResult
     * @var array 
     */
    public $CreditCardTransactionResultCollection;

    /**
     * Identificação da loja na plataforma One. (GUID)
     * 
     * @var string 
     */
    public $MerchantKey;

    /**
     * Tempo de processo na plataforma One.
     * 
     * @var int 
     */
    public $MundiPaggTimeInMilliSeconds;

    /**
     * Identificação da Ordem na plataforma One. (GUID)
     * 
     * @var string 
     */
    public $OrderKey;

    /**
     * Identificação do pedido enviado pela loja.
     * 
     * @var string 
     */
    public $OrderReference;

    /**
     * Status do pedido na plataforma One.
     * 
     * @see \MundiPagg\Entity\Enum\OrderStatusEnum
     * @var string 
     */
    public $OrderStatusEnum;

    /**
     * Identificação da requisição na plataforma One. (GUID)
     * 
     * @var string 
     */
    public $RequestKey;

    /**
     * Indica se o pedido foi registrado com sucesso.
     * 
     * @var boolean 
     */
    public $Success;

    /**
     * Versão do serviço da MundiPagg utilizada na comunicação.
     * 
     * @var string 
     */
    public $Version;

    /**
     * Objeto que contém a lista de possíveis erros.
     * 
     * @var \MundiPagg\Entity\ErrorReport 
     */
    public $ErrorReport;

}
