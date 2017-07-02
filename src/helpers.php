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
     * @param null $id
     * @return \Bugotech\I18n\Translate|string
     */
    function trans($id = null)
    {
        return i18n($id);
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