<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
// /* fixed MMiC */ DB::deprecated('mysql_pconnect');//
function cp1251_to_utf8($s)
{
    if ((mb_detect_encoding($s,'UTF-8,CP1251')) == "WINDOWS-1251")
    {
        $c209 = chr(209); $c208 = chr(208); $c129 = chr(129);
        for($i=0; $i<strlen($s); $i++)
        {
            $c=ord($s[$i]);
            if ($c>=192 and $c<=239) $t.=$c208.chr($c-48);
            elseif ($c>239) $t.=$c209.chr($c-112);
            elseif ($c==184) $t.=$c209.$c209;
            elseif ($c==168)    $t.=$c208.$c129;
            else $t.=$s[$i];
        }
        return $t;
    }
    else
    {
        return $s;
    }
}
class DB
{
    static $link;
    static $count = 0; 
    
    public static function connect()
    {// @TODO Change the data connection

        @self::$link = mysqli_connect("127.0.0.1", "asbmed_0", "422520", "asbmed_0")
                       or die('No connect (' . mysqli_connect_errno() . ') '
                                             . mysqli_connect_error()); 
     // @TODO Change the encoding   
        mysqli_set_charset(self::$link, 'utf8');    
    }

    
    public static function escape($data)   
    {
        if(is_array($data))
            $data = array_map('self::escape', $data);
        else              
            $data = mysqli_real_escape_string(self::$link, $data);
        
        return $data;
    }     
    
    
    public static function Query($sql, $print = false) 
    {
        self::$count++;
        
        $result = mysqli_query(self::$link, $sql); 
// @TODO Remove the following lines when in production mode 
// ..............................................     
        if($result === false || $print === 1) 
        { 
            $error =  mysqli_error(self::$link);
            $trace =  debug_backtrace(); 
            $out   = array(1 => '');
            
            if(!empty($error))
                preg_match("#'(.+?)'#is", $error, $out);
          
            $head = $error ? '<b style="color:red">MySQL error: </b><br> 
            <b style="color:green">'. $error .'</b><br><br>':NULL;     
          
            $error_log = date("Y-m-d h:i:s") .' '. $head .' 
            <b>Query: </b><br> 
            <pre><span style="color:#990099">'
            . str_replace($out[1], '<b style="color:red">'. $out[1] .'</b>', $trace[0]['args'][0])
            .'</pre></span><br><br>
            <b>File: </b><b style="color:#660099">'. $trace[0]['file'] .'</b><br> 
            <b>Line: </b><b style="color:#660099">'. $trace[0]['line'] .'</b>'; 
            die($error_log); 
        } 
        else 
// ..............................................
            return $result; 
    }  
	
    static public function result($res, $row, $column = 0)
    {
	    $i = 0;
		
        while($data = mysqli_fetch_array($res, MYSQLI_BOTH))
		{
		    if($row == $i++)
			    return $data[$column];
		}
    }
	
    function deprecated($function)
    {
       $trace =  debug_backtrace(); 
     
       exit('<strong style="color:red">Fatal error:</strong><br>'
           .'Function <a href="http://php.net/'. $function .'">'. $function .'</a>'
           .' is deprecated and has no analog in <br>'
           .'<strong>'. $trace[0]['file'] .'</strong>'            
           .' on line <strong>'. $trace[0]['line'] .'</strong>'
           );
    }   
} 

    DB::connect();




//$testmed = mysql_pconnect($hostname_testmed, $username_testmed, $password_testmed) or trigger_error( /* fixed MMiC */ mysqli_error(DB::$link),E_USER_ERROR); 
?>