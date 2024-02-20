<?php

namespace AshraafDev\Tests\CloudinaryLaravel;

use Ashraafdev\CloudinaryLaravel;
use Ashraafdev\CloudinaryLaravel\CloudinaryAdapter;
use Ashraafdev\CloudinaryLaravel\Exception\FileSystemException;
use PHPUnit\Framework\TestCase;

class CloudinaryAdapterTest extends TestCase
{
    /* public function testTrueIsTrue() {
        return $this->assertTrue(true);
    } */

    /*
        testing functionnality of fileExists
    */

    public function testFileExistsReturnTrue()
    {
        $cloudinaryAdapter1 = new CloudinaryAdapter([
            "cloud" => [
                "cloud_name" => env('cloud_name'),
                "api_key" => env('api_key'),
                "api_secret" => env('api_secret'),
            ],
            "url" => [
                "secure" => env('secure'),
            ]
        ]);

        $this->assertTrue(
            $cloudinaryAdapter1->fileExists('cld-sample-5'),
        );
    }

    public function testFileExistsReturnFalse()
    {
        $cloudinaryAdapter2 = new CloudinaryAdapter([
            "cloud" => [
                "cloud_name" => env('cloud_name'),
                "api_key" => env('api_key'),
                "api_secret" => env('api_secret'),
            ],
            "url" => [
                "secure" => env('secure'),
            ]
        ]);

        $this->assertFalse(
            $cloudinaryAdapter2->fileExists('test-something-not-exists-in-cloudinary'),
        );
    } 

    public function testFileExistsThrowAuthorizationException()
    {

        $this->expectExceptionMessage("Authorization Needed!");

        $cloudinaryAdapterTest3 = new CloudinaryAdapter([
            "cloud" => [
                "cloud_name" => "something that throw FileSystemException",
                "api_key" => env('api_key'),
                "api_secret" => env('api_secret'),
            ],
            "url" => [
                "secure" => env('secure'),
            ]
        ]);

        $cloudinaryAdapterTest3->fileExists('cld-sample-5');
    }
}
