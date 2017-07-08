<?php namespace Bugotech\I18n;

use Illuminate\Translation\Translator;

class Translate
{
    /**
     * @var array
     */
    protected $cache = [];

    /**
     * @var Translator
     */
    protected $translator;

    /**
     * @param Translator $translator
     */
    public function __construct(Translator $translator)
    {
        $this->translator = $translator;
    }

    /**
     * Traduzir.
     * @param $id
     * @param array $parameters
     * @return string
     */
    public function trans($id, array $parameters = [])
    {
        // Verificar se tem no cache
        if (array_key_exists($id, $this->cache)) {
            return $this->cache[$id];
        }

        // Traduzir o idioma
        $str = $this->translator->trans($id, $parameters);

        // Traduzir os jargões
        $str = jargon($str);

        return $this->cache[$id] = $str;
    }

    /**
     * @param $msg
     * @throws \Exception
     */
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

    /**
     * @return Translator
     */
    public function getTranslator()
    {
        return $this->translator;
    }

    /**
     * Retorna o locale atual.
     * @return string
     */
    public function getLocale()
    {
        return $this->translator->getLocale();
    }

    /**
     * Definir o locale atual.
     * @return void
     */
    public function setLocale($locale)
    {
        $this->translator->setLocale($locale);
    }
}