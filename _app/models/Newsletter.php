<?php

namespace App\Models;

use App\Conn\TableNewsletter;
use App\Helpers\Check;


/**
 * Respnsável por gerenciar o Newsletter do siste
 *
 * Escrito por: Mardônio de Melo Filho
 * Email: mardonio.quimico@gmail.com
 */
class Newsletter
{
    private $Data;
    private $Error;
    private $Result;

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

        if ($this->getResult()) {
            $this->create();
        }
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
            $this->Result = true;
        } else {
            $this->Error = "Opss, informe um e-mail valido!";
            $this->Result = false;
        };
    }

    /**
     * Cadastra email
     */
    private function create()
    {
        $crud = new TableNewsletter();
        $crud->newsletter_email = $this->Data['email'];

        if ($crud->save()) {
            $this->Error = "Sua inscrição para receber as Últimas Notícias foi 100% confirmada. Seja bem-vind(a)!";
            $this->Result = true;
        } else {
            $this->Error = $crud->fail()->getMessage();
            $this->Result = false;
        }
    }

}
