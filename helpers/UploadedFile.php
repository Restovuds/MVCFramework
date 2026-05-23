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
}
