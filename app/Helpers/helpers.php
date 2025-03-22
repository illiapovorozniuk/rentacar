<?php

use Illuminate\Support\Facades\Storage;

function saveOrUpdateImage($file, string $directoryPath, string $fileName, string $action = 'store', string $oldFile = ''): string
{
    $fileName = $fileName . '.' . $file->getClientOriginalExtension();
    if ($action !== 'store') {
        if (Storage::disk('public')->exists($oldFile)) {
            Storage::disk('public')->delete($oldFile);
        }
    }
    // Store the file
    $file->storeAs($directoryPath, $fileName, 'public');
    return $directoryPath . '/' . $fileName;
}

function deleteImage(string $filePath): void
{
    if (Storage::disk('public')->exists($filePath)) {

        Storage::disk('public')->delete($filePath);
    }
}

?>
