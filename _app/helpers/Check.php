<?php

namespace App\Helpers;


/**
 * Check.class [ HELPER ]
 * Classe responável por manipular e validade dados do sistema!
 *
 * Escrito por: Mardônio de Melo Filho
 * Email: mardonio.quimico@gmail.com
 */
class Check
{

    private static $Data;
    private static $Format;

    /**
     * <b>Verifica E-mail:</b> Executa validação de formato de e-mail. Se for um email válido retorna true, ou retorna false.
     * @param STRING $Email = Uma conta de e-mail
     * @return BOOL = True para um email válido, ou false
     */
    public static function Email($Email)
    {
        self::$Data = (string)$Email;
        self::$Format = '/[a-z0-9_\.\-]+@[a-z0-9_\.\-]*[a-z0-9_\.\-]+\.[a-z]{2,4}$/';

        if (preg_match(self::$Format, self::$Data)):
            return true;
        else:
            return false;
        endif;
    }

    /**
     * <b>Tranforma URL:</b> Tranforma uma string no formato de URL amigável e retorna o a string convertida!
     * @param STRING $Name = Uma string qualquer
     * @return STRING = $Data = Uma URL amigável válida
     */
    public static function Name($Name)
    {
        self::$Format = array();
        self::$Format['a'] = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]/?;:.,\\\'<>°ºª';
        self::$Format['b'] = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                                 ';

        self::$Data = strtr(utf8_decode($Name), utf8_decode(self::$Format['a']), self::$Format['b']);
        self::$Data = strip_tags(trim(self::$Data));
        self::$Data = str_replace(' ', '-', self::$Data);
        self::$Data = str_replace(array('-----', '----', '---', '--'), '-', self::$Data);

        return strtolower(utf8_encode(self::$Data));
    }

    /**
     * <b>Tranforma Data:</b> Transforma uma data no formato DD/MM/YY em uma data no formato TIMESTAMP!
     * @param STRING $Name = Data em (d/m/Y) ou (d/m/Y H:i:s)
     * @return STRING = $Data = Data no formato timestamp!
     */
    public static function Data($Data)
    {
        self::$Format = explode(' ', $Data);
        self::$Data = explode('/', self::$Format[0]);

        if (empty(self::$Format[1])):
            self::$Format[1] = date('H:i:s');
        endif;

        self::$Data = self::$Data[2] . '-' . self::$Data[1] . '-' . self::$Data[0] . ' ' . self::$Format[1];
        return self::$Data;
    }

    /**
     * <b>Limita os Palavras:</b> Limita a quantidade de palavras a serem exibidas em uma string!
     * @param STRING $String = Uma string qualquer
     * @return INT = $Limite = String limitada pelo $Limite
     */
    public static function Words($String, $Limite, $Pointer = null)
    {
        self::$Data = strip_tags(trim($String));
        self::$Format = (int)$Limite;

        $ArrWords = explode(' ', self::$Data);
        $NumWords = count($ArrWords);
        $NewWords = implode(' ', array_slice($ArrWords, 0, self::$Format));

        $Pointer = (empty($Pointer) ? '...' : ' ' . $Pointer);
        $Result = (self::$Format < $NumWords ? $NewWords . $Pointer : self::$Data);
        return $Result;
    }

    /**
     * <b>Subtrai Porcentagem:</b> Subtrai porecentagem do valor base
     * @param INT $pctg Porcentagem
     * @param INT $total Valor menos a porecentagem
     * @return INT Valor mais a porcentagem
     */
    public static function pctgSub($pctg, $total)
    {
        $result = $total - (($total / 100) * $pctg);
        return $result;
    }

    /**
     * <b>Soma Porcentagem:</b> Soma porcentagem ao valor base
     * @param INT $pctg Porcentagem
     * @param INT $total Valor base
     * @return INT Valor mais a porcentagem
     */
    public static function pctgSum($pctg, $total)
    {
        $result = (($total / 100) * $pctg) + $total;
        return $result;
    }

    /**
     * <b>Porcentagem Equivalente:</b> Calcula porcentagem equivalente ao valor base
     * @param INT $pctg Porcentagem
     * @param INT $total Valor base
     * @return INT Porcentagem em valor
     */
    public static function pctgEquiv($pctg, $total)
    {
        $result = ($total / 100) * $pctg;
        return $result;
    }

    /**
     * @param STRING $v Descrição: Converte Real para Décimal
     * @return INT
     */
    public static function convertDec($v)
    {
        return str_replace(',', '.', str_replace('.', '', $v));
    }

    /**
     * @param STRING $v Descrição: Converte Decimal para Real
     * @return INT
     */
    public static function formatReal($v)
    {
        return number_format($v, 2, ",", ".");
    }

    /**
     * @param STRING $v Descrição: Informe o comprimento e a largura para obter a área. Ex.: "1.500x1.1.200"
     * @return INT Valor da área em milimetros quadrados
     */
    public static function calcArea($v)
    {
        $valorAreaMed = explode('x', $v);
        $valorAreaQuad = self::convertDec($valorAreaMed[0]) * self::convertDec($valorAreaMed[0]); //calculo da área de referencia
        return $valorAreaQuad;
    }

    /**
     * @return boolean Retorna true se a requisição for POST
     */
    public static function checkRequestMethod()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $request = true;
        } else {
            $request = false;
        }
        return $request;
    }

    /**
     * @param $date
     * @return false|string
     */
    public static function viewDateDefault($date)
    {
        $result = $date === '' ? '***' : date('d/m/Y H:i', strtotime($date));
        return $result;
    }

    /**
     * @return float|int
     */
    public static function timeLink()
    {
        return floor(date('dmYHi')) + 100;
    }

    /**
     * Calculo de diferença em dias de duas datas
     * @param $data1
     * @param $data2
     * @param bool $notNegative = informe true para retornadar a valor positivo
     * @return float|int
     */
    public static function diffDaysDate($data1, $data2, $notNegative = false)
    {
        // converte as datas para o formato timestamp
        $d1 = strtotime($data1);
        $d2 = strtotime($data2);

        // verifica a diferença em segundos entre as duas datas e divide pelo número de segundos que um dia possui
        $dataFinal = ($d2 - $d1) / 86400;

        // caso a data 2 seja menor que a data 1
        if ($dataFinal < 0 && $notNegative === true):
            $dataFinal = $dataFinal * -1;
        endif;

        return $dataFinal;
    }

    /**
     * Retira tags e espações das strings de um array
     * @param $data
     * @return array
     */
    public static function mapData($data)
    {
        $data = array_map('strip_tags', $data);
        $data = array_map('trim', $data);
        return $data;
    }

    /**
     * Formata número de telefone para link
     * @param $data
     * @return string
     */
    public static function formatTelLink($data)
    {
        $data = str_replace('-', '', self::Name($data));
        return $data;
    }

    /**
     * Converte porcentagem de desconto em número
     * @param $percent
     * @return float
     */
    public static function convetDesNum($percent)
    {
        return str_replace(',', '.', explode('%', $percent)[0]);
    }

    /**
     * @return string
     */
    public static function limitWord($str, $limit)
    {
        return mb_strimwidth($str, 0, $limit, "...");
    }

    /**
     * @param $nasc = Informe a data de nascimento do fulano
     * @return false|float
     */
    public static function idadeAno($nasc)
    {
        // Separa em dia, mês e ano
        list($dia, $mes, $ano) = explode('/', $nasc);

        // Descobre que dia é hoje e retorna a unix timestamp
        $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        // Descobre a unix timestamp da data de nascimento do fulano
        $nascimento = mktime(0, 0, 0, $mes, $dia, $ano);

        // Depois apenas fazemos o cálculo
        $idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);
        return $idade;
    }

    /**
     * @param $m = número referente ao mês
     * @return string
     */
    public static function nameMes($m)
    {
        $meses = [
            1 => "Janeiro",
            2 => "Fevereiro",
            3 => "Março",
            4 => "Abril",
            5 => "Maio",
            6 => "Junho",
            7 => "Julho",
            8 => "Agosto",
            9 => "Setembro",
            10 => "Outubro",
            11 => "Novembro",
            12 => "Dezembro"
        ];

        $mes = array_key_exists((int)$m, $meses) ? $meses[(int)$m] :
            'Número referente ao mês não existe ou está incorreto';

        return $mes;
    }

    /**
     * @param $phone
     * @return string
     */
    public static function formatPhone($phone)
    {
        $formatedPhone = preg_replace('/[^0-9]/', '', $phone);
        $matches = [];
        preg_match('/^([0-9]{2})([0-9]{4,5})([0-9]{4})$/', $formatedPhone, $matches);
        if ($matches) {
            return '(' . $matches[1] . ') ' . $matches[2] . '-' . $matches[3];
        }

        return $phone; // return number without format
    }

}
