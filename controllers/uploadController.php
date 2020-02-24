<?php
require 'third_party/Aws/aws-autoloader.php';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Aws\Credentials\Credentials;
use Aws\S3\MultipartUploader;
use Aws\Exception\MultipartUploadException;

class uploadController extends controller {

	protected $s3;
	protected $bucket;
	public function __construct()
	{
		$this->bucket = 'vinicius-apps';
		$access_key = 'AKIA2MRB6QZG5ZLCQ5EY';
		$access_key_secret = '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';

		$config = array(
			'version' => 'latest',
			'region'  => 'us-east-1',
			'credentials' => new Credentials($access_key, $access_key_secret)
		);

		$this->s3 = new S3Client($config);

	}

	public function index()
	{
		$this->loadTemplate('upload', []);
	}

	public function create()
	{
		try {
			$res = $this->s3->createMultipartUpload([
                'Bucket' => $this->bucket, // REQUIRED
                'Key' => $_POST['fileInfo']['name'], // REQUIRED
            ]);


		} catch (\AwsException $e) {
			die($e->getMessage());   
		}

		echo json_encode(array(
			'uploadId' => $res->get('UploadId'),
			'key' => $res->get('Key'),
		));
	}

	public function part()
	{
        $c = [
                'Bucket' => $this->bucket,
                'Key' => ((array)json_decode($_REQUEST['sendBackData']))['key'],
                'UploadId' => ((array)json_decode($_REQUEST['sendBackData']))['uploadId'],
                'PartNumber' => $_REQUEST['partNumber'],
            ];

        try {
            $cmd = $this->s3->getCommand('UploadPart', $c);

            $request = $this->s3->createPresignedRequest($cmd, '+20 minutes');
            
        } catch (\Exception $e) {
            die($e->getMessage());
        }
        
        echo json_encode([
            'url' => (string)$request->getUri(),
        ]);	
	}

	public function complete()
	{

		$partsModel = $this->s3->listParts([
    		'Bucket' => $this->bucket,
            'Key' => ((array)json_decode($_REQUEST['sendBackData']))['key'],
            'UploadId' => ((array)json_decode($_REQUEST['sendBackData']))['uploadId'],
        ]);

        $model = $this->s3->completeMultipartUpload([
            'Bucket' => $this->bucket,
            'Key' => ((array)json_decode($_REQUEST['sendBackData']))['key'],
            'UploadId' => ((array)json_decode($_REQUEST['sendBackData']))['uploadId'],
            'MultipartUpload' => [
            	"Parts"=>$partsModel["Parts"],
            ],
        ]);

        echo json_encode(['success' => true]);
	}
}