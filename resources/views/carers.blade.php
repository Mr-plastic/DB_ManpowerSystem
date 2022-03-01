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
    
    .error {
        position: fixed;
        top: 16px;
        left: 50%;
        z-index: 10000;
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
        z-index: 10000;
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
                    <a class="nav-link nav-item-active text-light" href="{{ url('/showcarers') }}">照護人員表</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="{{ url('/showcarestation') }}">派駐資料表</a>
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

            <div class="container text-light">
                <center class="pt-3">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4">
                                <h3 class="">照護人員平均年齡:</h3>
                                <h4 class="">{{ $average_age }}歲</h4>
                            </div>
                            <div class="col-md-4">
                                <h3 class="">照護人員男女人數統計:</h3>
                                <h4 class="">{{ $male }}男 {{ $female }}女</h4>
                            </div>
                            <div class="col-md-4">
                                <h3 class="">照護人員平均薪資:</h3>
                                <h4 class="">{{ $average_salary }}元</h4>
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
                            照護人員資料
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#add-carers-modal">新增資料</button>
                        </div>
                        <!-- 創建搜尋紐 -->
                        <form class="form-inline ">
                            <input class="form-control mr-sm-2" type="text" placeholder="照護人員ID" aria-label="Search" id="search-carers-id" name="照護人員ID">
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
                                    <th scope="col">國籍</th>
                                    <th scope="col">薪資</th>
                                    <th scope="col">性別</th>
                                    <th scope="col">生日</th>
                                    <th scope="col">資料狀態</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody id="tbody">
                                @foreach($datas as $data)

                                <tr>
                                    <th scope="row">{{ --$data_length}}</th>
                                    <td>{{ $data->照護人員ID }}</td>
                                    <td>{{ $data->照護人員姓名 }}</td>
                                    <td>{{ $data->國籍 }}</td>
                                    <td>{{ $data->薪資 }}</td>
                                    <td>{{ $data->照護人員性別 }}</td>
                                    <td>{{ $data->照護人員生日 }}</td>
                                    <td>{{ $data->資料狀態 }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary" onclick="show_carers('{{$data->照護人員ID}}')" data-toggle="modal" data-target="#info-carers-modal">Info</button>
                                        <button type="button" class="btn btn-primary" onclick="show_edit_carers('{{$data->照護人員ID}}')" data-toggle="modal" data-target="#edit-carers-modal">Edit</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- 創建新增Modal -->
            <div class="modal fade" id="add-carers-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">新增資料</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="add-carers-form">
                                <div class="form-group" id="care_id_1">
                                    <label for="exampleInputEmail1">照護人員ID</label>
                                    <input type="input" class="form-control" id="照護人員ID" aria-describedby="emailHelp" placeholder="ex.A123456789" required>
                                </div>
                                <div class="form-group" id="care_id_2">
                                    <label for="exampleInputPassword1">照護人員姓名</label>
                                    <input type="input" class="form-control" id="照護人員姓名" placeholder="ex.王大明" required>
                                </div>
                                <div class="form-group" id="care_id_3">
                                    <label for="exampleInputPassword1">國籍</label>
                                    <input type="input" class="form-control" id="國籍" placeholder="ex.日本" required>
                                </div>
                                <div class="form-group" id="care_id_4">
                                    <label for="exampleInputPassword1">照護人員性別</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input sex" type="radio" id="inlineCheckbox1" value="男性" name="sex" required>
                                        <label class="form-check-label" for="inlineCheckbox1">男姓</label>
                                        <input class="form-check-input ml-2 sex" type="radio" id="inlineCheckbox1" value="女性" name="sex" required>
                                        <label class="form-check-label" for="inlineCheckbox1">女姓</label>
                                    </div>
                                </div>
                                <div class="form-group" id="care_id_5">
                                    <label for="exampleInputPassword1">薪資</label>
                                    <input type="input" class="form-control" id="薪資" placeholder="ex.22000" required>
                                </div>
                                <div class="form-group" id="care_id_6">
                                    <label for="exampleInputPassword1">電話</label>
                                    <input type="input" class="form-control" id="電話" placeholder="ex.+8860912256431" required>
                                </div>
                                <div class="form-group" id="care_id_7">
                                    <label for="exampleInputPassword1">照護人員生日</label>
                                    <input type="input" class="form-control" id="照護人員生日" placeholder="yyyy-mm-dd" required>
                                </div>
                                <div class="form-group" id="care_id_8">
                                    <label for="exampleInputPassword1">到職日期</label>
                                    <input type="input" class="form-control" id="到職日期" placeholder="yyyy-mm-dd" required>
                                </div>
                                <div class="form-group" id="care_id_9">
                                    <label for="exampleInputPassword1">長照人力公司合約到期日</label>
                                    <input type="input" class="form-control" id="長照人力公司合約到期日" placeholder="yyyy-mm-dd" required>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" id="form-submit" >Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 創建info modal id1-->
            <div class="modal fade" id="info-carers-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">詳細資料</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
                        </div>
                        <div class="modal-body">
                            <form id="add-carers-form">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">照護人員ID</label>
                                    <input type="input" class="form-control" id="照護人員ID1" aria-describedby="emailHelp" placeholder="ex.A123456789" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">照護人員姓名</label>
                                    <input type="input" class="form-control" id="照護人員姓名1" placeholder="ex.王大明" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">國籍</label>
                                    <input type="input" class="form-control" id="國籍1" placeholder="ex.日本" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">照護人員性別</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input sex1" type="radio" id="inlineCheckbox1" value="男性" name="sex" required>
                                        <label class="form-check-label" for="inlineCheckbox1">男姓</label>
                                        <input class="form-check-input ml-2 sex1" type="radio" id="inlineCheckbox1" value="女性" name="sex" required>
                                        <label class="form-check-label" for="inlineCheckbox1">女姓</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">薪資</label>
                                    <input type="input" class="form-control" id="薪資1" placeholder="ex.22000" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">電話</label>
                                    <input type="input" class="form-control" id="電話1" placeholder="ex.+8860912256431" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">照護人員生日</label>
                                    <input type="input" class="form-control" id="照護人員生日1" placeholder="yyyy-mm-dd" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">到職日期</label>
                                    <input type="input" class="form-control" id="到職日期1" placeholder="yyyy-mm-dd" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">長照人力公司合約到期日</label>
                                    <input type="input" class="form-control" id="長照人力公司合約到期日1" placeholder="yyyy-mm-dd" required>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 創建edit modal id2-->
            <div class="modal fade" id="edit-carers-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">詳細資料</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
                        </div>
                        <div class="modal-body">
                            <form id="add-carers-form">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">照護人員ID</label>
                                    <input type="input" class="form-control" id="照護人員ID2" aria-describedby="emailHelp" placeholder="ex.A123456789" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">照護人員姓名</label>
                                    <input type="input" class="form-control" id="照護人員姓名2" placeholder="ex.王大明" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">國籍</label>
                                    <input type="input" class="form-control" id="國籍2" placeholder="ex.日本" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">照護人員性別</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input sex2" type="radio" id="inlineCheckbox1" value="男性" name="sex" required>
                                        <label class="form-check-label" for="inlineCheckbox1">男姓</label>
                                        <input class="form-check-input ml-2 sex2" type="radio" id="inlineCheckbox1" value="女性" name="sex" required>
                                        <label class="form-check-label" for="inlineCheckbox1">女姓</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">薪資</label>
                                    <input type="input" class="form-control" id="薪資2" placeholder="ex.22000" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">電話</label>
                                    <input type="input" class="form-control" id="電話2" placeholder="ex.+8860912256431" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">照護人員生日</label>
                                    <input type="input" class="form-control" id="照護人員生日2" placeholder="yyyy-mm-dd" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">到職日期</label>
                                    <input type="input" class="form-control" id="到職日期2" placeholder="yyyy-mm-dd" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">長照人力公司合約到期日</label>
                                    <input type="input" class="form-control" id="長照人力公司合約到期日2" placeholder="yyyy-mm-dd" required>
                                </div>
                                <div class="form-group">
                                    <label class="mr-sm-2" for="selection2">Preference</label>
                                    <select class="custom-select mr-sm-2 selection2" id="selection2">
                                        <option value="聘任中" >聘任中</option>
                                        <option value="離職">離職</option>
                                    </select>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" id="save-edit">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- 創建search modal -->
            <div class="modal fade" id="search-carers-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">搜尋資料</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="add-carers-form">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">照護人員ID</label>
                                    <input type="input" class="form-control" id="照護人員ID3" aria-describedby="emailHelp" placeholder="ex.A123456789" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">照護人員姓名</label>
                                    <input type="input" class="form-control" id="照護人員姓名3" placeholder="ex.王大明" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">國籍</label>
                                    <input type="input" class="form-control" id="國籍3" placeholder="ex.日本" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">照護人員性別</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input sex3" type="radio" id="inlineCheckbox1" value="男性" name="sex" required>
                                        <label class="form-check-label" for="inlineCheckbox1">男姓</label>
                                        <input class="form-check-input ml-2 sex3" type="radio" id="inlineCheckbox1" value="女性" name="sex" required>
                                        <label class="form-check-label" for="inlineCheckbox1">女姓</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">薪資</label>
                                    <input type="input" class="form-control" id="薪資3" placeholder="ex.22000" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">電話</label>
                                    <input type="input" class="form-control" id="電話3" placeholder="ex.+8860912256431" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">照護人員生日</label>
                                    <input type="input" class="form-control" id="照護人員生日3" placeholder="yyyy-mm-dd" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">到職日期</label>
                                    <input type="input" class="form-control" id="到職日期3" placeholder="yyyy-mm-dd" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">長照人力公司合約到期日</label>
                                    <input type="input" class="form-control" id="長照人力公司合約到期日3" placeholder="yyyy-mm-dd" required>
                                </div>
                                <div class="form-group">
                                    <label class="mr-sm-2" for="selection3">Preference</label>
                                    <select class="custom-select mr-sm-2 selection3" id="selection3">
                              <option value="聘任中" >聘任中</option>
                              <option value="離職">離職</option>
                            </select>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" id="save-search">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-2"></div>
            </div>
        </div>
        <script type="text/javascript">
            var check_count = new Array(9);
            //新增資料ajax
            $("#form-submit").click(function(e) {
                for(i =0;i<9;i++){
                    check_count[i] = 0;
                }
                checkcare_code();
                if(check_count[0] == 1){
                    let carers_id = $("#照護人員ID").val();
                    $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{route('add-carers')}}",
                    type: "POST",
                    data: {
                        carers_id: carers_id,
                    },
                    success: function(response) {
                        if (response == '照護人員已存在，請用編輯模式!') {
                            $("#error").html("照護人員已存在，請用編輯模式!");
                            var h = document.querySelector(".error"); //錯誤代碼
                            h.classList.add("active");
                            setTimeout(function() {
                                h.classList.remove('active');
                            }, 4000);
                            return false;
                        } 
                    }

                });
                }
                care_name();
                country();
                gender();
                salary();
                phone();
                brithday();
                start_work();
                contract_expired();
                e.preventDefault();

                if(!check_count.includes(0)){
                    let carers_id = $("#照護人員ID").val();
                    let carers_name = $("#照護人員姓名").val();
                    let nation = $("#國籍").val();
                    let sex = $(".sex:checked").val();
                    let carers_salary = $("#薪資").val();
                    let carers_phone = $("#電話").val();
                    let carers_birth = $('#照護人員生日').val();
                    let carers_start_date = $("#到職日期").val();
                    let carers_end_date = $("#長照人力公司合約到期日").val();

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: "{{route('add-carers')}}",
                        type: "POST",
                        data: {
                            carers_id: carers_id,
                            carers_name: carers_name,
                            nation: nation,
                            sex: sex,
                            carers_salary: carers_salary,
                            carers_phone: carers_phone,
                            carers_birth: carers_birth,
                            carers_start_date: carers_start_date,
                            carers_end_date: carers_end_date
                        },
                        success: function(response) {
                            if (response == '照護人員已存在，請用編輯模式!') {
                                $("#error").html("照護人員已存在，請用編輯模式!");
                                var h = document.querySelector(".error"); //錯誤代碼
                                h.classList.add("active");
                                setTimeout(function() {
                                    h.classList.remove('active');
                                }, 4000);
                                return false;
                            } else {
                                $("#add-carers-form")[0].reset();
                                $("#add-carers-modal").modal('hide');
                                document.cookie = "save_add=1;";
                                location.reload();
                            }

                            console.log(response);
                        }

                    });
                }
            });
        </script>
        <script>
            //show詳細資料
            function show_carers(carersID) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{route('info-carers')}}",
                    type: "POST",
                    data: {
                        carersID: carersID,
                    },
                    success: function(response) {
                        if (response) {
                            $(".sex1").attr('checked', false); //清空sex值
                            $("#照護人員ID1").val(response[0][0]['照護人員ID']);
                            $("#照護人員姓名1").val(response[0][0]['照護人員姓名']);
                            $("#國籍1").val(response[0][0]['國籍']);
                            if (response[0][0]['照護人員性別'] == '女性') {
                                $(".sex1[value='女性']").attr('checked', true);
                            } else {
                                $(".sex1[value='男性']").attr('checked', true);
                            }
                            $("#薪資1").val(response[0][0]['薪資']);
                            $("#電話1").val(response[0][0]['電話']);
                            $('#照護人員生日1').val(response[0][0]['照護人員生日']);
                            $("#到職日期1").val(response[0][0]['到職日期']);
                            $("#長照人力公司合約到期日1").val(response[0][0]['長照人力公司合約到期日']);

                        }
                        console.log(response);
                    }

                });
            }
        </script>
        <script>
            let initial_carers_id;
            let initial_carers_name;
            //show edit資料
            function show_edit_carers(carersID) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{route('show-edit-carers')}}",
                    type: "POST",
                    data: {
                        carersID: carersID,
                    },
                    success: function(response) {
                        if (response) {
                            $(".sex2").attr('checked', false); //清空sex值
                            $("#照護人員ID2").val(response[0][0]['照護人員ID']);
                            $("#照護人員姓名2").val(response[0][0]['照護人員姓名']);
                            $("#國籍2").val(response[0][0]['國籍']);
                            if (response[0][0]['照護人員性別'] == '女性') {
                                $(".sex2[value='女性']").attr('checked', true);
                            } else {
                                $(".sex2[value='男性']").attr('checked', true);
                            }
                            $("#薪資2").val(response[0][0]['薪資']);
                            $("#電話2").val(response[0][0]['電話']);
                            $('#照護人員生日2').val(response[0][0]['照護人員生日']);
                            $("#到職日期2").val(response[0][0]['到職日期']);
                            $("#長照人力公司合約到期日2").val(response[0][0]['長照人力公司合約到期日']);
                            $("#selection2").val(response[0][0]['資料狀態']);
                            initial_carers_id = response[0][0]['照護人員ID'];
                            initial_carers_name = response[0][0]['照護人員姓名'];
                        }
                        console.log(response);
                    }

                });
            }

            //save edit表單
            $("#save-edit").click(function(e) {
                e.preventDefault();
                let carers_id = $("#照護人員ID2").val();
                let carers_name = $("#照護人員姓名2").val();
                let nation = $("#國籍2").val();
                let sex = $(".sex2:checked").val();
                let carers_salary = $("#薪資2").val();
                let carers_phone = $("#電話2").val();
                let carers_birth = $('#照護人員生日2').val();
                let carers_start_date = $("#到職日期2").val();
                let carers_end_date = $("#長照人力公司合約到期日2").val();
                let select = $("#selection2").val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{route('save-edit-carers')}}",
                    type: "POST",
                    data: {
                        initial_carers_id: initial_carers_id,
                        initial_carers_name: initial_carers_name,
                        carers_id: carers_id,
                        carers_name: carers_name,
                        nation: nation,
                        sex: sex,
                        carers_salary: carers_salary,
                        carers_phone: carers_phone,
                        carers_birth: carers_birth,
                        carers_start_date: carers_start_date,
                        carers_end_date: carers_end_date,
                        select: select
                    },
                    success: function(response) {
                        if (response) {
                            $("#add-carers-form")[0].reset();
                            $("#edit-carers-modal").modal('hide');
                            document.cookie = "save_edit=1;";
                            location.reload();

                        }

                        console.log(response);
                    }

                });
            });
        </script>
        <script>
            //show search資料
            $("#search-submit").click(function(e) {
                e.preventDefault();
                if ($("#search-carers-id").val() == "") { //如果家庭代碼，受照護者姓名為空 按鈕不觸發
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
                    url: "{{route('show-search-carers')}}",
                    type: "POST",
                    data: {
                        carers_id: carers_id,
                    },
                    success: function(response) {
                        if (response[0].length > 0) {
                            $('#search-carers-modal').modal('show');
                            $(".sex3").attr('checked', false); //清空sex值
                            $("#照護人員ID3").val(response[0][0]['照護人員ID']);
                            $("#照護人員姓名3").val(response[0][0]['照護人員姓名']);
                            $("#國籍3").val(response[0][0]['國籍']);
                            if (response[0][0]['照護人員性別'] == '女性') {
                                $(".sex3[value='女性']").attr('checked', true);
                            } else {
                                $(".sex3[value='男性']").attr('checked', true);
                            }
                            $("#薪資3").val(response[0][0]['薪資']);
                            $("#電話3").val(response[0][0]['電話']);
                            $('#照護人員生日3').val(response[0][0]['照護人員生日']);
                            $("#到職日期3").val(response[0][0]['到職日期']);
                            $("#長照人力公司合約到期日3").val(response[0][0]['長照人力公司合約到期日']);
                            $("#selection3").val(response[0][0]['資料狀態']);
                            initial_carers_id = response[0][0]['照護人員ID'];
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
            //save search表單
            $("#save-search").click(function(e) {
                e.preventDefault();
                let carers_id = $("#照護人員ID3").val();
                let carers_name = $("#照護人員姓名3").val();
                let nation = $("#國籍3").val();
                let sex = $(".sex3:checked").val();
                let carers_salary = $("#薪資3").val();
                let carers_phone = $("#電話3").val();
                let carers_birth = $('#照護人員生日3').val();
                let carers_start_date = $("#到職日期3").val();
                let carers_end_date = $("#長照人力公司合約到期日3").val();
                let select = $("#selection3").val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{route('save-search-carers')}}",
                    type: "POST",
                    data: {
                        initial_carers_id: initial_carers_id,
                        carers_id: carers_id,
                        carers_name: carers_name,
                        nation: nation,
                        sex: sex,
                        carers_salary: carers_salary,
                        carers_phone: carers_phone,
                        carers_birth: carers_birth,
                        carers_start_date: carers_start_date,
                        carers_end_date: carers_end_date,
                        select: select
                    },
                    success: function(response) {
                        if (response) {
                            $("#add-carers-form")[0].reset();
                            $("#edit-carers-modal").modal('hide');
                            document.cookie = "save_edit=1;";
                            location.reload();

                        }

                        console.log(response);
                    }

                });
            });
        </script>
        <!-- 宗勳code -->
        <script>
            function checkcare_code() { //照護人員ID檢測
                var care_code = document.getElementById("照護人員ID").value;
                var letters = new Array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'K', 'L', 'M', 'N', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'X', 'Y', 'W', 'Z', 'I', 'O');
                var multiply = new Array(1, 9, 8, 7, 6, 5, 4, 3, 2, 1);
                var nums = new Array(2);
                var firstChar;
                var firstNum;
                var lastNum;
                var total = 0;
                firstChar = care_code.charAt(0).toUpperCase();
                lastNum = care_code.charAt(9);
                if (care_code == "") {
                    $("#care_code_remind").remove();
                    $("#care_id_1").append('<small class="form-text text-muted" style="color:red !important;" id="care_code_remind">照護人員ID不能為空,請查核！</small>'); //檢查格式是否為空值
                    $("#照護人員ID").addClass("is-invalid");
                    check_count[0] = 0;
                    return false;
                }
                if (care_code.length != 10) {
                    $("#care_code_remind").remove();
                    $("#care_id_1").append('<small class="form-text text-muted" style="color:red !important;" id="care_code_remind">照護人員ID長度不符,請查核！</small>'); //檢查格式是否為空值"")
                    $("#照護人員ID").addClass("is-invalid");
                    check_count[0] = 0;
                    return false;
                }
                for (i = 0; i < 10; i++) {
                    var character = care_code.charAt(i);
                    if (i == 0) { // 檢查第一碼是否是"A-Z" 
                        if (!('A' <= character && character <= 'Z')) {
                            $("#care_code_remind").remove();
                            $("#care_id_1").append('<small class="form-text text-muted" style="color:red !important;" id="care_code_remind">照護人員ID輸入有誤（第一碼請為A-Z）,請查核!</small>');
                            $("#照護人員ID").addClass("is-invalid");
                            check_count[0] = 0;
                            return false;
                        }
                    }
                    if (i == 1) {
                        if (character != '0' && character != '1') { //用ASCII檢查第二碼是否為0或1
                            $("#care_code_remind").remove();
                            $("#care_id_1").append('<small class="form-text text-muted" style="color:red !important;" id="care_code_remind">照護人員ID不符正式格式請重新輸入,請查核!</small>');
                            $("#照護人員ID").addClass("is-invalid");
                            check_count[0] = 0;
                            return false;
                        }
                    }
                    if (2 <= i && i <= 10) {
                        if (!('0' <= character && character <= '9')) { //用ASCII檢查後八碼是否為0~9
                            $("#care_code_remind").remove();
                            $("#care_id_1").append('<small class="form-text text-muted" style="color:red !important;" id="care_code_remind">照護人員ID輸入後八碼須為數字,請查核!</small>');
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
                            total += parseInt(care_code.charAt(i - 1)) *
                                multiply[i];
                        }
                    }
                    if (lastNum == 0 && (total % 10) != lastNum) {
                        $("#care_code_remind").remove();
                        $("#care_id_1").append('<small class="form-text text-muted" style="color:red !important;" id="care_code_remind">照護人員ID不符合正式格式,請查核!</small>');
                        $("#照護人員ID").addClass("is-invalid");
                        check_count[0] = 0;
                        return false;
                    }
                    if (lastNum != 0 && (10 - (total % 10)) != lastNum) {
                        $("#care_code_remind").remove();
                        $("#care_id_1").append('<small class="form-text text-muted" style="color:red !important;" id="care_code_remind">照護人員ID不符合正式格式,請查核!</small>');
                        $("#照護人員ID").addClass("is-invalid");
                        check_count[0] = 0;
                        return false;
                    }


                }
                $("#care_code_remind").remove();
                $("#照護人員ID").removeClass("is-invalid");
                $("#照護人員ID").addClass("is-valid");
                check_count[0] = 1;
                return (true);
            }

            function care_name() { //照護者姓名檢測
                var care_code = document.getElementById("照護人員姓名").value;
                if (care_code == "") { //檢查格式是否為空值
                    $("#care_name_remind").remove();
                    $("#care_id_2").append('<small class="form-text text-muted" style="color:red !important;" id="care_name_remind">照護人員姓名不能為空,請查核！</small>');
                    $("#照護人員姓名").addClass("is-invalid");
                    check_count[1] = 0;
                    return false;
                }
                if (care_code.length > 19) {
                    $("#care_name_remind").remove();
                    $("#care_id_2").append('<small class="form-text text-muted" style="color:red !important;" id="care_name_remind">照護者姓名需小於20字,請查核！</small>');
                    $("#照護人員姓名").addClass("is-invalid");
                    check_count[1] = 0;
                    return false;
                }
                $("#care_name_remind").remove();
                $("#照護人員姓名").removeClass("is-invalid");
                $("#照護人員姓名").addClass("is-valid");
                check_count[1] = 1;
                return (true);
            }

            function country() { //國籍檢測
                var country_code = document.getElementById("國籍").value;
                if (country_code == "") { //檢查格式是否為空值
                    $("#country_remind").remove();
                    $("#care_id_3").append('<small class="form-text text-muted" style="color:red !important;" id="country_remind">國籍不能為空,請查核！</small>');
                    $("#國籍").addClass("is-invalid");
                    check_count[2] = 0;
                    return false;
                }
                if (country_code.length > 15) {
                    $("#country_remind").remove();
                    $("#care_id_3").append('<small class="form-text text-muted" style="color:red !important;" id="country_remind">國籍需小於16字,請查核！</small>');
                    $("#國籍").addClass("is-invalid");
                    check_count[2] = 0;
                    return false;
                }
                $("#country_remind").remove();
                $("#國籍").removeClass("is-invalid");
                $("#國籍").addClass("is-valid");
                check_count[2] = 1;
                return (true);
            }

            function gender() { //受照護者性別檢測
                let sex = $(".sex:checked").val();
                if (sex == null) { //檢測是否為空
                    $("#care_gender_remind").remove();
                    $("#care_id_4").append('<small class="form-text text-muted" style="color:red !important;" id="care_gender_remind">請選取照護人員性別！</small>');
                    $("#照護人員性別").addClass("is-invalid");
                    check_count[3] = 0;
                    return false;
                }
                $("#care_gender_remind").remove();
                $("#照護人員性別").removeClass("is-invalid");
                $("#照護人員性別").addClass("is-valid");
                check_count[3] = 1;
                return (true);
            }

            function salary() { //受照護者姓名檢測
                var salary_code = document.getElementById("薪資").value;
                if (salary_code == "") { //檢查格式是否為空值
                    $("#salary_remind").remove();
                    $("#care_id_5").append('<small class="form-text text-muted" style="color:red !important;" id="salary_remind">薪資欄位不能為空,請查核！</small>');
                    $("#薪資").addClass("is-invalid");
                    check_count[4] = 0;
                    return false;
                }
                if (salary_code.length > 9) {
                    $("#salary_remind").remove();
                    $("#care_id_5").append('<small class="form-text text-muted" style="color:red !important;" id="salary_remind">薪資欄位需小於10字,請查核！</small>');
                    $("#薪資").addClass("is-invalid");
                    check_count[4] = 0;
                    return false;
                }
                for (i = 0; i < salary_code.length; i++) {
                    var salary_char = salary_code.charAt(i);
                    if (!('0' <= salary_char && salary_char <= '9')) { //用ASCII檢查後七碼是否為0~9
                        $("#salary_remind").remove();
                        $("#care_id_5").append('<small class="form-text text-muted" style="color:red !important;" id="salary_remind">薪資欄位須為數字,ex:123456,請查核!</small>');
                        $("#薪資").addClass("is-invalid");
                        check_count[4] = 0;
                        return false;
                    }
                }
                $("#salary_remind").remove();
                $("#薪資").removeClass("is-invalid");
                $("#薪資").addClass("is-valid");
                check_count[4] = 1;
                return (true);
            }

            function phone() {
                var phone = document.getElementById("電話").value;
                if (phone == "") {
                    $("#phone_remind").remove();
                    $("#care_id_6").append('<small class="form-text text-muted" style="color:red !important;" id="phone_remind">電話不能為空,請查核！</small>'); //檢查格式是否為空值
                    $("#電話").addClass("is-invalid");
                    check_count[5] = 0;
                    return false;
                }
                if (phone.length != 14) {
                    $("#phone_remind").remove();
                    $("#care_id_6").append('<small class="form-text text-muted" style="color:red !important;" id="phone_remind">電話長度不符,格式為<+886>09xxxxxxxx,之14碼電話,請查核！</small>'); //檢查格式是否為空值"")
                    $("#電話").addClass("is-invalid");
                    check_count[5] = 0;
                    return false;
                }
                for (i = 0; i < 14; i++) {
                    var check_phone = phone.charAt(i);
                    if (i == 0) { // 檢查第一碼是否是 "+"
                        if (check_phone != "+") {
                            $("#phone_remind").remove();
                            $("#care_id_6").append('<small class="form-text text-muted" style="color:red !important;" id="phone_remind">電話第一碼為"+",請查核!</small>');
                            $("#電話").addClass("is-invalid");
                            check_count[5] = 0;
                            return false;
                        }
                    }
                    if (1 <= i && i <= 14) {
                        if (!('0' <= check_phone && check_phone <= '9')) { //用ASCII檢查後七碼是否為0~9
                            $("#phone_remind").remove();
                            $("#care_id_6").append('<small class="form-text text-muted" style="color:red !important;" id="phone_remind">電話須為數字,請查核!</small>');
                            $("#電話").addClass("is-invalid");
                            check_count[5] = 0;
                            return false;
                        }
                    }
                }
                $("#phone_remind").remove();
                $("#電話").removeClass("is-invalid");
                $("#電話").addClass("is-valid");
                check_count[5] = 1;
                return (true);
            }

            function brithday() {
                var carer_birth = document.getElementById("照護人員生日").value;
                var check_age = carer_birth.substring(0, 4);
                var check_month = carer_birth.substring(5, 7);
                var check_days = carer_birth.substring(8, 10);
                var date = new Date();
                var date_year = date.getFullYear();
                if (carer_birth == "") {
                    $("#care_remind").remove();
                    $("#care_id_7").append('<small class="form-text text-muted" style="color:red !important;" id="care_remind">照護人員生日不能為空,請查核！</small>'); //檢查格式是否為空值
                    $("#照護人員生日").addClass("is-invalid");
                    check_count[6] = 0;
                    return false;
                }

                if (carer_birth.length != 10) {
                    $("#care_remind").remove();
                    $("#care_id_7").append('<small class="form-text text-muted" style="color:red !important;" id="care_remind">照護人員生日長度不符,請查核！</small>'); //檢查格式是否為長度符合
                    $("#照護人員生日").addClass("is-invalid");
                    check_count[6] = 0;
                    return false;
                }
                for (i = 0; i < carer_birth.length; i++) {
                    var care_bri_char = carer_birth.charAt(i);
                    if ((i == 4) || (i == 7)) {
                        if (care_bri_char != "-") {
                            $("#care_remind").remove();
                            $("#care_id_7").append('<small class="form-text text-muted" style="color:red !important;" id="care_remind">照護人員生日格式不符(ex:2000-07-28),請查核！</small>'); //檢查格式是否為空值
                            $("#照護人員生日").addClass("is-invalid");
                            check_count[6] = 0;
                            return false;
                        }
                    } else {
                        if (!('0' <= care_bri_char && care_bri_char <= '9')) { //檢查是否為數字0-9
                            $("#care_remind").remove();
                            $("#care_id_7").append('<small class="form-text text-muted" style="color:red !important;" id="care_remind">照護人員生日格式不符(格式須為數字<ex:2000-07-28>),請查核！</small>');
                            $("#照護人員生日").addClass("is-invalid");
                            check_count[6] = 0;
                            return false;
                        }

                    }
                    if (check_month > '12') {
                        $("#care_remind").remove();
                        $("#care_id_7").append('<small class="form-text text-muted" style="color:red !important;" id="care_remind">照護人員生日月份格式不符,月份只能為01-12(格式須為數字<ex:2000-07-28>),請查核！</small>');
                        $("#照護人員生日").addClass("is-invalid");
                        check_count[6] = 0;
                        return false;

                    }


                    if (i == 5) {
                        x = i + 1;
                        y = i + 3;
                        z = i + 4;
                        var care_bri_char_1 = carer_birth.charAt(x); //存取i=6時的字元
                        var carer_birth_month = care_bri_char + care_bri_char_1; //獲取月份
                        var care_bri_char_8 = carer_birth.charAt(y); //存取i=8時的字元
                        var care_bri_char_9 = carer_birth.charAt(z); //存取i=9時的字元
                        var carer_birth_day = care_bri_char_8 + care_bri_char_9; //獲取日子 
                        if (care_bri_char != '0' && care_bri_char != '1') { //月份第一個字只能為1,2
                            $("#care_remind").remove();
                            $("#care_id_7").append('<small class="form-text text-muted" style="color:red !important;" id="care_remind">照護人員生日月份格式不符,月份只能為01-12(格式須為數字<ex:2000-07-28>),請查核！</small>');
                            $("#照護人員生日").addClass("is-invalid");
                            check_count[6] = 0;
                            return false;

                        }
                        if (care_bri_char == '0') { //月份不為00
                            if (care_bri_char_1 == '0') {
                                $("#care_remind").remove();
                                $("#care_id_7").append('<small class="form-text text-muted" style="color:red !important;" id="care_remind">照護人員生日格式不符,月份不能為00,請查核！</small>');
                                $("#照護人員生日").addClass("is-invalid");
                                check_count[6] = 0;
                                return false;

                            }
                        }
                        if (check_days == '00') {
                            $("#care_remind").remove();
                            $("#care_id_7").append('<small class="form-text text-muted" style="color:red !important;" id="care_remind">照護人員生日格式不符,日子不能為00,請查核！</small>');
                            $("#照護人員生日").addClass("is-invalid");
                            check_count[6] = 0;
                            return false;
                        }
                        if (carer_birth_month == '01' || carer_birth_month == '03' || carer_birth_month == '05' || carer_birth_month == '07' || carer_birth_month == '08' || carer_birth_month == '10' || carer_birth_month == '12') //判斷大月31天
                        {
                            if (carer_birth_day > '31') {
                                $("#care_remind").remove();
                                $("#care_id_7").append('<small class="form-text text-muted" style="color:red !important;" id="care_remind">照護人員生日格式不符,所填月份與日期不相符(*您輸入的日期不能大於31*),請查核！</small>');
                                $("#照護人員生日").addClass("is-invalid");
                                check_count[6] = 0;
                                return false;
                            }
                        }
                        if (carer_birth_month == '04' || carer_birth_month == '06' || carer_birth_month == '09' || carer_birth_month == '11') //判斷小月30天
                        {
                            if (carer_birth_day > '30') {
                                $("#care_remind").remove();
                                $("#care_id_7").append('<small class="form-text text-muted" style="color:red !important;" id="care_remind">照護人員生日格式不符,所填月份與日期不相符(*您輸入的日期不能大於30*),請查核！</small>');
                                $("#照護人員生日").addClass("is-invalid");
                                check_count[6] = 0;
                                return false;
                            }

                        }
                        if (carer_birth_month == '02') {
                            if (carer_birth_day > '29') {
                                $("#care_remind").remove();
                                $("#care_id_7").append('<small class="form-text text-muted" style="color:red !important;" id="care_remind">照護人員生日格式不符,所填月份與日期不相符(*您輸入的日期不能大於29*),請查核！</small>');
                                $("#照護人員生日").addClass("is-invalid");
                                check_count[6] = 0;
                                return false;
                            }
                        }

                    }
                    if (parseInt(check_age, 10) > (date_year - 16) || parseInt(check_age, 10) < (date_year - 60)) {
                        $("#care_remind").remove();
                        $("#care_id_7").append('<small class="form-text text-muted" style="color:red !important;" id="care_remind">照護人員的年齡不得小於（可以等於）十六歲，亦不得高於（可以等於）六十歲,請查核！</small>'); //檢查格式是否為空值
                        $("#照護人員生日").addClass("is-invalid");
                        check_count[6] = 0;
                        return false;
                    }
                }
                $("#care_remind").remove();
                $("#照護人員生日").removeClass("is-invalid");
                $("#照護人員生日").addClass("is-valid");
                check_count[6] = 1;
                return (true);
            }

            function start_work() {
                var start_work = document.getElementById("到職日期").value;
                var contract_expired_code = document.getElementById("長照人力公司合約到期日").value;
                var carer_birth = document.getElementById("照護人員生日").value;
                var check_date = start_work.substring(0, 10); //到職date
                var check_date_1 = carer_birth.substring(0, 10) //出生date
                var check_year = start_work.substring(0, 4); //到職年份
                var check_year_1 = carer_birth.substring(0, 4) //出生年份
                var check_month = start_work.substring(5, 7); //檢查月份
                var check_days = start_work.substring(8, 10);
                var date = new Date();
                var date_year = date.getFullYear(); //獲取目前年份
                if (start_work == "") {
                    $("#start_work_remind").remove();
                    $("#care_id_8").append('<small class="form-text text-muted" style="color:red !important;" id="start_work_remind">到職日期欄位不能為空,請查核！</small>'); //檢查格式是否為空值
                    $("#到職日期").addClass("is-invalid");
                    check_count[7] = 0;
                    return false;
                }

                if (start_work.length != 10) {
                    $("#start_work_remind").remove();
                    $("#care_id_8").append('<small class="form-text text-muted" style="color:red !important;" id="start_work_remind">到職日期長度不符,請查核！</small>'); //檢查格式是否為長度符合
                    $("#到職日期").addClass("is-invalid");
                    check_count[7] = 0;
                    return false;
                }
                for (i = 0; i < start_work.length; i++) { //檢查'-'格式
                    var start_char = start_work.charAt(i);
                    if ((i == 4) || (i == 7)) {
                        if (start_char != "-") {
                            $("#start_work_remind").remove();
                            $("#care_id_8").append('<small class="form-text text-muted" style="color:red !important;" id="start_work_remind">到職日期格式不符(ex:2000-07-28),請查核！</small>');
                            $("#到職日期").addClass("is-invalid");
                            check_count[7] = 0;
                            return false;
                        }
                    } else {
                        if (!('0' <= start_char && start_char <= '9')) { //檢查是否為數字0-9
                            $("#start_work_remind").remove();
                            $("#care_id_8").append('<small class="form-text text-muted" style="color:red !important;" id="start_work_remind">到職日期格式不符(格式須為數字<ex:2000-07-28>),請查核！</small>');
                            $("#到職日期").addClass("is-invalid");
                            check_count[7] = 0;
                            return false;
                        }
                    }
                    if (check_month > '12') {
                        $("#start_work_remind").remove();
                        $("#care_id_8").append('<small class="form-text text-muted" style="color:red !important;" id="start_work_remind">到職日期月份格式不符,月份只能為01-12(格式須為數字<ex:2000-07-28>),請查核！</small>');
                        $("#到職日期").addClass("is-invalid");
                        check_count[7] = 0;
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
                            $("#care_id_8").append('<small class="form-text text-muted" style="color:red !important;" id="start_work_remind">到職日期月份格式不符,月份只能為01-12(格式須為數字<ex:2000-07-28>),請查核！</small>');
                            $("#到職日期").addClass("is-invalid");
                            check_count[7] = 0;
                            return false;

                        }
                        if (start_char == '0') { //月份不為00
                            if (start_char_1 == '0') {
                                $("#start_work_remind").remove();
                                $("#care_id_8").append('<small class="form-text text-muted" style="color:red !important;" id="start_work_remind">到職日期月份格式不符,月份不能為00,請查核！</small>');
                                $("#到職日期").addClass("is-invalid");
                                check_count[7] = 0;
                                return false;

                            }
                        }
                        if (check_days == '00') {
                            $("#start_work_remind").remove();
                            $("#care_id_8").append('<small class="form-text text-muted" style="color:red !important;" id="start_work_remind">到職日期月份格式不符,日子不能為00,請查核！</small>');
                            $("#到職日期").addClass("is-invalid");
                            check_count[7] = 0;
                            return false;
                        }
                        if (start_month == '01' || start_month == '03' || start_month == '05' || start_month == '07' || start_month == '08' || start_month == '10' || start_month == '12') //判斷大月31天
                        {
                            if (start_day > '31') {
                                $("#start_work_remind").remove();
                                $("#care_id_8").append('<small class="form-text text-muted" style="color:red !important;" id="start_work_remind">到職日期格式不符,所填月份與日期不相符(*您輸入的日期不能大於31*),請查核！</small>');
                                $("#到職日期").addClass("is-invalid");
                                check_count[7] = 0;
                                return false;
                            }
                        }
                        if (start_month == '04' || start_month == '06' || start_month == '09' || start_month == '11') //判斷小月30天
                        {
                            if (start_day > '30') {
                                $("#start_work_remind").remove();
                                $("#care_id_8").append('<small class="form-text text-muted" style="color:red !important;" id="start_work_remind">到職日期格式不符,所填月份與日期不相符(*您輸入的日期不能大於30*),請查核！</small>');
                                $("#到職日期").addClass("is-invalid");
                                check_count[7] = 0;
                                return false;
                            }

                        }
                        if (start_month == '02') {
                            if (start_day > '29') {
                                $("#start_work_remind").remove();
                                $("#care_id_8").append('<small class="form-text text-muted" style="color:red !important;" id="start_work_remind">到職日期格式不符,所填月份與日期不相符(*您輸入的日期不能大於29*),請查核！</small>');
                                $("#到職日期").addClass("is-invalid");
                                check_count[7] = 0;
                                return false;
                            }
                        }

                    }


                }
                if (parseInt(check_year, 10) < parseInt(check_year_1, 10) + 16) {
                    $("#start_work_remind").remove();
                    $("#care_id_8").append('<small class="form-text text-muted" style="color:red !important;" id="start_work_remind">到職日期欄位格式不符,請檢視照護人員的年齡是否年滿16歲,請查核！</small>');
                    $("#到職日期").addClass("is-invalid");
                    check_count[7] = 0;
                    return false;
                }






                $("#start_work_remind").remove();
                $("#到職日期").removeClass("is-invalid");
                $("#到職日期").addClass("is-valid");
                check_count[7] = 1;
                return (true);
            }

            function contract_expired() {
                var start_work = document.getElementById("到職日期").value;
                var contract_expired_code = document.getElementById("長照人力公司合約到期日").value;
                var check_month = contract_expired_code.substring(5, 7); //檢查月份
                var check_days = contract_expired_code.substring(8, 10);
                var check_date = contract_expired_code.substring(0, 10); //合約到期date
                var check_date_1 = start_work.substring(0, 10); //到職日期date
                var date = new Date();
                var date_year = date.getFullYear(); //獲取目前年份
                if (contract_expired_code == "") {
                    $("#contract_remind").remove();
                    $("#care_id_9").append('<small class="form-text text-muted" style="color:red !important;" id="contract_remind">長照人力公司合約到期日欄位不能為空,請查核！</small>'); //檢查格式是否為空值
                    $("#長照人力公司合約到期日").addClass("is-invalid");
                    check_count[8] = 0;
                    return false;
                }

                if (contract_expired_code.length != 10) {
                    $("#contract_remind").remove();
                    $("#care_id_9").append('<small class="form-text text-muted" style="color:red !important;" id="contract_remind">長照人力公司合約到期日欄位長度不符,請查核！</small>'); //檢查格式長度
                    $("#長照人力公司合約到期日").addClass("is-invalid");
                    check_count[8] = 0;
                    return false;
                }
                for (i = 0; i < contract_expired_code.length; i++) { //檢查'-'格式
                    var contract_expired_char = contract_expired_code.charAt(i);
                    if ((i == 4) || (i == 7)) {
                        if (contract_expired_char != "-") {
                            $("#contract_remind").remove();
                            $("#care_id_9").append('<small class="form-text text-muted" style="color:red !important;" id="contract_remind">長照人力公司合約到期日欄位格式不符(ex:2000-07-28),請查核！</small>'); //檢查格式'-'
                            $("#長照人力公司合約到期日").addClass("is-invalid");
                            check_count[8] = 0;
                            return false;
                        }
                    } else {
                        if (!('0' <= contract_expired_char && contract_expired_char <= '9')) { //檢查是否為數字0-9
                            $("#contract_remind").remove();
                            $("#care_id_9").append('<small class="form-text text-muted" style="color:red !important;" id="contract_remind">長照人力公司合約到期日欄位格式不符(格式須為數字<ex:2000-07-28>),請查核！</small>');
                            $("#長照人力公司合約到期日").addClass("is-invalid");
                            check_count[8] = 0;
                            return false;
                        }
                    }
                    if (check_month > '12') {
                        $("#contract_remind").remove();
                        $("#care_id_9").append('<small class="form-text text-muted" style="color:red !important;" id="contract_remind">長照人力公司合約到期日欄位月份格式不符,月份只能為01-12(格式須為數字<ex:2000-07-28>),請查核！</small>');
                        $("#長照人力公司合約到期日").addClass("is-invalid");
                        check_count[8] = 0;
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
                            $("#care_id_9").append('<small class="form-text text-muted" style="color:red !important;" id="contract_remind">長照人力公司合約到期日欄位月份格式不符,月份只能為01-12(格式須為數字<ex:2000-07-28>),請查核！</small>');
                            $("#長照人力公司合約到期日").addClass("is-invalid");
                            check_count[8] = 0;
                            return false;

                        }
                        if (contract_expired_char == '0') { //月份不為00
                            if (contract_expired_char_1 == '0') {
                                $("#contract_remind").remove();
                                $("#care_id_9").append('<small class="form-text text-muted" style="color:red !important;" id="contract_remind">長照人力公司合約到期日欄位格式不符,月份不能為00,請查核！</small>');
                                $("#長照人力公司合約到期日").addClass("is-invalid");
                                check_count[8] = 0;
                                return false;

                            }
                        }
                        if (check_days == '00') {
                            $("#contract_remind").remove();
                            $("#care_id_9").append('<small class="form-text text-muted" style="color:red !important;" id="contract_remind">長照人力公司合約到期日欄位格式不符,日子不能為00,請查核！</small>');
                            $("#長照人力公司合約到期日").addClass("is-invalid");
                            check_count[8] = 0;
                            return false;
                        }
                        if (contract_expired_month == '01' || contract_expired_month == '03' || contract_expired_month == '05' || contract_expired_month == '07' || contract_expired_month == '08' || contract_expired_month == '10' || contract_expired_month == '12') //判斷大月31天
                        {
                            if (contract_expired_day > '31') {
                                $("#contract_remind").remove();
                                $("#care_id_9").append('<small class="form-text text-muted" style="color:red !important;" id="contract_remind">長照人力公司合約到期日欄位,所填月份與日期不相符(*您輸入的日期不能大於31*),請查核！</small>');
                                $("#長照人力公司合約到期日").addClass("is-invalid");
                                check_count[8] = 0;
                                return false;
                            }
                        }
                        if (contract_expired_month == '04' || contract_expired_month == '06' || contract_expired_month == '09' || contract_expired_month == '11') //判斷小月30天
                        {
                            if (contract_expired_day > '30') {
                                $("#contract_remind").remove();
                                $("#care_id_9").append('<small class="form-text text-muted" style="color:red !important;" id="contract_remind">長照人力公司合約到期日欄位,所填月份與日期不相符(*您輸入的日期不能大於30*),請查核！</small>');
                                $("#長照人力公司合約到期日").addClass("is-invalid");
                                check_count[8] = 0;
                                return false;
                            }

                        }
                        if (contract_expired_month == '02') {
                            if (contract_expired_day > '29') {
                                $("#contract_remind").remove();
                                $("#care_id_9").append('<small class="form-text text-muted" style="color:red !important;" id="contract_remind">長照人力公司合約到期日欄位,所填月份與日期不相符(*您輸入的日期不能大於29*),請查核！</small>');
                                $("#長照人力公司合約到期日").addClass("is-invalid");
                                check_count[8] = 0;
                                return false;
                            }
                        }



                    }

                }
                if ((Date.parse(check_date)).valueOf() < (Date.parse(check_date_1).valueOf())) {
                    $("#contract_remind").remove();
                    $("#care_id_9").append('<small class="form-text text-muted" style="color:red !important;" id="contract_remind">長照人力公司合約到期日欄位格式不符,到職日期不能大於合約到職日期,請查核！</small>');
                    $("#長照人力公司合約到期日").addClass("is-invalid");
                    check_count[8] = 0;
                    return false;
                }



                $("#contract_remind").remove();
                $("#長照人力公司合約到期日").removeClass("is-invalid");
                $("#長照人力公司合約到期日").addClass("is-valid");
                check_count[8] = 1;
                return (true);
            }
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</body>

</html>