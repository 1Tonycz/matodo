<?php

namespace App\Presentation\Front\Components\Footer;

use Nette\Application\UI\Control;

class FooterControl extends Control
{
    public function render(): void
    {
        // případně můžeš předávat dynamické odkazy zvenku
        $this->template->links = [
            ['label' => 'Výlety',      'href' => '/#vylety'],
            ['label' => 'Transfer',    'href' => '/#transfer'],
            ['label' => 'Kontakt',     'href' => '/#kontakt'],
        ];

        $this->template->year = (int) date('Y');
        $this->template->render(__DIR__ . '/footer.latte');
    }

}