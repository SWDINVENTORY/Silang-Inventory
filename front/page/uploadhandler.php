<?php //-->
class Front_Page_UploadHandler extends Front_Page {
    /* Constants
     -------------------------------*/
    /* Public Properties
     -------------------------------*/
    /* Protected Properties
     -------------------------------*/
    protected $_title = null;
    protected $_class = null;
    protected $_template = null;
    protected $_errors = array();

    /* Private Properties
     -------------------------------*/
    /* Magic
     -------------------------------*/
    /* Public Methods
     -------------------------------*/
    public function render() {
		
        $uploadDir = 'files/';
		$uploadDir = realpath(dirname(__FILE__).DIRECTORY_SEPARATOR.$uploadDir).DIRECTORY_SEPARATOR;
		// Set the allowed file extensions
		$fileTypes = array('jpg', 'jpeg', 'gif', 'png'); // Allowed file extensions

		$verifyToken = md5('unique_salt' . $_POST['timestamp']);

		if (!empty($_FILES) && $_POST['token'] == $verifyToken) {
			$tempFile   = $_FILES['Filedata']['tmp_name'];
			$targetFile = $uploadDir . $_FILES['Filedata']['name'];

			// Validate the filetype
			$fileParts = pathinfo($_FILES['Filedata']['name']);
			if (in_array(strtolower($fileParts['extension']), $fileTypes)) {

				// Save the file
				move_uploaded_file($tempFile, $targetFile);
				echo 1;

			} else {

				// The file type wasn't allowed
				echo 'Invalid file type.';

			}
		}
    }
    /* Protected Methods
     -------------------------------*/
    /* Private Methods
     -------------------------------*/
}
