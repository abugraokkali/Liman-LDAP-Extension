<ul class="nav nav-tabs" role="tablist" style="margin-bottom: 15px;">
    
    <li class="nav-item">
        <a class="nav-link active "onclick="tab1()" href="#tab1"  data-toggle="tab">Users</a>
    </li>
    <li class="nav-item">
        <a class="nav-link "onclick="tab2()" href="#tab2"  data-toggle="tab">Computers</a>
    </li>
    <li class="nav-item">
        <a class="nav-link "onclick="tab3()" href="#tab3"  data-toggle="tab">Attributes</a>
    </li>
    <li class="nav-item">
        <a class="nav-link " href="#tab4"  data-toggle="tab">Groups</a>
    </li>
</ul>

<div class="tab-content">
    
    <div id="tab1" class="tab-pane">
        <br />
        <div class="table-responsive" id="usersTable"></div>
    </div>

    <div id="tab2" class="tab-pane">
        <br />
        <div class="table-responsive" id="computersTable"></div>
    </div>

    <div id="tab3" class="tab-pane">
        <br />
        <div class="table-responsive" id="attributesTable"></div>
    </div>

    <div id="tab4" class="tab-pane">
        <br />
        <select name="groups" id="groupType">
            <option value="none" >None</option>
            <option value="security">Security Groups</option>
            <option value="distribution">Distribution Groups</option>
        </select>
        <button class="btn btn-success mb-2" onclick="tab4()" id="btn4" type="button">List</button>
        <br />
        <br />
        <div class="table-responsive" id="groupsTable"></div>
    </div>
    
</div>

<script>

   if(location.hash === ""){
        tab1();
    }
    
    // #### LDAP ####

    function tab1(){
        showSwal('Yükleniyor...','info',2000);
        var form = new FormData();
        request(API('list_users'), form, function(response) {
            $('#usersTable').html(response).find('table').DataTable({
            bFilter: true,
            "language" : {
                url : "/turkce.json"
            }
            });;
        }, function(response) {
            let error = JSON.parse(response);
            showSwal(error.message, 'error', 3000);
        });
    }

    function tab2(){
        showSwal('Yükleniyor...','info',2000);
        var form = new FormData();
        request(API('list_computers'), form, function(response) {
            $('#computersTable').html(response).find('table').DataTable({
            bFilter: true,
            "language" : {
                url : "/turkce.json"
            }
            });;
        }, function(response) {
            let error = JSON.parse(response);
            showSwal(error.message, 'error', 3000);
        });
    }

    function tab3(){
        showSwal('Yükleniyor...','info',2000);
        var form = new FormData();
        request(API('list_attributes'), form, function(response) {
            $('#attributesTable').html(response).find('table').DataTable({
            bFilter: true,
            "language" : {
                url : "/turkce.json"
            }
            });;
        }, function(response) {
            let error = JSON.parse(response);
            showSwal(error.message, 'error', 3000);
        });
    }
    
    function tab4(){
        showSwal('Yükleniyor...','info',2000);
        var form = new FormData();
        let e = document.getElementById("groupType");
        var groupType = e.value;
        form.append("groupType",groupType);

        //console.log(selection);
        request(API('list_groups'), form, function(response) {
            $('#groupsTable').html(response).find('table').DataTable({
            bFilter: true,
            "language" : {
                url : "/turkce.json"
            }
            });;
        }, function(response) {
            let error = JSON.parse(response);
            showSwal(error.message, 'error', 3000);
        });
    }

</script>