<?php

namespace Ocore\validation\validators;

use helpers\FileHelper;
use helpers\MimeTypes;
use helpers\UploadedFile;

class FileValidator extends BaseValidator
{
    private int   $maxFileSize        = 5 * 1024 * 1024; // bytes
    private int   $maxFiles           = 1;
    private array $allowedMimeTypes   = [];
    private bool  $onlySupportedTypes = false;
    private bool  $errorOnEachFile    = false;

    /** @var string[] Collected error messages for getErrorMessage() */
    private array $collectedErrors = [];

    public function __construct($model, $config = [])
    {
        if (isset($config['maxSize'])) {
            if (!is_numeric($config['maxSize'])) {
                throw new \InvalidArgumentException('Invalid maxSize value passed to FileValidator.');
            }
            $this->maxFileSize = (int)$config['maxSize'];
        }

        if (isset($config['maxFiles'])) {
            if (!is_numeric($config['maxFiles']) || (int)$config['maxFiles'] < 1) {
                throw new \InvalidArgumentException('Invalid maxFiles value passed to FileValidator.');
            }
            $this->maxFiles = (int)$config['maxFiles'];
        }

        if (isset($config['extensions'])) {
            $exts = is_string($config['extensions']) ? [$config['extensions']] : $config['extensions'];
            if (!is_array($exts) || !array_all($exts, 'is_string')) {
                throw new \InvalidArgumentException('Invalid extensions value passed to FileValidator.');
            }
            $this->allowedMimeTypes = $exts;
        }

        $this->onlySupportedTypes = !empty($config['onlySupportedExtensions']);
        $this->errorOnEachFile    = !empty($config['errorOnEachFile']);

        parent::__construct($model, $config);
    }

    public function validate(mixed $value, ?string $attribute = null): bool
    {
        // Skip if a previous rule (e.g. required) already failed for this attribute.
        if (key_exists($attribute, $this->model->getErrors())) {
            return true;
        }

        $files = $this->normalizeToList($value);

        if (count($files) === 0) {
            // Empty input is not this validator's concern — `required` handles it.
            return true;
        }

        if (count($files) > $this->maxFiles) {
            $this->collectedErrors[] = "Too many files. Maximum allowed: {$this->maxFiles}.";
            return false;
        }

        $allValid = true;
        foreach ($files as $file) {
            $error = $this->validateFile($file);
            if ($error !== null) {
                $allValid = false;
                $this->collectedErrors[] = $error;
                if (!$this->errorOnEachFile) {
                    return false;
                }
            }
        }

        return $allValid;
    }

    private function validateFile(UploadedFile $file): ?string
    {
        if (!$file->isOk()) {
            return $this->labelFor($file) . ': ' . $file->getUploadErrorMessage();
        }

        if ($file->size > $this->maxFileSize) {
            return $this->labelFor($file) . ' size is too large. Maximum: '
                . FileHelper::formatBytes($this->maxFileSize, 'MB') . '.';
        }

        $realMime = $file->getMimeType();
        if ($realMime === null) {
            return $this->labelFor($file) . ': unable to detect file type.';
        }

        if ($this->onlySupportedTypes && !in_array($realMime, MimeTypes::getKnownMimeTypes(), true)) {
            return $this->labelFor($file) . ': unsupported file type (' . $realMime . ').';
        }

        if (!empty($this->allowedMimeTypes)) {
            if (!in_array($realMime, $this->allowedMimeTypes, true)) {
                return $this->labelFor($file) . ' has a disallowed type. Allowed: '
                    . $this->humanAllowedExtensions() . '.';
            }

            $clientExt = $file->getClientExtension();
            $allowedExts = array_filter(array_map(
                fn($mime) => MimeTypes::getExtensionByMimeType($mime),
                $this->allowedMimeTypes
            ));
            if ($clientExt === '' || !in_array($clientExt, $allowedExts, true)) {
                return $this->labelFor($file) . ' has a disallowed extension. Allowed: '
                    . implode(', ', $allowedExts) . '.';
            }
        }

        return null;
    }

    private function normalizeToList(mixed $value): array
    {
        if ($value instanceof UploadedFile) {
            return [$value];
        }
        if (is_array($value)) {
            if (!empty($value) && $value[array_key_first($value)] instanceof UploadedFile) {
                return array_values($value);
            }
            if (isset($value['name']) || isset($value['error'])) {
                return UploadedFile::createFromFiles($value);
            }
        }
        return [];
    }

    private function labelFor(UploadedFile $file): string
    {
        return "File '{$file->name}'";
    }

    private function humanAllowedExtensions(): string
    {
        $exts = array_filter(array_map(
            fn($mime) => MimeTypes::getExtensionByMimeType($mime),
            $this->allowedMimeTypes
        ));
        return implode(', ', $exts);
    }

    public function getErrorMessage($attribute, $value): string
    {
        if ($this->useCustomMessage) {
            return parent::getErrorMessage($attribute, $value);
        }
        if (empty($this->collectedErrors)) {
            return parent::getErrorMessage($attribute, $value);
        }
        return implode(' ', $this->collectedErrors);
    }
}