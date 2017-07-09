<?php namespace Bugotech\I18n;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
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
     * @param string $id
     * @param array $parameters
     * @param string $domain
     * @return string
     */
    public function trans($id, array $parameters = [], $domain = 'messages')
    {
        // Verificar se tem no cache
        if (array_key_exists($id, $this->cache)) {
            return $this->makeReplacements($this->cache[$id], $parameters);
        }

        // Verificar se deve incorporar domain no id
        if (! Str::is('*.*', $id)) {
            $id = sprintf('%s.%s', $domain, $id);
        }

        // Traduzir o idioma
        $str = $this->translator->trans($id);

        // Traduzir os jargões
        $str = jargon($str);

        // Guardar do cache
        $this->cache[$id] = $str;

        return $this->makeReplacements($str, $parameters);
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

        // Trocar parametros
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

    /**
     * Make the place-holder replacements on a line.
     *
     * @param  string  $line
     * @param  array   $replace
     * @return string
     */
    protected function makeReplacements($line, array $replace)
    {
        if (! is_string($line)) {
            return $line;
        }

        // Ordernar replaces
        $replace = (new Collection($replace))->sortBy(function ($value, $key) {
            return mb_strlen($key) * -1;
        });

        // Fazer a troca
        foreach ($replace as $key => $value) {
            $line = str_replace(
                [':' . $key, ':' . Str::upper($key), ':' . Str::ucfirst($key)],
                [$value, Str::upper($value), Str::ucfirst($value)],
                $line
            );
        }

        return $line;
    }
}