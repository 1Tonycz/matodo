<?php

namespace App\Domain\Trips;

use Nette\Http\FileUpload;

class TripImageStorage
{
    public function __construct(
        private string $wwwDir,
    ) {}

    public function save(FileUpload $image): array
    {
        $folder = bin2hex(random_bytes(5));
        $folderPath = $this->wwwDir . '/img/' . $folder;

        if (!is_dir($folderPath)) {
            mkdir($folderPath, 0777, true);
        }

        $name = $image->getSanitizedName();
        $image->move($folderPath . '/' . $name);

        return [$folder, $name];
    }

    public function delete(string $folder, string $name): void
    {
        $imagePath = $this->wwwDir . '/img/' . $folder . '/' . $name;

        if (is_file($imagePath)) {
            unlink($imagePath);
        }

        @rmdir($this->wwwDir . '/img/' . $folder);
    }
}