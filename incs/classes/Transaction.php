<?php

/**
* APIRosReestr.ru
* @link https://apirosreestr.ru/
* @author Dmitry Fomin
*/

class Transaction
{
    
    /**
    *
    * 
    * 
    * 
    * 
    */
    public function get_transaction_id(int $type, string $enc_obj, array $docs): int
    {
        switch ($type):
            case 1: return (new Cadaster())->request_two_orderings($enc_obj, $docs)['transaction_id']; break;
            case 2: return (new Cadaster())->get_owners($enc_obj, $docs)['transaction_id']; break;
            case 3: return (new Cadaster())->get_all_home_owners($enc_obj, $docs)['transaction_id']; break;
        endswitch;
    }
}