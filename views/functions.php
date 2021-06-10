<?php 

function connect(){
        $domainname= "ali.lab";
        $user = "administrator@".$domainname;
        $pass = "123123Aa";
        $server = 'ldaps://192.168.1.68';
        $port="636";
        $binddn = "DC=ali,DC=lab";
        $ldap = ldap_connect($server);
        ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldap, LDAP_OPT_X_TLS_REQUIRE_CERT, LDAP_OPT_X_TLS_NEVER);
        ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);
        //ldap_start_tls($ldap);
    
        $bind=ldap_bind($ldap, $user, $pass);
        if (!$bind) {
            exit('Binding failed');
        }
        return $ldap;
    }
function close($ldap){
    ldap_close($ldap);
}

function list_users(){
    $ldap = connect();

    $filter = "objectClass=user";
    $result = ldap_search($ldap, "CN=Users,DC=ali,DC=lab", $filter);
    $entries = ldap_get_entries($ldap,$result);

    $count = ldap_count_entries($ldap, $result);
    $data = [];
    for($i=0 ; $i<$count ; $i++){
        $nameItem = $entries[$i]["name"][0];
        $data[] = [
            "name" => $nameItem
        ];
    }
    close($ldap);

    return view('table', [
        "value" => $data,
        "title" => ["Users"],
        "display" => ["name"]
    ]);

}

function list_computers(){
    $ldap = connect();

    $filter = "objectClass=computer";
    $result = ldap_search($ldap, "DC=ali,DC=lab", $filter);
    $entries = ldap_get_entries($ldap,$result);

    $count = ldap_count_entries($ldap, $result);
    $data = [];
    for($i=0 ; $i<$count ; $i++){
        $nameItem = $entries[$i]["name"][0];
        $data[] = [
            "name" => $nameItem
        ];
    }
    close($ldap);

    return view('table', [
        "value" => $data,
        "title" => ["Computers"],
        "display" => ["name"]
    ]);

}
function list_attributes(){
    $ldap = connect();
    $cn="administrator";

    $dn_user="CN=".$cn;

    $result = ldap_search($ldap, "DC=ali,DC=lab", $dn_user);
    $entries = ldap_get_entries($ldap,$result);

    $data=[];
    for($i=0 ; $i<$entries[0]["count"] ; $i++){
        $name = $entries[0][$i];
        for($j=0 ; $j<$entries[0][$name]["count"] ; $j++){
            $value = $entries[0][$name][$j];
            $data[] = [
                "name" => $name,
                "value" => $value
            ];
        }
    }
    ldap_close($ldap);
    return view('table', [
        "value" => $data,
        "title" => ["Attribute Name","Value"],
        "display" => ["name","value"]
    ]);

}
function list_groups(){
    $ldap = connect();
    $groupType = request("groupType");
    if($groupType == "none")
        $filter="objectClass=group";
    else if($groupType == "security")
        $filter = "(&(objectCategory=group)(groupType:1.2.840.113556.1.4.803:=2147483648))";
    else if($groupType == "distribution")
        $filter = "(&(objectCategory=group)(!(groupType:1.2.840.113556.1.4.803:=2147483648)))";
    
    $result = ldap_search($ldap, "DC=ali,DC=lab", $filter);
    $entries = ldap_get_entries($ldap,$result);

    $count = ldap_count_entries($ldap, $result);
    $data = [];
    for($i=0 ; $i<$count ; $i++){
        $nameItem = $entries[$i]["name"][0];
        $data[] = [
            "name" => $nameItem
        ];
    }
    close($ldap);

    return view('table', [
        "value" => $data,
        "title" => ["Groups"],
        "display" => ["name"]
    ]);

}