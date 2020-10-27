<?php
namespace App\Lib;

class Utils {

    public function num2lit($valor){
        if($valor == 10)
            return 'DIEZ, CERO CERO';
        
        if($valor == 0)
            return 'CERO, CERO CERO';

        $numero = explode('.', $valor);
        if (count($numero)>1){
            $entero = $numero[0];
            $decimal = $numero[1];
        }else{
            $entero = $numero[0];
            $decimal = '00';
        }
        $literal = $this->literal($entero) . ',';
        
        foreach(str_split($decimal) as $n){
            $literal .= ' ' . $this->literal($n);

        }

        return $literal;
    }

    public function literal($numero) {
        switch ($numero) {
            case '0':
                return 'CERO';
            break;
            case'1':
                return 'UNO';
            break;
            case'2':
                return 'DOS';
            break;
            case'3':
                return 'TRES';
            break;
            case'4':
                return 'CUATRO';
            break;
            case'5':
                return 'CINCO';
            break;
            case'6':
                return 'SEIS';
            break;
            case'7':
                return 'SIETE';
            break;
            case'8':
                return 'OCHO';
            break;
            case'9':
                return 'NUEVE';
            break;
            case '10':
                return 'DIEZ';
            break;
            default:
                return ',';
            break;
        }
    }
}
