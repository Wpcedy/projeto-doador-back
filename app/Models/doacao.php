<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class doacao extends Model
{
    const TIPO_DOACAO_UNICO = 'Único';
    const TIPO_DOACAO_BIMESTRAL = 'Bimestral';
    const TIPO_DOACAO_SEMESTRAL = 'Semestral';
    const TIPO_DOACAO_ANUAL = 'Anual';

    const TIPO_PAGAMENTO_DEBITO = 'Débito';
    const TIPO_PAGAMENTO_CREDITO = 'Crédito';

    const TIPO_BANDEIRA_VISA = 'Visa';
    const TIPO_BANDEIRA_MASTERCARD = 'Mastercard';
    const TIPO_BANDEIRA_ELO = 'Elo';
    const TIPO_BANDEIRA_HIPERCARD = 'Hipercard';
    const TIPO_BANDEIRA_AMERICANEXPRESS = 'AmericanExpress';


    protected $fillable = [
        'pessoa',
        'dtcadastro',
        'tpdoacao',
        'valor',
        'tppagamento',
        'conta',
        'bandeira',
        'cartaoinicio',
        'cartaofim',
    ];
}
