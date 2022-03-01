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
    /*-----------------------------------------------------------------------------------*/
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

<body onload="edit_success(),add_success()" id="body">

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
                    <a class="nav-link text-light" href="{{ url('/showcarestation') }}">派駐資料表</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="{{ url('/crossdatasearch') }}">跨資料整合</a>
                </li>
                @if($Authority == 'super user')
                    <li class="nav-item">
                        <a class="nav-link nav-item-active text-light" href="{{ url('/usersetting') }}">使用者設定</a>
                    </li>
                @endif
            </ul>
        </div>
        <div class="col-9">
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

                        $("#success").html("刪除成功");
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
            <!-- 創建卡片 -->
            <div class="container pt-3">
                <div class="card">
                    <div class="card-header navbar">
                        <div class="">
                            用戶資料
                            <button type="button" class="btn btn-success ml-3" data-toggle="modal" data-target="#add-user-modal">新增資料</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped rwd-table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">帳號</th>
                                    <th scope="col">密碼</th>
                                    <th scope="col">權限</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($datas as $data)
                                <tr>
                                    <th>{{ --$data_length}}</th>
                                    <td>{{ $data->username }}</td>
                                    <td>{{ $data->password }}</td>
                                    <td>{{ $data->Authority }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" onclick="delete_user('{{$data->username}}')"  data-target="#delete-user-modal">Delete</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    
    </div>

    <!-- Modal -->
    <div class="modal fade" id="add-user-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="background-color:rgba(0,0,0,0.4); overflow-y:scroll;">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="margin-top:20%;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
        
                        <div class="form-group">
                            <label for="exampleInputEmail1">帳號:</label>
                            <input type="text" class="form-control" id="username" name="username" aria-describedby="emailHelp" placeholder="Enter username">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">密碼:</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <label class="mr-sm-2" for="selection">使用者權限</label>
                            <select class="custom-select mr-sm-2 selection" id="selection">
                                <option value="super user">super user</option>
                                <option value="general user">general user</option>
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="add-user-btn">新增</button>
                </div>
            </div>
        </div>
    </div>

    <!-- 編輯modal id1 -->
     <!-- Modal -->
     <div class="modal fade" id="delete-user-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="background-color:rgba(0,0,0,0.4); overflow-y:scroll;">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="margin-top:20%;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h3>你確定要刪除嗎?</h3>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
                    <button type="button" class="btn btn-primary" id="delete-user-btn">確定</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        //新增資料ajax
        $("#add-user-btn").click(function(e) {
            e.preventDefault();
            let username = $("#username").val();
            let password = $("#password").val();
            let selection = $("#selection").val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{route('add-user')}}",
                type: "POST",
                data: {
                    username: username,
                    password: password,
                    selection: selection
                },
                success: function(response) {
                    console.log(response);
                    if (response == '用戶已存在!') {
                        $("#error").html("用戶已存在!");
                        var h = document.querySelector(".error"); //錯誤代碼
                        h.classList.add("active");
                        setTimeout(function() {
                            h.classList.remove('active');
                        }, 4000);
                        return false;
                    } else {
                        $("#add-user-modal").modal('hide');
                        document.cookie = "save_add=1;";
                        location.reload();
                    }


                }

            });
        });
        let initial_username;
        function delete_user(user_name){
            initial_username = user_name;
        }
        $("#delete-user-btn").click(function(e){
            e.preventDefault();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{route('delete-user')}}",
                type: "POST",
                data: {
                    initial_username: initial_username,
                },
                success: function(response) {
                    console.log(response);
                    $("#delete-user-modal").modal('hide');
                    document.cookie = "save_edit=1;";
                    location.reload();
                }

            });

        })
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</body>

</html>