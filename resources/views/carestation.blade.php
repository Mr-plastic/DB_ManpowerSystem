<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.1">
    <title>Document</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
</head>

<style>
    body {
        background-color: #f15b5b !important;
        overflow-x: hidden;
        overflow-y: scroll;
    }
    
    .content-wrapper {
        background-color: white;
        margin-top: 30px;
        border-radius: 6px;
    }
    /*----------------------------------------------*/
    
    .error {
        position: fixed;
        top: 16px;
        left: 50%;
        z-index: 100000 !important;
        opacity: 0.9;
        transform: translateX(-50%) translateY(-150px);
        opacity: 0;
        transition: opacity 0.3s ease, transform 0s 0.5s ease;
        width: 100%;
        text-align: center;
        max-width: 460px;
        text-align: center
    }
    
    .error p {
        padding: 8px 16px;
        background-color: rgba(241, 34, 62, 0.856);
        box-shadow: 0px 3px 15px rgba(0, 0, 0, 0.2);
        border-radius: 4px;
        display: inline-block;
        color: #fff
    }
    
    .error.active {
        transform: translateX(-50%) translateY(0px);
        opacity: 1;
        transition: opacity 0.3s ease, transform 0.3s ease
    }
    /* Success提示 */
    
    .success {
        position: fixed;
        top: 16px;
        left: 50%;
        z-index: 100000;
        opacity: 0.9;
        transform: translateX(-50%) translateY(-150px);
        opacity: 0;
        transition: opacity 0.3s ease, transform 0s 0.5s ease;
        width: 100%;
        text-align: center;
        max-width: 460px;
        text-align: center
    }
    
    .success p {
        padding: 8px 16px;
        background-color: rgba(247, 163, 38, 0.863);
        box-shadow: 0px 3px 15px rgba(0, 0, 0, 0.2);
        border-radius: 4px;
        display: inline-block;
        color: #fff
    }
    
    .success.active {
        transform: translateX(-50%) translateY(0px);
        opacity: 1;
        transition: opacity 0.3s ease, transform 0.3s ease
    }
    /*-----------------------------------------------------------------------------------*/
    
    .nav-item {
        background-color: #e64343;
        border-radius: 8px;
    }
    
    .nav-item:hover {
        background-color: #b62b2b;
    }
    
    .nav-item-active {
        background-color: #b62b2b;
    }
</style>

<body onload="edit_success(),add_success()">

    <nav class="navbar navbar-light" style="background-color: #047cc2;">
        <div class="container">
            <a>
                <div>
                    <img src="../img/love.svg" width=40 height=40>
                    <div style="color:white; font-size:22px; position:absolute; top:13px; margin-left:8px; display:inline-block;">帛宗長照</div>

                </div>
            </a>
            <div style="width:200px">
                <div class="dropdown" style="float:right;">
                
                    <a class="btn dropdown-toggle text-light" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size:20px; padding-top:0px; padding-bottom:0px;"></a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="margin-top:12px;">
                        <a class="dropdown-item" href="{{ url('/logout') }}">登出</a>
                    </div>
                </div>
                <span class="text-light" style="float:right; margin-top:3px;">用戶 : {{ $user[0]['username'] }}</span>
            </div>
        </div>
    </nav>
    <div class="row">
        <div class="col-2 ml-3 mt-3">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link text-light" href="{{ url('/showexecutive') }}">行政人員表</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="{{ url('/showcaredfamily') }}">家庭代碼表</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="{{ url('/showcarers') }}">照護人員表</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-item-active text-light" href="{{ url('/showcarestation') }}">派駐資料表</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="{{ url('/crossdatasearch') }}">跨資料整合</a>
                </li>
                @if($Authority == 'super user')
                    <li class="nav-item">
                        <a class="nav-link text-light" href="{{ url('/usersetting') }}">使用者設定</a>
                    </li>
                @endif
            </ul>
        </div>
        <div class="col-8">
            {{-- 錯誤提示訊息 --}}
            <div class="error">
                <p id="error"></p>
            </div>
            {{-- 成功提示訊息 --}}
            <div class="success">
                <p id="success"></p>
            </div>
            <script>
                //cookies
                function edit_success() {
                    var edit_cookie = document.cookie;
                    if (edit_cookie.search("save_edit") != -1) {

                        $("#success").html("編輯成功");
                        var h = document.querySelector(".success"); //錯誤代碼
                        h.classList.add("active");
                        setTimeout(function() {
                            h.classList.remove('active');
                        }, 2000);
                    }
                    document.cookie = "save_edit=; expires=Thu, 01 Jan 1970 00:00:00 GMT";
                }

                function add_success() {
                    var add_cookie = document.cookie;
                    if (add_cookie.search("save_add") != -1) {
                        $("#success").html("新增成功");
                        var h = document.querySelector(".success"); //錯誤代碼
                        h.classList.add("active");
                        setTimeout(function() {
                            h.classList.remove('active');
                        }, 2000);
                    }
                    document.cookie = "save_add=; expires=Thu, 01 Jan 1970 00:00:00 GMT";
                }
            </script>
            <script type="text/javascript">
            </script>
            <div class="container text-light">
                <center class="pt-3">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4">
                                <h4 class="text-left">各區總照護人員人數:</h4>
                                <div class="text-left">北區: {{ $north }}</div>
                                <div class="text-left">中區: {{ $west }}</div>
                                <div class="text-left">南區: {{ $south }}</div>
                                <div class="text-left">東區: {{ $east }}</div>
                            </div>
                            <div class="col-md-4">
                                <h4 class="text-left">各區照護人員男女人數:</h4>
                                <div class="text-left">北區: {{ $north_male }}男 {{ $north_female }}女</div>
                                <div class="text-left">中區: {{ $west_male }}男 {{ $west_female }}女</div>
                                <div class="text-left">南區: {{ $south_male }}男 {{ $south_female }}女</div>
                                <div class="text-left">東區: {{ $east_male }}男 {{ $east_female }}女</div>
                            </div>
                            <div class="col-md-4">
                                <h4 class="text-left">各區照護人員男女平均薪資:</h4>
                                <div class="text-left">北區: 男 {{$north_male_salary_average}} 女 {{ $north_female_salary_average }}</div>
                                <div class="text-left">中區: 男 {{ $west_male_salary_average }} 女 {{ $west_female_salary_average }}</div>
                                <div class="text-left">南區: 男 {{ $south_male_salary_average }} 女 {{ $south_female_salary_average }}</div>
                                <div class="text-left">東區: 男 {{ $east_male_salary_average }} 女 {{ $east_female_salary_average }}</div>
                            </div>
                        </div>


                    </div>
                </center>
            </div>
            <!-- 創建卡片 -->
            <div class="container pt-3">
                <div class="card">
                    <div class="card-header navbar">
                        <div class="div">
                            受照護家庭資料
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#add-care-station-modal">新增資料</button>
                        </div>
                        <!-- 創建搜尋紐 -->
                        <form class="form-inline ">
                            <input class="form-control mr-sm-2" type="text" placeholder="照護人員ID" aria-label="Search" id="search-carers-id">
                            <button class="btn btn-outline-success my-2 my-sm-0" type="button" id="search-submit" data-toggle="modal">Search</button>
                        </form>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">照護人員ID</th>
                                    <th scope="col">照護人員姓名</th>
                                    <th scope="col">派駐家庭代碼</th>
                                    <th scope="col">受照護者姓名</th>
                                    <th scope="col">派駐開始日期</th>
                                    <th scope="col">派駐結束日期</th>
                                    <th scope="col">派駐狀態</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody id="tbody">
                                @foreach($datas as $data)

                                <tr>
                                    <th scope="row">{{ --$data_length}}</th>
                                    <td>{{ $data->照護人員ID }}</td>
                                    <td>{{ $data->照護人員姓名 }}</td>
                                    <td>{{ $data->派駐家庭代碼 }}</td>
                                    <td>{{ $data->受照護者姓名 }}</td>
                                    <td>{{ $data->派駐開始日期 }}</td>
                                    <td>{{ $data->派駐結束日期 }}</td>
                                    <td>{{ $data->派駐狀態}}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary" onclick="show_edit_care_station('{{$data->照護人員ID}}','{{$data->派駐家庭代碼}}')" data-toggle="modal" data-target="#edit-care-station-modal">Edit</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- 創建Modal id 0-->
            <div class="modal fade" id="add-care-station-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">新增資料</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                        </div>
                        <div class="modal-body">
                            <form id="add-care-station-form">
                                <div class="form-group" id="form-group1">
                                    <label for="exampleInputEmail1">照護人員ID</label>
                                    <input type="text" class="form-control" id="照護人員ID" aria-describedby="emailHelp" placeholder="ex.A123456789" required="required">
                                </div>
                                <div class="form-group" id="form-group2">
                                    <label for="exampleInputPassword1">派駐家庭代碼</label>
                                    <input type="input" class="form-control" id="派駐家庭代碼" placeholder="ex.北0000001" required>
                                </div>
                                <div class="form-group" id="form-group4">
                                    <label for="exampleInputPassword1">受照護者姓名</label>
                                    <input type="input" class="form-control" id="受照護者姓名" placeholder="ex.王大明" required>
                                </div>
                                <div class="form-group" id="form-group5">
                                    <label for="exampleInputPassword1">派駐開始日期</label>
                                    <input type="input" class="form-control" id="派駐開始日期" placeholder="yyyy-mm-dd" required>
                                </div>
                                <div class="mb-3" id="form-group6">
                                    <label for="validationTextarea">派駐結束日期</label>
                                    <input type="input" class="form-control" id="派駐結束日期" placeholder="yyyy-mm-dd" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" id="form-submit">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 創建info modal id1-->
            <div class="modal fade" id="info-care-station-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">新增資料</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                        </div>
                        <div class="modal-body">
                            <form id="cared-form">
                                <div class="form-group" id="form-group1">
                                    <label for="exampleInputEmail1">照護人員ID</label>
                                    <input type="text" class="form-control" id="照護人員ID1" aria-describedby="emailHelp" placeholder="ex.A123456789" required="required">
                                </div>
                                <div class="form-group" id="form-group1">
                                    <label for="exampleInputEmail1">照護人員姓名</label>
                                    <input type="text" class="form-control" id="照護人員姓名1" aria-describedby="emailHelp" placeholder="ex.王大明" required="required">
                                </div>
                                <div class="form-group" id="form-group2">
                                    <label for="exampleInputPassword1">派駐家庭代碼</label>
                                    <input type="input" class="form-control" id="派駐家庭代碼1" placeholder="ex.北0000001" required>
                                </div>
                                <div class="form-group" id="form-group4">
                                    <label for="exampleInputPassword1">受照護者姓名</label>
                                    <input type="input" class="form-control" id="受照護者姓名1" placeholder="ex.王大明" required>
                                </div>
                                <div class="form-group" id="form-group5">
                                    <label for="exampleInputPassword1">派駐開始日期</label>
                                    <input type="input" class="form-control" id="派駐開始日期1" placeholder="yyyy-mm-dd" required>
                                </div>
                                <div class="mb-3" id="form-group6">
                                    <label for="validationTextarea">派駐結束日期</label>
                                    <input type="input" class="form-control" id="派駐結束日期1" placeholder="yyyy-mm-dd" required>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-2"></div>
                </div>
            </div>
            <!-- 創建edit modal id 2 -->
            <div class="modal fade" id="edit-care-station-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">編輯資料</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                        </div>
                        <div class="modal-body">
                            <form id="cared-form">
                                <div class="form-group" id="form-group1">
                                    <label for="exampleInputEmail1">照護人員ID</label>
                                    <input type="text" class="form-control" id="照護人員ID2" aria-describedby="emailHelp" placeholder="ex.A123456789" required="required">
                                </div>
                                <div class="form-group" id="form-group2">
                                    <label for="exampleInputPassword1">派駐家庭代碼</label>
                                    <input type="input" class="form-control" id="派駐家庭代碼2" placeholder="ex.北0000001" required>
                                </div>
                                <div class="form-group" id="form-group4">
                                    <label for="exampleInputPassword1">受照護者姓名</label>
                                    <input type="input" class="form-control" id="受照護者姓名2" placeholder="ex.王大明" required>
                                </div>
                                <div class="form-group" id="form-group5">
                                    <label for="exampleInputPassword1">派駐開始日期</label>
                                    <input type="input" class="form-control" id="派駐開始日期2" placeholder="yyyy-mm-dd" required>
                                </div>
                                <div class="mb-3" id="form-group6">
                                    <label for="validationTextarea">派駐結束日期</label>
                                    <input type="input" class="form-control" id="派駐結束日期2" placeholder="yyyy-mm-dd" required>
                                </div>
                                <div class="form-group">
                                    <label class="mr-sm-2" for="selection2">Preference</label>
                                    <select class="custom-select mr-sm-2 selection2" id="selection2">
                                <option value="派駐中" >派駐中</option>
                                <option value="調離原受照護家庭" >調離原受照護家庭</option>
                            </select>
                                    <div class="resign2" style="display:none;">離職</div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" id="save-edit">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 創建Search modal id 3 -->
            <div class="modal fade" id="search-care-station-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">編輯資料</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                        </div>
                        <div class="modal-body">
                            <form id="cared-form">
                                <div class="form-group" id="form-group1">
                                    <label for="exampleInputEmail1">照護人員ID</label>
                                    <input type="text" class="form-control" id="照護人員ID3" aria-describedby="emailHelp" placeholder="ex.A123456789" required="required">
                                </div>
                                <div class="form-group" id="form-group2">
                                    <label for="exampleInputPassword1">派駐家庭代碼</label>
                                    <input type="input" class="form-control" id="派駐家庭代碼3" placeholder="ex.北0000001" required>
                                </div>
                                <div class="form-group" id="form-group4">
                                    <label for="exampleInputPassword1">受照護者姓名</label>
                                    <input type="input" class="form-control" id="受照護者姓名3" placeholder="ex.王大明" required>
                                </div>
                                <div class="form-group" id="form-group5">
                                    <label for="exampleInputPassword1">派駐開始日期</label>
                                    <input type="input" class="form-control" id="派駐開始日期3" placeholder="yyyy-mm-dd" required>
                                </div>
                                <div class="mb-3" id="form-group6">
                                    <label for="validationTextarea">派駐結束日期</label>
                                    <input type="input" class="form-control" id="派駐結束日期3" placeholder="yyyy-mm-dd" required>
                                </div>
                                <div class="form-group">
                                    <label class="mr-sm-2" for="selection3">Preference</label>
                                    <select class="custom-select mr-sm-2 selection3" id="selection3">
                                <option value="派駐中" >派駐中</option>
                                <option value="調離原受照護家庭" >調離原受照護家庭</option>
                            </select>
                                    <div class="resign3" style="display:none;">離職</div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" id="save-search" onclick="">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            //新增資料ajax
            var check_count = new Array(5);
            $("#form-submit").click(function(e) {
                for(i =0;i<5;i++){
                    check_count[i] = 0;
                }
                check_ID();
                checkfamily_code();
                takecare_name();
                if(check_count[0]==1 && check_count[1]==1 &&check_count[2]==1){
                    let carers_id = $("#照護人員ID").val();
                    let cared_family_code = $("#派駐家庭代碼").val();
                    let cared_name = $("#受照護者姓名").val();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: "{{route('add-care-station')}}",
                        type: "POST",
                        data: {
                            carers_id: carers_id,
                            cared_family_code: cared_family_code,
                            cared_name: cared_name,
                        },
                        success: function(response) {
                            if (response != '照護人員ID輸入錯誤，伺服器查無該筆ID!' && response != '請檢查該筆派駐家庭代碼及受照護者姓名是否正確!' &&
                                response != '該名照護人員已存在，請用編輯模式編輯該照護人員派駐資訊!') {
                                $("#add-care-station-form")[0].reset();
                                $("#add-care-station-modal").modal('hide');
                                document.cookie = "save_add=1;";
                                location.reload();
                            }
                            if (response == '照護人員ID輸入錯誤，伺服器查無該筆ID!') {
                                $("#error").html("照護人員ID輸入錯誤，伺服器查無該筆ID!");
                                var h = document.querySelector(".error"); //錯誤代碼
                                h.classList.add("active");
                                setTimeout(function() {
                                    h.classList.remove('active');
                                }, 4000);
                            }
                            if (response == '請檢查該筆派駐家庭代碼及受照護者姓名是否正確!') {
                                $("#error").html("請檢查該筆派駐家庭代碼及受照護者姓名是否正確!");
                                var h = document.querySelector(".error"); //錯誤代碼
                                h.classList.add("active");
                                setTimeout(function() {
                                    h.classList.remove('active');
                                }, 4000);
                            }
                            if (response == '該名照護人員已存在，請用編輯模式編輯該照護人員派駐資訊!') {
                                $("#error").html("該名照護人員已存在，請用編輯模式編輯該照護人員資訊!");
                                var h = document.querySelector(".error"); //錯誤代碼
                                h.classList.add("active");
                                setTimeout(function() {
                                    h.classList.remove('active');
                                }, 4000);
                            }
                            console.log(response);
                        }

                    });
                }
                contract_expired();
                start_work();
                console.log(check_count);
                e.preventDefault();
                if(!check_count.includes(0)){
                    let carers_id = $("#照護人員ID").val();
                    let cared_family_code = $("#派駐家庭代碼").val();
                    let cared_name = $("#受照護者姓名").val();
                    let start_date = $("#派駐開始日期").val();
                    let end_date = $("#派駐結束日期").val();

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: "{{route('add-care-station')}}",
                        type: "POST",
                        data: {
                            carers_id: carers_id,
                            cared_family_code: cared_family_code,
                            cared_name: cared_name,
                            start_date: start_date,
                            end_date: end_date
                        },
                        success: function(response) {
                            if (response != '照護人員ID輸入錯誤，伺服器查無該筆ID!' && response != '請檢查該筆派駐家庭代碼及受照護者姓名是否正確!' &&
                                response != '該名照護人員已存在，請用編輯模式編輯該照護人員派駐資訊!') {
                                $("#add-care-station-form")[0].reset();
                                $("#add-care-station-modal").modal('hide');
                                document.cookie = "save_add=1;";
                                location.reload();
                            }
                            if (response == '照護人員ID輸入錯誤，伺服器查無該筆ID!') {
                                $("#error").html("照護人員ID輸入錯誤，伺服器查無該筆ID!");
                                var h = document.querySelector(".error"); //錯誤代碼
                                h.classList.add("active");
                                setTimeout(function() {
                                    h.classList.remove('active');
                                }, 4000);
                            }
                            if (response == '請檢查該筆派駐家庭代碼及受照護者姓名是否正確!') {
                                $("#error").html("請檢查該筆派駐家庭代碼及受照護者姓名是否正確!");
                                var h = document.querySelector(".error"); //錯誤代碼
                                h.classList.add("active");
                                setTimeout(function() {
                                    h.classList.remove('active');
                                }, 4000);
                            }
                            if (response == '該名照護人員已存在，請用編輯模式編輯該照護人員派駐資訊!') {
                                $("#error").html("該名照護人員已存在，請用編輯模式編輯該照護人員資訊!");
                                var h = document.querySelector(".error"); //錯誤代碼
                                h.classList.add("active");
                                setTimeout(function() {
                                    h.classList.remove('active');
                                }, 4000);
                            }
                            console.log(response);
                        }

                    });
              }    
            });
        </script>

        <script type="text/javascript">
            //show search資料
            $("#search-submit").click(function(e) {
                e.preventDefault();
                if ($("#search-carers-id").val() == "") { //如果ID為空 按鈕不觸發
                    $("#error").html("資料不能為空哦~~");
                    var h = document.querySelector(".error"); //錯誤代碼
                    h.classList.add("active");
                    setTimeout(function() {
                        h.classList.remove('active');
                    }, 4000);
                    return false;
                }
                let carers_id = $("#search-carers-id").val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{route('show-search-care-station')}}",
                    type: "POST",
                    data: {
                        carers_id: carers_id,
                    },
                    success: function(response) {
                        if (response[0].length > 0) {
                            $('#search-care-station-modal').modal('show');
                            $("#照護人員ID3").val(response[0][0]['照護人員ID']);
                            $("#照護人員姓名3").val(response[0][0]['照護人員姓名']);
                            $("#派駐家庭代碼3").val(response[0][0]['派駐家庭代碼']);
                            $("#受照護者姓名3").val(response[0][0]['受照護者姓名']);
                            $("#派駐開始日期3").val(response[0][0]['派駐開始日期']);
                            $("#派駐結束日期3").val(response[0][0]['派駐結束日期']);
                            if (response[0][0]['派駐狀態'] == '離職') {
                                $('.selection3').css('display', 'none');
                                $('.resign3').css('display', 'block');
                            } else {
                                $('.resign3').css('display', 'none');
                                $('.selection3').css('display', 'block');
                                $('#selection3').val(response[0][0]['派駐狀態']);
                            }
                            initial_carers_id = response[0][0]['照護人員ID'];
                            initial_cared_family_code = response[0][0]['派駐家庭代碼'];
                        } else {
                            $("#error").html("伺服器查無該筆資訊!");
                            var h = document.querySelector(".error"); //錯誤代碼
                            h.classList.add("active");
                            setTimeout(function() {
                                h.classList.remove('active');
                            }, 4000);
                            $("#search-carers-modal").modal('hide');
                            return false;
                        }
                        console.log(response);
                    }

                });
            });

            //save搜尋表單
            $("#save-search").click(function(e) {
                e.preventDefault();
                let carers_id = $("#照護人員ID3").val();
                let carers_name = $('#照護人員姓名3').val();
                let cared_family_code = $("#派駐家庭代碼3").val();
                let cared_name = $("#受照護者姓名3").val();
                let start_date = $("#派駐開始日期3").val();
                let end_date = $("#派駐結束日期3").val();
                let select = $('#selection3').val();
                if (initial_carers_id != carers_id) {
                    $("#error").html("照護人員ID不允許變更!");
                    var h = document.querySelector(".error"); //錯誤代碼
                    h.classList.add("active");
                    setTimeout(function() {
                        h.classList.remove('active');
                    }, 4000);
                    return false;
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{route('save-search-care-station')}}",
                    type: "POST",
                    data: {
                        initial_carers_id: initial_carers_id,
                        initial_cared_familly_code: initial_cared_family_code,
                        carers_id: carers_id,
                        cared_family_code: cared_family_code,
                        cared_name: cared_name,
                        start_date: start_date,
                        end_date: end_date,
                        select: select
                    },
                    success: function(response) {
                        if (response == '該家庭代碼已被刪除，不允許變更!') {
                            $("#error").html("該家庭代碼已被刪除，不允許變更!");
                            var h = document.querySelector(".error"); //錯誤代碼
                            h.classList.add("active");
                            setTimeout(function() {
                                h.classList.remove('active');
                            }, 4000);
                        } else if (response == '該家庭代碼下無該名受照護者!') {
                            $("#error").html("該家庭代碼下無該名受照護者!");
                            var h = document.querySelector(".error"); //錯誤代碼
                            h.classList.add("active");
                            setTimeout(function() {
                                h.classList.remove('active');
                            }, 4000);
                        } else {
                            $("#cared-form")[0].reset();
                            $("#edit-care-station-modal").modal('hide');
                            document.cookie = "save_edit=1;";
                            location.reload();

                        }


                        console.log(response);
                    }

                });
            });
        </script>

        <script type="text/javascript">
            let initial_carers_id; //全域變數
            let initial_carers_name;
            let initial_cared_family_code;
            //show_Edit資料
            function show_edit_care_station(carers_id, cared_family_code) {
                $('#edit-care-station-modal').on('hidden.bs.modal', function() {
                    $(this).find('form').trigger('reset');
                });
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{route('show-edit-care-station')}}",
                    type: "POST",
                    data: {
                        carers_id: carers_id,
                        cared_family_code: cared_family_code,
                    },
                    success: function(response) {
                        if (response) {
                            $("#照護人員ID2").val(response[0][0]['照護人員ID']);
                            $("#照護人員姓名2").val(response[0][0]['照護人員姓名']);
                            $("#派駐家庭代碼2").val(response[0][0]['派駐家庭代碼']);
                            $("#受照護者姓名2").val(response[0][0]['受照護者姓名']);
                            $("#派駐開始日期2").val(response[0][0]['派駐開始日期']);
                            $('#派駐結束日期2').val(response[0][0]['派駐結束日期']);
                            if (response[0][0]['派駐狀態'] == '離職') {
                                $('.selection2').css('display', 'none');
                                $('.resign2').css('display', 'block');
                            } else {
                                $('.resign2').css('display', 'none');
                                $('.selection2').css('display', 'block');
                                $('#selection2').val(response[0][0]['派駐狀態']);
                            }
                            initial_carers_id = response[0][0]['照護人員ID'];
                            initial_cared_family_code = response[0][0]['派駐家庭代碼'];
                        }
                        console.log(response);
                    }

                });
            }

            //save edit表單
            $("#save-edit").click(function(e) {
                e.preventDefault();
                let carers_id = $("#照護人員ID2").val();
                let carers_name = $('#照護人員姓名2').val();
                let cared_family_code = $("#派駐家庭代碼2").val();
                let cared_name = $("#受照護者姓名2").val();
                let start_date = $("#派駐開始日期2").val();
                let end_date = $("#派駐結束日期2").val();
                let select = $('#selection2').val();
                if (initial_carers_id != carers_id) {
                    $("#error").html("照護人員ID不允許變更!");
                    var h = document.querySelector(".error"); //錯誤代碼
                    h.classList.add("active");
                    setTimeout(function() {
                        h.classList.remove('active');
                    }, 4000);
                    return false;
                }


                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{route('save-edit-care-station')}}",
                    type: "POST",
                    data: {
                        initial_carers_id: initial_carers_id,
                        initial_cared_family_code: initial_cared_family_code,
                        carers_id: carers_id,
                        cared_family_code: cared_family_code,
                        cared_name: cared_name,
                        start_date: start_date,
                        end_date: end_date,
                        select: select
                    },
                    success: function(response) {
                        if (response == '該家庭代碼已被刪除，不允許變更!') {
                            $("#error").html("該家庭代碼已被刪除，不允許變更!");
                            var h = document.querySelector(".error"); //錯誤代碼
                            h.classList.add("active");
                            setTimeout(function() {
                                h.classList.remove('active');
                            }, 4000);
                        } else if (response == '該家庭代碼下無該名受照護者!') {
                            $("#error").html("該家庭代碼下無該名受照護者!");
                            var h = document.querySelector(".error"); //錯誤代碼
                            h.classList.add("active");
                            setTimeout(function() {
                                h.classList.remove('active');
                            }, 4000);
                        } else {
                            $("#cared-form")[0].reset();
                            $("#edit-care-station-modal").modal('hide');
                            document.cookie = "save_edit=1;";
                            location.reload();

                        }

                        console.log(response);
                    }

                });
            });
        </script>

        <!-- {{-- 宗勳code 前台表單驗證 --}} -->
        <script>
            function check_ID() { //表單驗證
            var ID = document.getElementById("照護人員ID").value;
            var letters = new Array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'K', 'L', 'M', 'N', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'X', 'Y', 'W', 'Z', 'I', 'O');
            var multiply = new Array(1, 9, 8, 7, 6, 5, 4, 3, 2, 1);
            var nums = new Array(2);
            var firstChar;
            var firstNum;
            var lastNum;
            var total = 0;
            firstChar = ID.charAt(0).toUpperCase();
            lastNum = ID.charAt(9);
            if (ID == "") {
                $("#ID_remind").remove();
                $("#form-group1").append('<small class="form-text text-muted" style="color:red !important;" id="ID_remind">照護人員ID不能為空,請查核！</small>'); //檢查格式是否為空值
                $("#照護人員ID").addClass("is-invalid");
                check_count[0] = 0;
                return false;
            }
            if (ID.length != 10) {
                $("#ID_remind").remove();
                $("#form-group1").append('<small class="form-text text-muted" style="color:red !important;" id="ID_remind">照護人員ID長度不符,請查核！</small>'); //檢查格式是否為空值"")
                $("#照護人員ID").addClass("is-invalid");
                check_count[0] = 0;
                return false;
            }
            for (i = 0; i < 10; i++) {
                var character = ID.charAt(i);
                if (i == 0) { // 檢查第一碼是否是"A-Z" 
                    if (!('A' <= character && character <= 'Z')) {
                        $("#ID_remind").remove();
                        $("#form-group1").append('<small class="form-text text-muted" style="color:red !important;" id="ID_remind">照護人員ID輸入有誤（第一碼請為A-Z）,請查核!</small>');
                        $("#照護人員ID").addClass("is-invalid");
                        check_count[0] = 0;
                        return false;
                    }
                }
                if (i == 1) {
                    if (character != '0' && character != '1') { //用ASCII檢查第二碼是否為0或1
                        $("#ID_remind").remove();
                        $("#form-group1").append('<small class="form-text text-muted" style="color:red !important;" id="ID_remind">照護人員ID不符正式格式請重新輸入,請查核!</small>');
                        $("#照護人員ID").addClass("is-invalid");
                        check_count[0] = 0;
                        return false;
                    }
                }
                if (2 <= i && i <= 10) {
                    if (!('0' <= character && character <= '9')) { //用ASCII檢查後八碼是否為0~9
                        $("#ID_remind").remove();
                        $("#form-group1").append('<small class="form-text text-muted" style="color:red !important;" id="ID_remind">照護人員ID輸入後八碼須為數字,請查核!</small>');
                        $("#照護人員ID").addClass("is-invalid");
                        check_count[0] = 0;
                        return false;
                    }
                }
                for (var i = 0; i < 26; i++) {
                    if (firstChar == letters[i]) {
                        firstNum = i + 10;
                        nums[0] = Math.floor(firstNum / 10);
                        nums[1] = firstNum - (nums[0] * 10);
                        break;
                    }
                }
                for (var i = 0; i < multiply.length; i++) {
                    if (i < 2) {
                        total += nums[i] * multiply[i];
                    } else {
                        total += parseInt(ID.charAt(i - 1)) *
                            multiply[i];
                    }
                }
                if (lastNum == 0 && (total % 10) != lastNum) {
                    $("#ID_remind").remove();
                    $("#form-group1").append('<small class="form-text text-muted" style="color:red !important;" id="ID_remind">照護人員ID不符合正式格式,請查核!</small>');
                    $("#照護人員ID").addClass("is-invalid");
                    check_count[0] = 0;
                    return false;
                }
                if (lastNum != 0 && (10 - (total % 10)) != lastNum) {
                    $("#ID_remind").remove();
                    $("#form-group1").append('<small class="form-text text-muted" style="color:red !important;" id="ID_remind">照護人員ID不符合正式格式,請查核!</small>');
                    $("#照護人員ID").addClass("is-invalid");
                    check_count[0] = 0;
                    return false;
                }


            }
            $("#ID_remind").remove();
            $("#照護人員ID").removeClass("is-invalid");
            $("#照護人員ID").addClass("is-valid");
            check_count[0] = 1;
            return (true);
        }
            function checkfamily_code() {       //家庭代碼檢測
            var family_code=document.getElementById("派駐家庭代碼").value;
            if (family_code == "") {
                $("#family-code-remind").remove();
                $("#form-group2").append('<small class="form-text text-muted" style="color:red !important;" id="family-code-remind">派駐家庭代碼不能為空,請查核！</small>');//檢查格式是否為空值
                $("#派駐家庭代碼").addClass("is-invalid");
                check_count[1] = 0;
                return false;
            }
            if (family_code.length!=8){
                $("#family-code-remind").remove();
                $("#form-group2").append('<small class="form-text text-muted" style="color:red !important;" id="family-code-remind">派駐家庭代碼長度不符,請查核！</small>');//檢查格式是否為空值"")
                $("#派駐家庭代碼").addClass("is-invalid");
                check_count[1] = 0;
                return false;
            }
            for (i=0; i<8; i++){
            var  character=family_code.charAt(i);
                if (i==0){	// 檢查第一碼是否是 "北,中,南,東"
                    if (character!="北"&&character!="中"&&character!="南"&&character!="東"){
                        $("#family-code-remind").remove();
                        $("#form-group2").append('<small class="form-text text-muted" style="color:red !important;" id="family-code-remind">派駐家庭代碼輸入有誤（第一碼請為北,中,南,東）,請查核!</small>');
                        $("#派駐家庭代碼").addClass("is-invalid");
                        check_count[1] = 0;
                        return false;
                    }
                }   
                if(1<=i && i<=8){
                    if(!('0'<=character && character<='9')){//用ASCII檢查後七碼是否為0~9
                        $("#family-code-remind").remove();
                        $("#form-group2").append('<small class="form-text text-muted" style="color:red !important;" id="family-code-remind">派駐家庭代碼輸入後七碼須為數字,請查核!</small>');
                        $("#派駐家庭代碼").addClass("is-invalid");
                        check_count[1] = 0;
                        return false;
                    }
                }
            }
            $("#family-code-remind").remove();
            $("#派駐家庭代碼").removeClass("is-invalid");
            $("#派駐家庭代碼").addClass("is-valid");
            check_count[1] = 1;
            return (true);
        }
            function takecare_name() { //受照護者姓名檢測
                var takecare_code = document.getElementById("受照護者姓名").value;
                if (takecare_code == "") { //檢查格式是否為空值
                    $("#takecare-name-remind").remove();
                    $("#form-group4").append('<small class="form-text text-muted" style="color:red !important;" id="takecare-name-remind">受照護者姓名不能為空,請查核！</small>');
                    $("#受照護者姓名").addClass("is-invalid");
                    check_count[2] = 0;
                    return false;
                }
                if (takecare_code.length > 19) {
                    $("#takecare-name-remind").remove();
                    $("#form-group4").append('<small class="form-text text-muted" style="color:red !important;" id="takecare-name-remind">受照護者姓名需小於20字,請查核！</small>');
                    $("#受照護者姓名").addClass("is-invalid");
                    check_count[2] = 0;
                    return false;
                }
                $("#takecare-name-remind").remove();
                $("#受照護者姓名").removeClass("is-invalid");
                $("#受照護者姓名").addClass("is-valid");
                check_count[2] = 1;
                return (true);
            }
            function start_work() {
                var start_work = document.getElementById("派駐開始日期").value;
                var contract_expired_code = document.getElementById("派駐結束日期").value;
                var check_date = start_work.substring(0, 10); //到職date
                var check_year = start_work.substring(0, 4); //到職年份
                var check_month = start_work.substring(5, 7); //檢查月份
                var check_days = start_work.substring(8, 10);
                var date = new Date();
                var date_year = date.getFullYear(); //獲取目前年份
                if (start_work == "") {
                    $("#start_work_remind").remove();
                    $("#form-group5").append('<small class="form-text text-muted" style="color:red !important;" id="start_work_remind">派駐開始日期欄位不能為空,請查核！</small>'); //檢查格式是否為空值
                    $("#派駐開始日期").addClass("is-invalid");
                    check_count[3] = 0;
                    return false;
                }

                if (start_work.length != 10) {
                    $("#start_work_remind").remove();
                    $("#form-group5").append('<small class="form-text text-muted" style="color:red !important;" id="start_work_remind">派駐開始日期長度不符,請查核！</small>'); //檢查格式是否為長度符合
                    $("#派駐開始日期").addClass("is-invalid");
                    check_count[3] = 0;
                    return false;
                }
                for (i = 0; i < start_work.length; i++) { //檢查'-'格式
                    var start_char = start_work.charAt(i);
                    if ((i == 4) || (i == 7)) {
                        if (start_char != "-") {
                            $("#start_work_remind").remove();
                            $("#form-group5").append('<small class="form-text text-muted" style="color:red !important;" id="start_work_remind">派駐開始日期格式不符(ex:2000-07-28),請查核！</small>');
                            $("#派駐開始日期").addClass("is-invalid");
                            check_count[3] = 0;
                            return false;
                        }
                    } else {
                        if (!('0' <= start_char && start_char <= '9')) { //檢查是否為數字0-9
                            $("#start_work_remind").remove();
                            $("#form-group5").append('<small class="form-text text-muted" style="color:red !important;" id="start_work_remind">派駐開始日期格式不符(格式須為數字<ex:2000-07-28>),請查核！</small>');
                            $("#派駐開始日期").addClass("is-invalid");
                            check_count[3] = 0;
                            return false;
                        }
                    }
                    if (check_month > '12') {
                        $("#start_work_remind").remove();
                        $("#form-group5").append('<small class="form-text text-muted" style="color:red !important;" id="start_work_remind">派駐開始日期月份格式不符,月份只能為01-12(格式須為數字<ex:2000-07-28>),請查核！</small>');
                        $("#派駐開始日期").addClass("is-invalid");
                        check_count[3] = 0;
                        return false;
                    }
                    if (i == 5) {
                        x = i + 1;
                        y = i + 3;
                        z = i + 4;
                        var start_char_1 = start_work.charAt(x); //存取i=6時的字元
                        var start_month = start_char + start_char_1; //獲取月份
                        var start_char_8 = start_work.charAt(y); //存取i=8時的字元
                        var start_char_9 = start_work.charAt(z); //存取i=9時的字元
                        var start_day = start_char_8 + start_char_9; //獲取日子 
                        if (start_char != '0' && start_char != '1') { //月份第一個字只能為1,2
                            $("#start_work_remind").remove();
                            $("#form-group5").append('<small class="form-text text-muted" style="color:red !important;" id="start_work_remind">派駐開始日期月份格式不符,月份只能為01-12(格式須為數字<ex:2000-07-28>),請查核！</small>');
                            $("#派駐開始日期").addClass("is-invalid");
                            check_count[3] = 0;
                            return false;

                        }
                        if (start_char == '0') { //月份不為00
                            if (start_char_1 == '0') {
                                $("#start_work_remind").remove();
                                $("#form-group5").append('<small class="form-text text-muted" style="color:red !important;" id="start_work_remind">派駐開始日期月份格式不符,月份不能為00,請查核！</small>');
                                $("#派駐開始日期").addClass("is-invalid");
                                check_count[3] = 0;
                                return false;

                            }
                        }
                        if (check_days == '00') {
                            $("#start_work_remind").remove();
                            $("#form-group5").append('<small class="form-text text-muted" style="color:red !important;" id="start_work_remind">派駐開始日期月份格式不符,日子不能為00,請查核！</small>');
                            $("#派駐開始日期").addClass("is-invalid");
                            check_count[3] = 0;
                            return false;
                        }
                        if (start_month == '01' || start_month == '03' || start_month == '05' || start_month == '07' || start_month == '08' || start_month == '10' || start_month == '12') //判斷大月31天
                        {
                            if (start_day > '31') {
                                $("#start_work_remind").remove();
                                $("#form-group5").append('<small class="form-text text-muted" style="color:red !important;" id="start_work_remind">派駐開始日期格式不符,所填月份與日期不相符(*您輸入的日期不能大於31*),請查核！</small>');
                                $("#派駐開始日期").addClass("is-invalid");
                                check_count[3] = 0;
                                return false;
                            }
                        }
                        if (start_month == '04' || start_month == '06' || start_month == '09' || start_month == '11') //判斷小月30天
                        {
                            if (start_day > '30') {
                                $("#start_work_remind").remove();
                                $("#form-group5").append('<small class="form-text text-muted" style="color:red !important;" id="start_work_remind">派駐開始日期格式不符,所填月份與日期不相符(*您輸入的日期不能大於30*),請查核！</small>');
                                $("#派駐開始日期").addClass("is-invalid");
                                check_count[3] = 0;
                                return false;
                            }

                        }
                        if (start_month == '02') {
                            if (start_day > '29') {
                                $("#start_work_remind").remove();
                                $("#form-group5").append('<small class="form-text text-muted" style="color:red !important;" id="start_work_remind">派駐開始日期格式不符,所填月份與日期不相符(*您輸入的日期不能大於29*),請查核！</small>');
                                $("#派駐開始日期").addClass("is-invalid");
                                check_count[3] = 0;
                                return false;
                            }
                        }

                    }


                }
             
                $("#start_work_remind").remove();
                $("#派駐開始日期").removeClass("is-invalid");
                $("#派駐開始日期").addClass("is-valid");
                check_count[3] = 1;
                return (true);
            }

            function contract_expired() {
                var start_work = document.getElementById("派駐開始日期").value;
                var contract_expired_code = document.getElementById("派駐結束日期").value;
                var check_month = contract_expired_code.substring(5, 7); //檢查月份
                var check_days = contract_expired_code.substring(8, 10);
                var check_date = contract_expired_code.substring(0, 10); //合約到期date
                var check_date_1 = start_work.substring(0, 10); //派駐開始日期date
                var date = new Date();
                var date_year = date.getFullYear(); //獲取目前年份
                if (contract_expired_code == "") {
                    $("#contract_remind").remove();
                    $("#form-group6").append('<small class="form-text text-muted" style="color:red !important;" id="contract_remind">派駐結束日期欄位不能為空,請查核！</small>'); //檢查格式是否為空值
                    $("#派駐結束日期").addClass("is-invalid");
                    check_count[4] = 0;
                    return false;
                }

                if (contract_expired_code.length != 10) {
                    $("#contract_remind").remove();
                    $("#form-group6").append('<small class="form-text text-muted" style="color:red !important;" id="contract_remind">派駐結束日期欄位長度不符,請查核！</small>'); //檢查格式長度
                    $("#派駐結束日期").addClass("is-invalid");
                    check_count[4] = 0;
                    return false;
                }
                for (i = 0; i < contract_expired_code.length; i++) { //檢查'-'格式
                    var contract_expired_char = contract_expired_code.charAt(i);
                    if ((i == 4) || (i == 7)) {
                        if (contract_expired_char != "-") {
                            $("#contract_remind").remove();
                            $("#form-group6").append('<small class="form-text text-muted" style="color:red !important;" id="contract_remind">派駐結束日期欄位格式不符(ex:2000-07-28),請查核！</small>'); //檢查格式'-'
                            $("#派駐結束日期").addClass("is-invalid");
                            check_count[4] = 0;
                            return false;
                        }
                    } else {
                        if (!('0' <= contract_expired_char && contract_expired_char <= '9')) { //檢查是否為數字0-9
                            $("#contract_remind").remove();
                            $("#form-group6").append('<small class="form-text text-muted" style="color:red !important;" id="contract_remind">派駐結束日期欄位格式不符(格式須為數字<ex:2000-07-28>),請查核！</small>');
                            $("#派駐結束日期").addClass("is-invalid");
                            check_count[4] = 0;
                            return false;
                        }
                    }
                    if (check_month > '12') {
                        $("#contract_remind").remove();
                        $("#form-group6").append('<small class="form-text text-muted" style="color:red !important;" id="contract_remind">派駐結束日期欄位月份格式不符,月份只能為01-12(格式須為數字<ex:2000-07-28>),請查核！</small>');
                        $("#派駐結束日期").addClass("is-invalid");
                        check_count[4] = 0;
                        return false;
                    }
                    if (i == 5) {
                        x = i + 1;
                        y = i + 3;
                        z = i + 4;
                        var contract_expired_char_1 = contract_expired_code.charAt(x); //存取i=6時的字元
                        var contract_expired_month = contract_expired_char + contract_expired_char_1; //獲取月份
                        var contract_expired_char_8 = contract_expired_code.charAt(y); //存取i=8時的字元
                        var contract_expired_char_9 = contract_expired_code.charAt(z); //存取i=9時的字元
                        var contract_expired_day = contract_expired_char_8 + contract_expired_char_9; //獲取日子 
                        if (contract_expired_char != '0' && contract_expired_char != '1') { //月份第一個字只能為1,2
                            $("#contract_remind").remove();
                            $("#form-group6").append('<small class="form-text text-muted" style="color:red !important;" id="contract_remind">派駐結束日期欄位月份格式不符,月份只能為01-12(格式須為數字<ex:2000-07-28>),請查核！</small>');
                            $("#派駐結束日期").addClass("is-invalid");
                            check_count[4] = 0;
                            return false;

                        }
                        if (contract_expired_char == '0') { //月份不為00
                            if (contract_expired_char_1 == '0') {
                                $("#contract_remind").remove();
                                $("#form-group6").append('<small class="form-text text-muted" style="color:red !important;" id="contract_remind">派駐結束日期欄位格式不符,月份不能為00,請查核！</small>');
                                $("#派駐結束日期").addClass("is-invalid");
                                check_count[4] = 0;
                                return false;

                            }
                        }
                        if (check_days == '00') {
                            $("#contract_remind").remove();
                            $("#form-group6").append('<small class="form-text text-muted" style="color:red !important;" id="contract_remind">派駐結束日期欄位格式不符,日子不能為00,請查核！</small>');
                            $("#派駐結束日期").addClass("is-invalid");
                            check_count[4] = 0;
                            return false;
                        }
                        if (contract_expired_month == '01' || contract_expired_month == '03' || contract_expired_month == '05' || contract_expired_month == '07' || contract_expired_month == '08' || contract_expired_month == '10' || contract_expired_month == '12') //判斷大月31天
                        {
                            if (contract_expired_day > '31') {
                                $("#contract_remind").remove();
                                $("#form-group6").append('<small class="form-text text-muted" style="color:red !important;" id="contract_remind">派駐結束日期欄位,所填月份與日期不相符(*您輸入的日期不能大於31*),請查核！</small>');
                                $("#派駐結束日期").addClass("is-invalid");
                                check_count[4] = 0;
                                return false;
                            }
                        }
                        if (contract_expired_month == '04' || contract_expired_month == '06' || contract_expired_month == '09' || contract_expired_month == '11') //判斷小月30天
                        {
                            if (contract_expired_day > '30') {
                                $("#contract_remind").remove();
                                $("#form-group6").append('<small class="form-text text-muted" style="color:red !important;" id="contract_remind">派駐結束日期欄位,所填月份與日期不相符(*您輸入的日期不能大於30*),請查核！</small>');
                                $("#派駐結束日期").addClass("is-invalid");
                                check_count[4] = 0;
                                return false;
                            }

                        }
                        if (contract_expired_month == '02') {
                            if (contract_expired_day > '29') {
                                $("#contract_remind").remove();
                                $("#form-group6").append('<small class="form-text text-muted" style="color:red !important;" id="contract_remind">派駐結束日期欄位,所填月份與日期不相符(*您輸入的日期不能大於29*),請查核！</small>');
                                $("#派駐結束日期").addClass("is-invalid");
                                check_count[4] = 0;
                                return false;
                            }
                        }



                    }

                }
                if ((Date.parse(check_date)).valueOf() < (Date.parse(check_date_1).valueOf())) {
                    $("#contract_remind").remove();
                    $("#form-group6").append('<small class="form-text text-muted" style="color:red !important;" id="contract_remind">派駐結束日期欄位格式不符,派駐開始日期不能大於合約派駐開始日期,請查核！</small>');
                    $("#派駐結束日期").addClass("is-invalid");
                    check_count[4] = 0;
                    return false;
                }



                $("#contract_remind").remove();
                $("#派駐結束日期").removeClass("is-invalid");
                $("#派駐結束日期").addClass("is-valid");
                check_count[4] = 1;
                return (true);
            }



            
        </script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</body>

</html>