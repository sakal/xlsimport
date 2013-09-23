<?php
$CW_FOLDER = join(strstr(__FILE__, "/") ? "/" : "\\", array_slice(preg_split("/[\/\\\]+/", __FILE__), 0, -1)) . ( strstr(__FILE__, "/") ? "/" : "\\" );
require_once( $CW_FOLDER . "lib/PHPExcel/Classes/PHPExcel/IOFactory.php");
require_once( $CW_FOLDER . "lib/log4php/src/main/php/Logger.php");
Logger::configure( $CW_FOLDER . "log.xml" );
class XLSImportException extends Exception
{
    private $_log;
    
    public function __construct($message, $code = 0, Exception $previous = null) {
        
        
        // make sure everything is assigned properly
        parent::__construct($message, $code, $previous);
        $this->_log = Logger::getLogger(__CLASS__);
        $this->_log->error($this->__toString());
    }
}

class XLSImport
{
    /**
    
    */
    private $_filetype = "";
    private $_filename = "";
    private $_sheet = "";
    private $_reader = "";
    private $_xls = "";
    private $_worksheet = "";
    private $_error = "";
    private $_log;

    function __construct($filename, $sheetname="Лист1")
    {
        
        $this->_log = Logger::getLogger(__CLASS__);
        $this->_filename = $filename;
        $this->_sheet = $sheetname;
        $this->_log->debug(
            sprintf("new %s(\$filename=\"%s\", \$sheet=\"%s\")",
                __CLASS__,
                $this->_filename,
                $this->_sheet
            )
        );

    }
    
    function init()
    {
        if ( $this->_filename == "" )
        {
            $this->_error = "Set filename before call init() of import";
            $this->_log->error($this->_error);
            throw new XLSImportException($this->_error);
        }
        
        if ( ! file_exists($this->_filename))
        {
            $this->_error
                = sprintf(
                    "File %s not found. Can't init %s",
                    $this->_filename,
                    __CLASS__
                );
            throw new XLSImportException($this->_error);
        }
        
        $this->_filetype = PHPExcel_IOFactory::identify($this->_filename);
        $this->_reader = PHPExcel_IOFactory::createReader($this->_filetype);
        $this->_reader->setLoadSheetsOnly($this->_sheet);
    }
    
    function load()
    {
        $this->_xls = $this->_reader->load($this->_filename);
    }
    
    function get_headers() 
    {
        
    }
}
