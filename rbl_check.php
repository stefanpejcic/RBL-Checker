<?php
/**
 * PHP RBL Blacklist Checker
 * @version : 1.0
**/
session_start();

session_write_close();

# BlackList Checker 
if(isset($_GET['check_ip'])){
    if (isset($_GET['host'])){
        $_GET['host']=explode(",", $_GET['host']);
        foreach ($_GET['host'] as $host) {
            if (checkdnsrr($_GET['check_ip'] . "." .  $host . ".", "A")) $check= "<font color='red'> Listed</font>";
            else $check= "<font color='green'> Clean</font>";
            print 'document.getElementById("'. $host.'").innerHTML = "'.$check.'";';
        }

        exit;
    }
    $dnsbl_lookup = [
        "all.s5h.net",
        "b.barracudacentral.org",
        "bl.spamcop.net",
        "blacklist.woody.ch",
        "bogons.cymru.com",
        "cbl.abuseat.org",
        "cdl.anti-spam.org.cn",
        "combined.abuse.ch",
        "db.wpbl.info",
        "dnsbl-1.uceprotect.net",
        "dnsbl-2.uceprotect.net",
        "dnsbl-3.uceprotect.net",
        "dnsbl.anticaptcha.net",
        "dnsbl.dronebl.org",
        "dnsbl.inps.de",
        "dnsbl.sorbs.net",
        "drone.abuse.ch",
        "duinv.aupads.org",
        "dul.dnsbl.sorbs.net",
        "dyna.spamrats.com",
        "dynip.rothen.com",
        "http.dnsbl.sorbs.net",
        "ips.backscatterer.org",
        "ix.dnsbl.manitu.net",
        "korea.services.net",
        "misc.dnsbl.sorbs.net",
        "noptr.spamrats.com",
        "orvedb.aupads.org",
        "pbl.spamhaus.org",
        "proxy.bl.gweep.ca",
        "psbl.surriel.com",
        "relays.bl.gweep.ca",
        "relays.nether.net",
        "sbl.spamhaus.org",
        "short.rbl.jp",
        "singular.ttk.pte.hu",
        "smtp.dnsbl.sorbs.net",
        "socks.dnsbl.sorbs.net",
        "spam.abuse.ch",
        "spam.dnsbl.anonmails.de",
        "spam.dnsbl.sorbs.net",
        "spam.spamrats.com",
        "spambot.bls.digibase.ca",
        "spamrbl.imp.ch",
        "spamsources.fabel.dk",
        "ubl.lashback.com",
        "ubl.unsubscore.com",
        "virus.rbl.jp",
        "web.dnsbl.sorbs.net",
        "wormrbl.imp.ch",
        "xbl.spamhaus.org",
        "z.mailspike.net",
        "zen.spamhaus.org",
        "zombie.dnsbl.sorbs.net",
    ];
    $reverse_ip = implode(".", array_reverse(explode(".", $_GET['check_ip'])));
    $dnsT = count($dnsbl_lookup);
    rblheader();
    print '<div class="container col-lg-6"><h3><font color="green"><span class="glyphicon glyphicon-eye-open"></span></font> RBL <small> Blacklist Checker</small></h3>';
    Print "Checking <b>".$_GET['check_ip']."</b> in <b>$dnsT</b>  anti-spam databases:<br></br>";
    $dnsN="";
    print '<table >';
    for ($i=0; $i < $dnsT; $i=$i+10) { 
        $host="";
        $hosts="";
        for($j=$i; $j<$i+10;$j++){
            $host=$dnsbl_lookup[$j];
            if(!empty($host)){
                print "<tr> <td>$host</td> <td id='$host'>Checking ..</td></tr>";
                $hosts .="$host,";
            }
        }
        $dnsN.="<script src='?check_ip=$reverse_ip&host=".$hosts."' type='text/javascript'></script>";
    } 

    print '</table></div>';
    print $dnsN;
    exit;
}

function rblheader(){
print '
<head>
    <title>'.str_replace("www.", "", $_SERVER['HTTP_HOST']).' - RBL Blacklist Checker</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="https://maxcdn.bootstrapcdn.com/bootswatch/3.4.1/cosmo/bootstrap.min.css" rel="stylesheet" >
</head>';
}
rblheader();
?>
