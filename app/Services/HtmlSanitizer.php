<?php

namespace App\Services;

use HTMLPurifier;
use HTMLPurifier_Config;

class HtmlSanitizer
{
    private HTMLPurifier $purifier;

    public function __construct()
    {
        $config = HTMLPurifier_Config::createDefault();

        /*
         * Allowlist dell'HTML legittimo prodotto dall'editor.
         * Tag come script, iframe e attributi JavaScript non sono consentiti.
         */
        $config->set(
            'HTML.Allowed',
            'p,br,strong,b,em,i,u,s,' .
            'ul,ol,li,blockquote,' .
            'h2,h3,h4,' .
            'a[href|title|target|rel],' .
            'table,thead,tbody,tr,th,td'
        );

        /*
         * Nei link sono accettati soltanto protocolli esplicitamente previsti.
         * Schemi pericolosi come javascript: vengono rifiutati.
         */
        $config->set('URI.AllowedSchemes', [
            'http' => true,
            'https' => true,
            'mailto' => true,
        ]);

        $config->set('Attr.AllowedFrameTargets', ['_blank']);

        $this->purifier = new HTMLPurifier($config);
    }

    public function clean(?string $html): string
    {
        return $this->purifier->purify($html ?? '');
    }
}