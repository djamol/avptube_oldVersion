<?php
$save_path = 'files/';
$response  = array();

// getting server ip address
$server_ip       = gethostbyname(gethostname());

// final file url that is being uploaded
echo $file_upload_url = 'http://' . $server_ip . '/' . 'api/upload_files' . '/' . $save_path;

if(isset($_FILES['file']['name'])){
	$save_path = $save_path . basename($_FILES['file']['name']);

	$response['file_name'] = basename($_FILES['file']['name']);
	try
	{
		// Throws exception incase file is not being moved
		if(!move_uploaded_file($_FILES['file']['tmp_name'], $save_path))
		{
			// set status flag to - 1
			$response['status'] = - 1;
			$response['message'] = 'Could not upload the file!';
		}

		// File successfully uploaded. set status flag to 0
		$response['message'] = 'File uploaded successfully!';
		$response['status'] = 0;
		$response['file_path'] = $file_upload_url . basename($_FILES['file']['name']);
	} catch(Exception $e)
	{
		// Exception occurred. set status flag to - 2
		$response['status'] = - 2;
		$response['message'] = $e->getMessage();
	}
}
else
{
	// File parameter is missing
	$response['status'] = - 3;
	$response['message'] = 'File is missing';
}

// Echo final json response to client
echo json_encode($response);
