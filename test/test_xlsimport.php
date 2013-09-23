<?php

$CW_FOLDER = join(strstr(__FILE__, "/") ? "/" : "\\", array_slice(preg_split("/[\/\\\]+/", __FILE__), 0, -2)) . ( strstr(__FILE__, "/") ? "/" : "\\" );

require_once( $CW_FOLDER . "xlsimport.php");
require_once( $CW_FOLDER . "lib/log4php/src/main/php/Logger.php");

Logger::configure( $CW_FOLDER . "log.xml" );

class XLSImportTest extends PHPUnit_Framework_TestCase
{
    private static $_log;
    public static $filename;
    
    public static function setUpBeforeClass()
    {
        global $CW_FOLDER;
        date_default_timezone_set("Europe/Moscow");
        self::$_log = Logger::getLogger(__CLASS__);
        self::$filename = $CW_FOLDER . "data/price.xls";
    }
    
    public static function tearDownAfterClass()
    {
        
    }
    
    public function setUp()
    {
        
    }
    
    public function tearDown()
    {
        
    }
    
    public function testDebugMessageInConstructor()
    {
        //self::$_log->set_log_level(Logging::$DEBUG);
        $import = new XLSImport("data.xls");
        unset($import);
    }
    
    /**
    @expectedException XLSImportException
    */
    public function testEmptyFilenameInInitMethod()
    {
        $import = new XLSImport("");
        $import->init();
    }
    
    /**
    @expectedException XLSImportException
    */
    public function testFileNameWhichNonExists()
    {
        $import = new XLSImport("non.exists.file.name");
        $import->init();
    }
    
    public function testLoadNormalInputFile()
    {
        $import = new XLSImport(self::$filename);
        $import->init();
        $import->load();
    }
}