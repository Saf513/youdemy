<?php

class FileUploader
{
    private string $uploadDir;

    public function __construct(string $uploadDir)
    {
        $this->uploadDir = $uploadDir;
        if(!is_dir($this->uploadDir)){
            mkdir($this->uploadDir, 0777, true);
        }
    }

    public function uploadFile(array $file): string|bool
    {
        if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
            return false;
        }

        $filename = $file['name'];
        $tempPath = $file['tmp_name'];
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $uniqueFilename = uniqid() . '.' . $extension;
        $targetPath = $this->uploadDir . $uniqueFilename;

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'txt','mp4'];

        if (!in_array($extension, $allowedExtensions)) {
            return false;
        }

        if (move_uploaded_file($tempPath, $targetPath)) {
            return $uniqueFilename;
        }

        return false;
    }


    public function deleteFile(string $filename): void
    {
         $filePath = $this->uploadDir . $filename;
         if(file_exists($filePath)){
            unlink($filePath);
        }
    }
}