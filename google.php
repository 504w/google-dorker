<form action="" method="post">
    <input type="test" name="search" placeholder="search" style="width: 300px; height: 30px;
    border: thin solid #496;"><br/><br/>
    <input type="submit" name="submit" name="submit" style="height: 30px; width: 100px; border:thin solid #889; background-color: #fff;">
</form>
<br/><br/><br/>
<a href="https://netscope.ir/netscope-ir-google-dorker/" target="_blank">visit full code</a>
<?php


/*coded by 504w for Netscope.ir */
set_time_limit(0);
if(isset($_POST['search'])){
    $search = $_POST['search'];
    $p = -1;

    function googlegrabber($search , $p){
        $p++;
        $cont = file_get_contents('http://www.google.com/search?q='.urlencode($search).'&ie=utf-8&oe=utf-8&aq=t&start='.$p.'0');
        $dom = new DOMDocument;
        $internalErrors = libxml_use_internal_errors(true);
        $dom->loadHTML($cont);
        libxml_use_internal_errors($internalErrors);
        $gsites = fopen("googlesites.txt", "a+");
        foreach($dom->getElementsByTagName('cite') as $element ){
            $site = str_replace("...", "", $element->nodeValue);
            if(preg_match("/https/", $site) || preg_match("/http/", $site)){
            	fwrite($gsites , parse_url($site)['host']."\n");
            } else {
            	fwrite($gsites , parse_url("http://".$site)['host']."\n");
            }
        }
        fclose($gsites);
        $GLOBALS['p'] = $p;
        $GLOBALS['cont'] = $cont;
    }

    while (true) {
        googlegrabber($search , $p);
        if(!preg_match("/Next/", $cont)){
            continue;
        }
    }
    echo "<a href='gsites.txt' target='_blank'>google dorking completed !</a>";

}
