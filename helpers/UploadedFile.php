<?php

namespace helpers;

class UploadedFile
{
    public function __construct(
        public readonly string $name,
        public readonly string $clientType,
        public readonly string $tmpName,
        public readonly int    $size,
        public readonly int    $error,
    ) {}

    public static function createFromFiles(array $entry): array
    {
        if (!isset($entry['name'])) {
            return [];
        }

        if (is_array($entry['name'])) {
            $files = [];
            foreach ($entry['name'] as $i => $name) {
                if ($entry['error'][$i] === UPLOAD_ERR_NO_FILE) {
                    continue;
                }
                $files[] = new self(
                    name:       (string)$name,
                    clientType: (string)($entry['type'][$i] ?? ''),
                    tmpName:    (string)($entry['tmp_name'][$i] ?? ''),
                    size:       (int)($entry['size'][$i] ?? 0),
                    error:      (int)($entry['error'][$i] ?? UPLOAD_ERR_NO_FILE),
                );
            }
            return $files;
        }

        if ($entry['error'] === UPLOAD_ERR_NO_FILE) {
            return [];
        }

        return [new self(
            name:       (string)$entry['name'],
            clientType: (string)($entry['type'] ?? ''),
            tmpName:    (string)($entry['tmp_name'] ?? ''),
            size:       (int)($entry['size'] ?? 0),
            error:      (int)($entry['error'] ?? UPLOAD_ERR_NO_FILE),
        )];
    }

    public function isOk(): bool
    {
        return $this->error === UPLOAD_ERR_OK && is_uploaded_file($this->tmpName);
    }

    /**
     * Real MIME type detected from file contents (not the client-provided header).
     */
    public function getMimeType(): ?string
    {
        if (!is_file($this->tmpName)) {
            return null;
        }
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($this->tmpName);
        return $mime !== false ? $mime : null;
    }

    public function getClientExtension(): string
    {
        return strtolower(pathinfo($this->name, PATHINFO_EXTENSION));
    }

    public function getExtension(): string
    {
        $array = explode('.', $this->name);
        return end($array);
        // return strtolower(pathinfo($this->tmpName, PATHINFO_EXTENSION)); not working
    }

    public function getUploadErrorMessage(): string
    {
        return match ($this->error) {
            UPLOAD_ERR_OK         => '',
            UPLOAD_ERR_INI_SIZE,
            UPLOAD_ERR_FORM_SIZE  => 'The uploaded file exceeds the allowed size.',
            UPLOAD_ERR_PARTIAL    => 'The file was only partially uploaded.',
            UPLOAD_ERR_NO_FILE    => 'No file was uploaded.',
            UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary folder on the server.',
            UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
            UPLOAD_ERR_EXTENSION  => 'A PHP extension stopped the file upload.',
            default               => 'Unknown upload error.',
        };
    }

    public function save(?string $name = null, ?string $path = null): bool
    {
        return false;
    }

    public static function uploadFile(self $file): false|string
    {
        $ext = $file->getExtension();
        $dir = '/' . date('Y/m/d');

        try {
            self::createDirIfNotExists($dir);
            $file_name = md5($file->name . uniqid()) . '.' . $ext;
            $file_path = UPLOADS . $dir . DIRECTORY_SEPARATOR . $file_name;

            if (move_uploaded_file($file->tmpName, $file_path)) {
                return '/uploads' . $dir . '/' . $file_name;
            } else {
                throw new \Exception('Failed to move uploaded file.');
            }
        } catch (\Throwable $e) {
            error_log('['.date('Y-m-d H:i:s').'] ' . $e->getMessage());
            return false;
        }

    }

    public static function createDirIfNotExists($path): void
    {
        if (!is_dir(UPLOADS . $path)) {
            mkdir(UPLOADS . $path, 0775, true);
        }
    }
}
