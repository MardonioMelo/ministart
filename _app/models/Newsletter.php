<?php

namespace App\Models;

use App\Helpers\Check;
use CoffeeCode\DataLayer\DataLayer;

/**
 * Respnsável por gerenciar o Newsletter do siste
 *
 * Escrito por: Mardônio de Melo Filho
 * Email: mardonio.quimico@gmail.com
 */
class Newsletter extends DataLayer
{

    private $Data;
    private $Subscri;
    private $Error;
    private $Result;

    //Nome da tabela no banco de dados
    const Entity = 'sm_newsletter';

    public function __construct()
    {
        parent::__construct(self::Entity, [], "newsletter_id", false);
    }

    /**
     * <b>Cadastrar</b> Envelope os dados em um array atribuitivo e execute esse método
     * para cadastrar o mesmo no sistema.
     * @param array $Data = Atribuitivo
     */
    public function ExeCreate(array $Data)
    {
        $this->Data = $Data;
        $this->mapData();
        $this->valData();

        if($this->getResult()){
            $this->Create();
        }
    }

    /**
     * <b>Ler:</b> Informe o ID da inscrição para consultar os dados!
     * @param $id
     */
    public function ExeRead($id)
    {
        $this->Subscri = (int)$id;
        $this->Read();
    }

    /**
     * <b>Verificar Cadastro:</b> Retorna TRUE se o cadastro ou update for efetuado ou FALSE se não.
     * Para verificar erros execute um getError();
     * @return BOOL $Var = True or False
     */
    public function getResult()
    {
        return $this->Result;
    }

    /**
     * <b>Obter Erro:</b> Retorna um array associativo com um erro e um tipo.
     * @return array $Error = Array associatico com o erro
     */
    public function getError()
    {
        return $this->Error;
    }

    /*
     * ***************************************
     * **********  PRIVATE METHODS  **********
     * ***************************************
     */

    private function mapData()
    {
        $this->Data = array_map('strip_tags', $this->Data);
        $this->Data = array_map('trim', $this->Data);
    }

    private function valData()
    {
        if (Check::Email($this->Data['email'])) {
            $this->Data['newsletter_email'] = $this->Data['email'];
            unset($this->Data['email']);
            $this->Result = true;
        } else {
            $this->Error = "Opss, informe um e-mail valido!";
            $this->Result = false;
        };
    }

    /**
     * Cadasrtra!
     */
    private function Create()
    {
        $Create = new CrudPDO;
        $this->Data['newsletter_registration'] = date('Y-m-d H:i:s');
        $Create->ExeCreate(self::Entity, $this->Data);
        if ($Create->getResult()):
            $this->Error = "Sua inscrição para receber as Últimas Notícias foi 100% confirmada. Seja bem-vind(a)!";
            $this->Result = true;
        endif;
    }

}
