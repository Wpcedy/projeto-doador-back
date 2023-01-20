<?php

namespace App\Http\Controllers;

use App\Models\pessoa as PessoaModel;
use App\Models\doacao as DoacaoModel;
use Illuminate\Http\Request;

class AdicionarDoacaoController extends Controller
{
    public function index(Request $request)
    {
        $dataForm = $request->all();

        if ($dataForm['tppagamento'] == DoacaoModel::TIPO_PAGAMENTO_CREDITO) {
            $registros = DoacaoModel::where([
                'cartaoinicio' => $dataForm['cartaoinicio'],
                'cartaofim' => $dataForm['cartaofim']
            ])->get();

            if (count($registros) > 0) {
                return response()->json('Não foi possível cadastrar esse número de cartão, entre em contato com o seu supervisor.', 409);
            }
        }

        $doacao = $this->createRegistroDoacao($dataForm);

        return response()->json($doacao, 200);
    }

    protected function createRegistroDoacao(array $data)
    {
        $pessoa = $this->createPessoa($data);
        return $this->createDoacao($data, $pessoa['id']);
    }

    protected function createPessoa(array $data)
    {
        return PessoaModel::create([
            'nome' => $data['nome'],
            'email' => $data['email'],
            'cpf' => $data['cpf'],
            'telefone' => $data['telefone'],
            'dtnascimento' => new \DateTime($data['dtnascimento']),
            'endereco' => $data['endereco'],
        ]);
    }

    protected function createDoacao(array $data, int $pessoa)
    {
        $newDoacao = [
            'pessoa' => $pessoa,
            'dtcadastro' => new \DateTime(),
            'tpdoacao' => $this->defineTipoDoacao($data['tpdoacao']),
            'valor' => $data['valor'],
        ];

        $newDoacao = $this->defineTipoPagamento($newDoacao, $data['tppagamento'], $data['bandeira']);

        return DoacaoModel::create($newDoacao);
    }

    private function defineTipoDoacao(int $tipo){
        switch ($tipo) {
            case 1:
                return DoacaoModel::TIPO_DOACAO_UNICO;
                break;
            case 2:
                return DoacaoModel::TIPO_DOACAO_BIMESTRAL;
                break;
            case 3:
                return DoacaoModel::TIPO_DOACAO_SEMESTRAL;
                break;
            case 4:
                return DoacaoModel::TIPO_DOACAO_ANUAL;
                break;
        }
    }

    private function defineTipoPagamento(array $data, int $tipo, int $bandeira){
        switch ($tipo) {
            case 1:
                $data['tppagamento'] = DoacaoModel::TIPO_PAGAMENTO_DEBITO;
                $data['conta'] = $data['conta'];
                break;
            case 2:
                $data['tppagamento'] = DoacaoModel::TIPO_PAGAMENTO_CREDITO;
                $data['bandeira'] = $this->defineTipoBandeira($bandeira);
                $data['cartaoinicio'] = $data['cartaoinicio'];
                $data['cartaofim'] = $data['cartaofim'];
                break;
        }
        return $data;
    }

    private function defineTipoBandeira(int $tipo){
        switch ($tipo) {
            case 1:
                return DoacaoModel::TIPO_BANDEIRA_VISA;
                break;
            case 2:
                return DoacaoModel::TIPO_BANDEIRA_MASTERCARD;
                break;
            case 3:
                return DoacaoModel::TIPO_BANDEIRA_ELO;
                break;
            case 4:
                return DoacaoModel::TIPO_BANDEIRA_HIPERCARD;
                break;
            case 5:
                return DoacaoModel::TIPO_BANDEIRA_AMERICANEXPRESS;
                break;
        }
    }
}
