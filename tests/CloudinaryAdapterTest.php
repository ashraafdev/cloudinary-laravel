<?php

namespace AshraafDev\Tests\CloudinaryLaravel;

use Ashraafdev\CloudinaryLaravel;
use Ashraafdev\CloudinaryLaravel\CloudinaryAdapter;
use PHPUnit\Framework\TestCase;

class CloudinaryAdapterTest extends TestCase {
    /* public function testTrueIsTrue() {
        return $this->assertTrue(true);
    } */

    /*
        testing functionnality of fileExists
    */

    public function testFileExistsReturnTrue()
    {
        $cloudinaryAdapter = new CloudinaryAdapter([
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
            $cloudinaryAdapter->fileExists('cld-sample-5'),
        );
    }

    public function testFileExistsReturnFalse() {
        $cloudinaryAdapter = new CloudinaryAdapter([
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
            $cloudinaryAdapter->fileExists('test-something-not-exists-in-cloudinary'),
        );
    }
}
?>