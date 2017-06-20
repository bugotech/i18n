<?php

if (! function_exists('i18n')) {
    /**
     * Translate by i18n the given message.
     *
     * @param  string  $id
     * @return \Bugotech\I18n\Translate|string
     */
    function i18n($id = null)
    {
        if (is_null($id)) {
            return app('i18n');
        }

        return app('i18n')->trans($id);
    }
}

if (! function_exists('i18n_error')) {
    /**
     * Maker exception i18n.
     * @param $msg
     */
    function i18n_error($msg)
    {
        i18n()->error($msg);
    }
}

if (! function_exists('trans')) {
    /**
     * Translate the given message.
     *
     * @param  string  $id
     * @param  array   $replace
     * @param  string  $locale
     * @return \Symfony\Component\Translation\TranslatorInterface|string
     */
    function trans($id = null, $replace = [], $locale = null)
    {
        if (is_null($id)) {
            return app('translator');
        }

        return app('translator')->trans($id, $replace, 'messages', $locale);
    }
}

if (! function_exists('trans_choice')) {
    /**
     * Translates the given message based on a count.
     *
     * @param  string  $id
     * @param  int|array|\Countable  $number
     * @param  array   $parameters
     * @param  string  $domain
     * @param  string  $locale
     * @return string
     */
    function trans_choice($id, $number, array $parameters = [], $domain = 'messages', $locale = null)
    {
        return app('translator')->transChoice($id, $number, $parameters, $domain, $locale);
    }
}