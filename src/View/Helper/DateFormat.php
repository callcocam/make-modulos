<?php
/**
 * Created by PhpStorm.
 * User: Claudio
 * Date: 03/10/2016
 * Time: 19:54
 */

namespace Make\View\Helper;


class DateFormat {

    protected $date;
    protected $datetime;
    public function __construct($_dia=null,$_mes=null,$_ano=null,$_semana=null,$_hora=null,$_minuto=null,$_segundo=null) {
        // leitura das datas
        $dia =$_dia?$_dia:date('d');
        $mes =$_mes?$_mes: date('m');
        $ano =$_ano?$_ano: date('Y');
        $semana =$_semana?$_semana: date('w');
        $hora =$_hora?$_hora: date('H');
        $minuto =$_minuto?$_minuto: date('m');
        $segundo =$_segundo?$_segundo: date('s');
        // configuração mes

        switch ($mes) {

            case 1: $mes = "JANEIRO";
                break;
            case 2: $mes = "FEVEREIRO";
                break;
            case 3: $mes = "MARÇO";
                break;
            case 4: $mes = "ABRIL";
                break;
            case 5: $mes = "MAIO";
                break;
            case 6: $mes = "JUNHO";
                break;
            case 7: $mes = "JULHO";
                break;
            case 8: $mes = "AGOSTO";
                break;
            case 9: $mes = "SETEMBRO";
                break;
            case 10: $mes = "OUTUBRO";
                break;
            case 11: $mes = "NOVEMBRO";
                break;
            case 12: $mes = "DEZEMBRO";
                break;
        }

        // configuração semana
        switch ($semana) {

            case 0: $semana = "DOMINGO";
                break;
            case 1: $semana = "SEGUNDA FEIRA";
                break;
            case 2: $semana = "TERÇA-FEIRA";
                break;
            case 3: $semana = "QUARTA-FEIRA";
                break;
            case 4: $semana = "QUINTA-FEIRA";
                break;
            case 5: $semana = "SEXTA-FEIRA";
                break;
            case 6: $semana = "SÁBADO";
                break;
        }
        $this->date="{$semana}, {$dia} DE {$mes} DE {$ano}";
        $this->datetime="{$semana}, {$dia} DE {$mes} DE {$ano} {$hora}:{$minuto}:{$segundo}";
    }
    public function getDate() {
        return $this->date;
    }
    public function getDatetime() {
        return $this->datetime;
    }
}
