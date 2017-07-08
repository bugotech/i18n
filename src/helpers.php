<?php

if (! function_exists('i18n')) {
    /**
     * Translate by i18n the given message.
     *
     * @param  string  $id
     * @param  array $parameters
     * @return \Bugotech\I18n\Translate|string
     */
    function i18n($id = null, array $parameters = [])
    {
        if (is_null($id)) {
            return app('i18n');
        }

        return app('i18n')->trans($id, $parameters);
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
     * @param string $id
     * @param array $parameters
     * @return \Bugotech\I18n\Translate|string
     */
    function trans($id = null, array $parameters = [])
    {
        return i18n($id, $parameters);
    }
}

if (! function_exists('trans_error')) {
    /**
     * Maker exception i18n.
     * @param $msg
     */
    function trans_error($msg)
    {
        i18n_error($msg);
    }
}