<?php

namespace Bancario\Modules\Logic\Integrations\FraudAnalysis\Clearsale;

//https://api.clearsale.com.br/docs/tickets
//
//POST https://api.clearsale.com.br/v1/orders/
//Content-Type: application/json
//Authorization: Bearer {TOKEN}
//[{
//    "code": "ORDER_EXAMPLE_0_0_0_1",
//    "sessionID": "SessionIDValue",
//    "date": "2017-03-22T13:38:59",
//    "email": "email@email.com.br",
//    "itemValue": 10.00,
//    "totalValue": 15.00,
//    "ip": "192.168.0.1",
//    "giftMessage": "Message Example",
//    "observation": "Observation example",
//    "status": 0,
//    "origin": "Origin example",
//    "country": "Brasil",
//    "purchaseInformation": {
//        "lastDateInsertedMail": "2015-03-01T02:40:00",
//        "lastDateChangePassword": "2015-04-02T05:15:00",
//        "lastDateChangePhone": "2015-05-03T10:45:00",
//        "lastDateChangeMobilePhone": "2015-06-04T12:05:00",
//        "lastDateInsertedAddress": "2015-07-05T15:25:00",
//        "purchaseLogged": false,
//        "email": "email@email.com.br",
//        "login": "SocialNetworkLogin"
//    },
//    "billing": {
//        "clientID": "Client123",
//        "type": 1,
//        "primaryDocument": "12345678910",
//        "secondaryDocument": "12345678",
//        "name": "Complete Client Name",
//        "birthDate": "1990-01-10T00:00:00",
//        "email": "email@email.com.br",
//        "gender": "M",
//        "motherName": "Mother Name Example",
//        "address": {
//            "street": "Street name example",
//            "number": "0",
//            "additionalInformation": "Additional information example",
//            "county": "County Example",
//            "city": "City Example",
//            "state": "SP",
//            "zipcode": "12345678",
//            "country": "Brasil",
//            "reference": "Address reference example"
//        },
//        "phones": [{
//            "type": 1,
//            "ddi": 55,
//            "ddd": 11,
//            "number": 33333333,
//            "extension": "1111"
//        }]
//    },
//    "shipping": {
//        "clientID": "Client123",
//        "type": 1,
//        "primaryDocument": "12345678910",
//        "secondaryDocument": "12345678",
//        "name": "Complete Client Name",
//        "birthDate": "1990-01-10T00:00:00",
//        "email": "email@email.com.br",
//        "gender": "M",
//        "address": {
//            "street": "Street name example",
//            "number": "0",
//            "additionalInformation": "Additional information example",
//            "county": "County Example",
//            "city": "City Example",
//            "state": "SP",
//            "zipcode": "12345678",
//            "country": "Brasil",
//            "reference": "Address reference example"
//        },
//        "phones": [{
//            "type": 1,
//            "ddi": 55,
//            "ddd": 11,
//            "number": 33333333,
//            "extension": "1111"
//        }],
//        "deliveryType": "1",
//        "price": 5.00
//    },
//    "payments": [{
//        "sequential": 1,
//        "date": "2017-03-21T22:36:53",
//        "value": 80.00,
//        "type": 1,
//        "installments": 1,
//        "interestRate": 0.00,
//        "interestValue": 0.00,
//        "card": {
//            "number": "123456xxxxxx1234",
//            "hash": "12345678945612301234569874563210",
//            "bin": "123456",
//            "end": "1234",
//            "type": 1,
//            "validityDate": "02/2021",
//            "ownerName": "Owner Card Name",
//            "document": "12345678910",
//            "nsu": "12345"
//        }
//    }],
//    "tickets": [{
//        "convenienceFeeValue": 0.00,
//        "quantityFull": 500,
//        "quantityHalf": 250,
//        "batch": 12345,
//        "virtual": true,
//        "event": {
//            "id": "123456",
//            "name": "Event name exeample",
//            "local": "Event's place example",
//            "date": "2017-03-21T22:36:53",
//            "type": 1,
//            "genre": "Music concert",
//            "quantityTicketSale": 800,
//            "quantityEventHouse": 2,
//            "address": {
//                "street": "Street name example",
//                "number": "10",
//                "county": "County Example",
//                "city": "City Example",
//                "state": "SP",
//                "country": "Brasil",
//                "zipcode": "12345678"
//            }
//        },
//        "peoples": [{
//            "name": "Name example",
//            "legalDocument": "12345678910"
//        }],
//        "categories": [{
//            "name": "Category name example",
//            "quantity": 100,
//            "value": 100.00
//        }],
//        "additionalInformations": [{
//            "name": "Product name example",
//            "quantity": 5,
//            "value": 10.00
//        }]
//    }]
//}]
//
//
//
//Resposta:
//Content-Type: application/json
//Request-ID: 12J6-11B3-11A7-93C0
//{
//  "packageID": "4825dc1d-5246-45d3-ba32-d2de9bbff478",
//  "orders": [
//    {
//      "code": "{CODIGO_DO_MEU_PEDIDO}",
//      "status": "NVO",
//      "score": null
//    }
//  ]
//}
//
//
//
//
///////////////////////////////////////////////////////////////////
//
//
//
//Consulta de Status
//Requisição
//
//GET https://api.clearsale.com.br/v1/orders/{CODIGO_DO_MEU_PEDIDO}/status
//Accept: application/json
//Authorization: Bearer {TOKEN}
//
//Resposta
//
//Content-Type: application/json
//Request-ID: 12J6-11B3-11A7-93C0
//{
//  "code": "{CODIGO_DO_MEU_PEDIDO}",
//  "status": "AMA",
//  "score": 99.99
//}
//
//
//
//
//////////////////////////////////////////////////////////////////////
//
//
//Atualização de Status
//Requisição
//
//PUT https://api.clearsale.com.br/v1/orders/{CODIGO_DO_MEU_PEDIDO}/status
//Content-Type: application/json
//Authorization: Bearer {TOKEN}
//{
//    "status ": "Sigla do status"
//}
//
//
//
//Importante: Os status de atualização devem ser combinados com a equipe de integração.
//Marcação de Chargeback
//Requisição
//
//POST https://api.clearsale.com.br/v1/chargeback
//Content-Type: application/json
//Authorization: Bearer {TOKEN}
//{
//    "message" : "Message example",
//    "orders" : ["{ORDER_CODE}"]
//}
//
//Resposta
//
//Content-Type: application/json
//Request-ID: 12J6-11B3-11A7-93C0
//{
//    "code": "{CODIGO_DO_MEU_PEDIDO}",
//    "status": "Chargeback done"
//}
//
//Resolução de problemas
//
//Em todas as requisições realizadas será retornado uma chave no header chamada Request-ID, o valor desta chave conterá 19 caracteres, através de tal valor nosso suporte será capaz de capturar a sua transação e auxiliá-lo na resolução de algum problema.
//Tabelas código e descrição
//
//Tipo de telefone (billing/shipping.phone.type)
//
//Código     Descrição
//0     Não definido
//1     Residencial
//2     Comercial
//3     Recados
//4     Cobrança
//5     Temporário
//6     Celular
//Tipo pessoa (billing/shipping.type)
//
//Código     Descrição
//1     Pessoa Física
//2     Pessoa Jurídica
//Tipo de sexo (billing/shipping.gender)
//
//Código     Descrição
//M     Masculino
//F     Feminino
//Tipo de pagamento (payment.type)