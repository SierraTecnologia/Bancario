<?php

namespace Bancario\Modules\Logic\Integrations\FraudAnalysis\Clearsale;


// Notificação de alteração de status

// Sempre que ocorrer alterações no status de um pedido, o Webhook da Clearsale irá enviar uma notificação para uma URL que deverá ser implementada no lado do integrador.
// Requisição

// POST {URL_DO_INTEGRADOR}
// Content-Type: application/json
// {
//     "code": "{CODIGO_DO_MEU_PEDIDO}",
//     "date": "2016-01-01T10:30:00.9931909-02:00",
//     "type": "status"
// }

// Os dados da alteração não serão informados na notificação do Webhook, portanto, fica a cargo do integrador o consumo da consulta de status.

// Importante: Se a URL do integrador retornar qualquer status http diferente de 200, o Webhook irá tentar notificar novamente para o pedido.

// Assim que a URL for desenvolvida é necessário que envie o endereço a equipe de integração através do e-mail integracao@clear.sale para que essa URL seja configurada na base da Clearsale.