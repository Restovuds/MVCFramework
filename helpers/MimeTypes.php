<?php

namespace helpers;

class MimeTypes
{
    public const string MIME_IMAGE_PNG = 'image/png';
    public const string MIME_IMAGE_JPG = 'image/jpg';
    public const string MIME_IMAGE_JPEG = 'image/jpeg';
    public const string MIME_IMAGE_GIF = 'image/gif';
    public const string MIME_IMAGE_SVG = 'image/svg+xml';
    public const string MIME_IMAGE_WEBP = 'image/webp';
    public const string MIME_AUDIO_MP3 = 'audio/mpeg';
    public const string MIME_AUDIO_OGG = 'audio/ogg';
    public const string MIME_AUDIO_WAV = 'audio/wav';
    public const string MIME_VIDEO_MP4 = 'video/mp4';
    public const string MIME_VIDEO_OGG = 'video/ogg';
    public const string MIME_VIDEO_WEBM = 'video/webm';
    public const string MIME_TEXT_PLAIN = 'text/plain';
    public const string MIME_TEXT_HTML = 'text/html';
    public const string MIME_TEXT_CSS = 'text/css';
    public const string MIME_TEXT_CSV = 'text/csv';
    public const string MIME_TEXT_XML = 'text/xml';
    public const string MIME_APPLICATION_PDF = 'application/pdf';
    public const string MIME_APPLICATION_MSWORD = 'application/msword';
    public const string MIME_APPLICATION_EXCEL = 'application/vnd.ms-excel';
    public const string MIME_APPLICATION_POWERPOINT = 'application/vnd.ms-powerpoint';
    public const string MIME_APPLICATION_ZIP = 'application/zip';
    public const string MIME_APPLICATION_RAR = 'application/x-rar-compressed';
    public const string MIME_APPLICATION_7Z = 'application/x-7z-compressed';
    public const string MIME_APPLICATION_TAR = 'application/x-tar';
    public const string MIME_APPLICATION_GZIP = 'application/gzip';
    public const string MIME_APPLICATION_BZIP2 = 'application/x-bzip2';

    protected const array MIME_TO_EXTENSION_MAP = [
        self::MIME_IMAGE_PNG => 'png',
        self::MIME_IMAGE_JPG => 'jpg',
        self::MIME_IMAGE_JPEG => 'jpeg',
        self::MIME_IMAGE_GIF => 'gif',
        self::MIME_IMAGE_SVG => 'svg',
        self::MIME_IMAGE_WEBP => 'webp',
        self::MIME_AUDIO_MP3 => 'mp3',
        self::MIME_AUDIO_OGG => 'ogg',
        self::MIME_AUDIO_WAV => 'wav',
        self::MIME_VIDEO_MP4 => 'mp4',
        self::MIME_VIDEO_OGG => 'ogg',
        self::MIME_VIDEO_WEBM => 'webm',
        self::MIME_TEXT_PLAIN => 'txt',
        self::MIME_TEXT_HTML => 'html',
        self::MIME_TEXT_CSS => 'css',
        self::MIME_TEXT_CSV => 'csv',
        self::MIME_TEXT_XML => 'xml',
        self::MIME_APPLICATION_PDF => 'pdf',
        self::MIME_APPLICATION_MSWORD => 'doc',
        self::MIME_APPLICATION_EXCEL => 'xls',
        self::MIME_APPLICATION_POWERPOINT => 'ppt',
        self::MIME_APPLICATION_ZIP => 'zip',
        self::MIME_APPLICATION_RAR => 'rar',
        self::MIME_APPLICATION_7Z => '7z',
        self::MIME_APPLICATION_TAR => 'tar',
        self::MIME_APPLICATION_GZIP => 'gz',
        self::MIME_APPLICATION_BZIP2 => 'bz2',
    ];

    /**
     * List of all known MIME types.
     */
    public static function getKnownMimeTypes(): array
    {
        return array_keys(self::MIME_TO_EXTENSION_MAP);
    }

    /**
     * Resolve a MIME type to its canonical extension.
     * Returns null when the MIME type is unknown (caller decides on a fallback).
     */
    public static function getExtensionByMimeType(string $mimeType): ?string
    {
        return self::MIME_TO_EXTENSION_MAP[$mimeType] ?? null;
    }
}
