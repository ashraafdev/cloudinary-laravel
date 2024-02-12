<?php
namespace Ashraafdev\CloudinaryLaravel;

use Cloudinary\Api\Admin\AdminApi;
use Cloudinary\Api\Upload\UploadApi;
use League\Flysystem\Config;
use League\Flysystem\FilesystemAdapter as FileSystemAdapter;
use Cloudinary\Configuration\Configuration;
use League\Flysystem\FileAttributes;

class CloudinaryAdapter implements FileSystemAdapter {

    protected $configuration, $connectionConfig, $uploadInstance, $readInstance;

    public function __construct(array $connetionConfig)
    {
        $this->connectionConfig = $connetionConfig;
        $this->configuration = Configuration::instance($this->connectionConfig);

        $this->uploadInstance = (new UploadApi($this->configuration));
        $this->readInstance = (new AdminApi($this->configuration));
    }

    public function fileExists(string $path): bool
    {
        return false;
    }

    public function directoryExists(string $path): bool
    {
        return false;
    }

    public function write(string $path, string $contents, Config $config): void
    {
        $this->writeStream($path, $contents, $config);
    }

    public function writeStream(string $path, $contents, Config $config): void
    {
        $this->uploadInstance->upload($contents, [
            'public_id' => $path,
        ]);
    }

    public function read(string $path): string
    {
        return '';   
    }

    public function readStream(string $path)
    {
        return $this->readInstance->assetsByIds([$path]);
    }

    /**
     * @throws UnableToDeleteFile
     * @throws FilesystemException
     */
    public function delete(string $path): void {

    }

    /**
     * @throws UnableToDeleteDirectory
     * @throws FilesystemException
     */
    public function deleteDirectory(string $path): void {

    }

    /**
     * @throws UnableToCreateDirectory
     * @throws FilesystemException
     */
    public function createDirectory(string $path, Config $config): void
    {

    }

    /**
     * @throws InvalidVisibilityProvided
     * @throws FilesystemException
     */
    public function setVisibility(string $path, string $visibility): void
    {

    }

    /**
     * @throws UnableToRetrieveMetadata
     * @throws FilesystemException
     */
    public function visibility(string $path): FileAttributes
    {
        return new FileAttributes('', 0, null, null, null, []);
    }

    /**
     * @throws UnableToRetrieveMetadata
     * @throws FilesystemException
     */
    public function mimeType(string $path): FileAttributes
    {
        return new FileAttributes('', 0, null, null, null, []);
    }

    /**
     * @throws UnableToRetrieveMetadata
     * @throws FilesystemException
     */
    public function lastModified(string $path): FileAttributes
    {
        return new FileAttributes('', 0, null, null, null, []);
    }

    /**
     * @throws UnableToRetrieveMetadata
     * @throws FilesystemException
     */
    public function fileSize(string $path): FileAttributes
    {
        return new FileAttributes('', 0, null, null, null, []);
    }

    /**
     * @return iterable<StorageAttributes>
     *
     * @throws FilesystemException
     */
    public function listContents(string $path, bool $deep): iterable
    {
        return [];
    }

    /**
     * @throws UnableToMoveFile
     * @throws FilesystemException
     */
    public function move(string $source, string $destination, Config $config): void
    {

    }

    /**
     * @throws UnableToCopyFile
     * @throws FilesystemException
     */
    public function copy(string $source, string $destination, Config $config): void
    {

    }
}