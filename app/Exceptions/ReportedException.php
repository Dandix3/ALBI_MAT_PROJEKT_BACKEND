<?php


namespace App\Exceptions;

use Exception;

/**
 * Class ReportedException
 *
 * Třída pro exceptiony, které vznikají v situaci, kterou je potřeba nahlásit uživatelli.
 * Nemá v tuto chvíli žádné zvláštní funkcionality (to, jakou response uživateli pošlu určuji podle typu třídy)
 * Předpokládám však, že nějaké funkcionality možná potřeba budou, proto jsem vytvořil tuto třídu.
 */
class ReportedException extends Exception {

}
