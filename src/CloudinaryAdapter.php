<?php
namespace Ashraafdev\CloudinaryLaravel;

use Cloudinary\Api\Admin\AdminApi;
use Cloudinary\Api\Exception\AuthorizationRequired;
use Cloudinary\Api\Upload\UploadApi;
use League\Flysystem\Config;
use League\Flysystem\FilesystemAdapter as FileSystemAdapter;
use Cloudinary\Configuration\Configuration;
use Ashraafdev\CloudinaryLaravel\Exception\FileSystemException;
use Exception;
use League\Flysystem\FileAttributes;
use Cloudinary\Api\Exception\NotFound;

class CloudinaryAdapter implements FileSystemAdapter {

    protected $configuration, $connectionConfig, $uploadInstance, $readInstance;

    public function __construct(array $connectionConfig)
    {
        $this->configuration = Configuration::instance($connectionConfig);
        $this->uploadInstance = (new UploadApi($this->configuration));
        $this->readInstance = (new AdminApi($this->configuration));
    }

    public function fileExists(string $path): bool
    {
        try {
            $this->readInstance->asset($path);
            return true;
        } catch (NotFound $e) {
            return false;
        }
    }

    public function directoryExists(string $path): bool
    {
        $rootFolders = $this->readInstance->rootFolders()['folders'];
        $listOfAllFolders = [];
       
        foreach ($rootFolders as $rootFolder) {
            $listOfAllFolders[] = $rootFolder['path'];
            $this->directoryExistsInSubFolder($rootFolder['path'], $listOfAllFolders);
        }
        
        return in_array($path, $listOfAllFolders);
    }

    public function directoryExistsInSubFolder(string $folder, array &$listOfAllFolders)
    {
        $subFolders = $this->readInstance->subFolders($folder)['folders'];

        foreach ($subFolders as $subFolder) {
            $listOfAllFolders[] = $subFolder['path'];
            $this->directoryExistsInSubFolder($subFolder['path'], $listOfAllFolders);
        }
    }

    public function write(string $path, string $contents, Config $config): void
    {
        dd('simple write function ran ok!');
        /* $this->writeStream($path, $contents, $config); */
    }

    public function writeStream(string $path, $contents, Config $config): void
    {
        dd('stream write function ran ok!');
        /* $this->uploadInstance->upload($contents, [
            'public_id' => $path,
        ]); */
    }

    public function read(string $path): string
    {
        dd($this->readInstance->ping());
        //return '';   
    }

    public function readStream(string $path)
    {
        dd($this->readInstance->ping());
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
     * @throws FileSystemException
     */
    public function createDirectory(string $path, Config $config = null): void
    {
        try {
            $this->readInstance->createFolder($path);
        } catch (Exception $e) {
            throw new FileSystemException($e->getMessage());
        }
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