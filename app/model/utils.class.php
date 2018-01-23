<?php

    class utils{

        function tirarAcentos($string){
            return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$string);
        }

        function montaCaminhoImagem($universidade, $materia, $foto, $caminho){
            return $caminho. $this->tirarAcentos($universidade) ."/".$this->tirarAcentos($materia)
            ."/".$foto;
        }

        function montaAltImagem($universidade, $materia, $id_foto){
            return $universidade." ".$materia." ".$id_foto;
        }

        function cortaString($text, $tam){
            if(strlen($text) > $tam){
                return substr($text, 0, $tam).'.';
            }
            return substr($text, 0, $tam);
        }
    }

?>