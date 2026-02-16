<?php

namespace App\Presentation\Admin\Forms;

use Nette\Application\UI\Form;

final class TripFormFactory extends Form
{
    public function create(callable $onSuccess): Form
    {
        $form = new Form;

        $form->addHidden('id');

        $form->addFloat('price', 'Cena Bayahibe')
            ->setRequired('Zadejte cenu.');

        $form->addFloat('price_pc', 'Cena Punta Cana')
            ->setRequired('Zadejte cenu.');

        $form->addFloat('price_jd', 'Cena Juan Dolio')
            ->setRequired('Zadejte cenu.');

        $form->addFloat('cost', 'Náklady');

        $form->addText('title', 'Název')
            ->setRequired('Zadejte název výletu.');

        $form->addTextArea('description', 'Krátký popis')
            ->setRequired('Zadejte krátký popis.');

        $form->addTextArea('full_description', 'Plný popis')
            ->setRequired('Zadejte plný popis.');

        $form->addText('duration', 'Délka trvání')
            ->setRequired('Zadejte délku trvání.');

        $form->addInteger('groupSize', 'Velikost skupiny')
            ->setRequired('Zadejte velikost skupiny.');

        $form->addText('location', 'Lokalita')
            ->setRequired('Zadejte lokalitu.');

        $form->addUpload('image', 'Obrázek')
            ->addRule(Form::IMAGE, 'Nahraný soubor musí být obrázek.')
            ->addRule(Form::MAX_FILE_SIZE, 'Maximální velikost je 10 MB.', 10 * 1024 * 1024);

        $form->addTextArea('included', 'Zahrnuto (každý řádek = položka)')
            ->setRequired('Zadejte zahrnuté položky.');
        $form->addTextArea('not_included', 'Nezahrnuto (každý řádek = položka)')
            ->setRequired('Zadejte nezahrnuté položky.');

        $form->addSubmit('save', 'Uložit výlet');

        $form->onSuccess[] = $onSuccess;

        return $form;
    }

}