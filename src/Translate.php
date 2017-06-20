<?php namespace Bugotech\I18n;


class Translate
{
    /**
     * Traduzir.
     * @param $id
     * @return string
     */
    public function trans($id)
    {
        // Traduzir o idioma
        $str = trans($id);

        // Traduzir os jargões
        $str = jargon($str);

        return $str;
    }

    public function error($msg)
    {
        // Se msg for um objeto ou array deve fazer um print_r
        if (is_object($msg) || is_array($msg)) {
            $msg = print_r($msg, true);
        }

        // Traduzir
        $msg = $this->trans($msg);

        // TRocar parametros
        $args = func_get_args();
        $args[0] = $msg;
        $msg = trim(call_user_func_array('sprintf', $args));

        // Verificar se ultimo arguento é um codigo
        $code = $args[count($args) - 1];

        if (is_numeric($code)) {
            throw new \Exception($msg, $code);
        } else {
            throw new \Exception($msg);
        }
    }
}