<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <meta name="viewport" content="width=device-width, initial-scale=0.1">
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
    /*-------------------------------------------------*/
    
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
                    <a class="nav-link active text-light" href="{{ url('/showexecutive') }}">行政人員表</a>
                </li>
                <li class="nav-item nav-item-active">
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
                                <h3 class="text-left">各區受照護家庭數量:</h3>
                                <div class="text-left">北區: {{ $north }}</div>
                                <div class="text-left">中區: {{ $west }}</div>
                                <div class="text-left">南區: {{ $south }}</div>
                                <div class="text-left">東區: {{ $east }}</div>
                            </div>
                            <div class="col-md-4">
                                <h3 class="text-left">各區受照護男女人數:</h3>
                                <div class="text-left">北區: {{ $north_male }}男 {{ $north_female }}女</div>
                                <div class="text-left">中區: {{ $west_male }}男 {{ $west_female }}女</div>
                                <div class="text-left">南區: {{ $south_male }}男 {{ $south_female }}女</div>
                                <div class="text-left">東區: {{ $east_male }}男 {{ $east_female }}女</div>
                            </div>
                            <div class="col-md-4" id="show_upper_65" style="height:245px;">
                                <h3 class="text-left">查詢65歲以上受照護人員之平均年齡:</h3>
                                <form class="text-left row" id="area_form">
                                    @csrf
                                    <div class="col-md-6">
                                        <span>北區</span>
                                        <input type="radio" name="area" value="北" class="area"><br>
                                        <span>中區</span>
                                        <input type="radio" name="area" value="中" class="area"><br>
                                        <span>南區</span>
                                        <input type="radio" name="area" value="南" class="area"><br>
                                        <span>東區</span>
                                        <input type="radio" name="area" value="東" class="area"><br>
                                        <span>全台灣</span>
                                        <input type="radio" name="area" value="台灣" checked class="area">
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-primary" style="margin-top: 20% !important;" id="search">搜尋</button>
                                    </div>
                                </form>

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
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#add-cared-modal">新增資料</button>
                        </div>
                        <!-- 創建搜尋紐 -->
                        <form class="form-inline ">
                            <input class="form-control mr-sm-2" type="text" placeholder="家庭代碼" aria-label="Search" id="search-family-code" name="家庭代碼" value="{{old('家庭代碼')}}">
                            <input class="form-control mr-sm-2" type="text" placeholder="受照護者姓名" aria-label="Search" id="search-cared-name">
                            <button class="btn btn-outline-success my-2 my-sm-0" type="button" id="search-submit" data-toggle="modal">Search</button>
                        </form>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">家庭代碼</th>
                                    <th scope="col">受照護者姓名</th>
                                    <th scope="col">受照護者姓別</th>
                                    <th scope="col">受照護者生日</th>
                                    <th scope="col">資料狀態</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody id="tbody">
                                @foreach($datas as $data)

                                <tr>
                                    <th scope="row">{{ --$data_length}}</th>
                                    <td>{{ $data->家庭代碼 }}</td>
                                    <td>{{ $data->受照護者姓名 }}</td>
                                    <td>{{ $data->受照護者性別 }}</td>
                                    <td>{{ $data->受照護者生日 }}</td>
                                    <td>{{ $data->資料狀態 }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary" onclick="show_cared_family('{{$data->家庭代碼}}','{{$data->受照護者姓名}}')" data-toggle="modal" data-target="#info-cared-modal">Info</button>
                                        <button type="button" class="btn btn-primary" onclick="show_edit_cared_family('{{$data->家庭代碼}}','{{$data->受照護者姓名}}')" data-toggle="modal" data-target="#edit-cared-modal">Edit</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- 創建Modal id 0-->
            <div class="modal fade" id="add-cared-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                    <label for="exampleInputEmail1">家庭代碼</label>
                                    <input type="text" class="form-control" id="家庭代碼" aria-describedby="emailHelp" placeholder="ex.北0000001" name="家庭代碼" required="required">
                                </div>
                                <div class="form-group" id="form-group2">
                                    <label for="exampleInputPassword1">受照護者姓名</label>
                                    <input type="input" class="form-control" id="受照護者姓名" placeholder="ex.王大明" name="受照護者姓名" required>
                                </div>
                                <div class="form-group" id="form-group3">
                                    <label for="exampleInputPassword1">受照護者性別</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input sex" type="radio" id="受照護者性別" value="男性" name="sex" required>
                                        <label class="form-check-label" for="inlineCheckbox1">男姓</label>
                                        <input class="form-check-input ml-2 sex" type="radio" id="受照護者性別" value="女性" name="sex" required>
                                        <label class="form-check-label" for="inlineCheckbox1">女姓</label>
                                    </div>
                                </div>
                                <div class="form-group" id="form-group4">
                                    <label for="exampleInputPassword1">受照護者生日</label>
                                    <input type="input" class="form-control" id="受照護者生日" placeholder="ex.2000-07-28" name="受照護者生日" required>
                                </div>
                                <div class="form-group" id="form-group5">
                                    <label for="exampleInputPassword1">受照護者家庭住址</label>
                                    <input type="input" class="form-control" id="受照護者家庭住址" placeholder="ex.台中市西屯區台灣大道四段1727號" name="受照護者家庭住址" required>
                                </div>
                                <div class="mb-3" id="form-group6">
                                    <label for="validationTextarea">受照護者身體狀態</label>
                                    <textarea class="form-control" id="受照護者身體狀態" placeholder="請輸入受照護者身體狀態" name="受照護者身體狀態" required></textarea>
                                </div>
                                <div class="form-group" id="form-group7">
                                    <label for="exampleInputPassword1">受照護者障礙別</label>
                                    <input type="input" class="form-control" id="受照護者障礙別" placeholder="ex.輕度障礙or重度障礙..." name="受照護者障礙別" required>
                                </div>
                                <div class="form-group" id="form-group8">
                                    <label for="exampleInputPassword1">聯絡人姓名</label>
                                    <input type="input" class="form-control" id="聯絡人姓名" placeholder="ex.王曉明" name="聯絡人姓名" required>
                                </div>
                                <div class="form-group" id="form-group9">
                                    <label for="exampleInputPassword1">聯絡人電話</label>
                                    <input type="input" class="form-control" id="聯絡人電話" placeholder="ex.+8860912256431" name="聯絡人電話" required>
                                </div>
                                <div class="form-group" id="form-group10">
                                    <label for="exampleInputPassword1">Line Id</label>
                                    <input type="input" class="form-control" id="LineId" placeholder="ex.請輸入Line Id" name="lineid" required>
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
            <div class="modal fade" id="info-cared-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">詳細資料</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                        </div>
                        <div class="modal-body" id="info-body-wrapper">
                            <div class="form-group">
                                <label for="exampleInputEmail1">家庭代碼</label>
                                <input type="text" class="form-control" id="家庭代碼1" aria-describedby="emailHelp" placeholder="ex.北0000001" name="家庭代碼" required="required">
                                <small id="emailHelp" class="form-text text-muted">前1碼為區域，後7碼為代碼</small>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">受照護者姓名</label>
                                <input type="text" class="form-control" id="受照護者姓名1" placeholder="ex.王大明" name="受照護者姓名" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">受照護者性別</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input sex1" type="radio" id="受照護者性別" value="男性" name="sex" required>
                                    <label class="form-check-label" for="inlineCheckbox1">男姓</label>
                                    <input class="form-check-input ml-2 sex1" type="radio" id="受照護者性別" value="女性" name="sex" required>
                                    <label class="form-check-label" for="inlineCheckbox1">女姓</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">受照護者生日</label>
                                <input type="text" class="form-control" id="受照護者生日1" placeholder="ex.2000-07-28" name="受照護者生日" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">受照護者家庭住址</label>
                                <input type="text" class="form-control" id="受照護者家庭住址1" placeholder="ex.台中市西屯區台灣大道四段1727號" name="受照護者家庭住址" required>
                            </div>
                            <div class="mb-3">
                                <label for="validationTextarea">受照護者身體狀態</label>
                                <textarea class="form-control" id="受照護者身體狀態1" placeholder="請輸入受照護者身體狀態" name="受照護者身體狀態" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">受照護者障礙別</label>
                                <input type="text" class="form-control" id="受照護者障礙別1" placeholder="ex.輕度障礙or重度障礙..." name="受照護者障礙別" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">聯絡人姓名</label>
                                <input type="text" class="form-control" id="聯絡人姓名1" placeholder="ex.王曉明" name="聯絡人姓名" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">聯絡人電話</label>
                                <input type="text" class="form-control" id="聯絡人電話1" placeholder="ex.+8860912256431" name="聯絡人電話" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Line Id</label>
                                <input type="text" class="form-control" id="Lineid1" placeholder="ex.請輸入Line Id" name="lineid" required>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- 創建edit-modal id3-->
            <div class="modal fade" id="edit-cared-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content" id="edit-modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">詳細資料</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                        </div>
                        <div class="modal-body" id="info-body-wrapper">
                            <div class="form-group">
                                <label for="exampleInputEmail1">家庭代碼</label>
                                <input type="text" class="form-control" id="家庭代碼3" aria-describedby="emailHelp" placeholder="ex.北0000001" name="家庭代碼" required="required">
                                <small id="emailHelp" class="form-text text-muted">前1碼為區域，後7碼為代碼</small>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">受照護者姓名</label>
                                <input type="text" class="form-control" id="受照護者姓名3" placeholder="ex.王大明" name="受照護者姓名" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">受照護者性別</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input sex3" type="radio" id="受照護者性別" value="男性" name="sex" required>
                                    <label class="form-check-label" for="inlineCheckbox1">男姓</label>
                                    <input class="form-check-input ml-2 sex3" type="radio" id="受照護者性別" value="女性" name="sex" required>
                                    <label class="form-check-label" for="inlineCheckbox1">女姓</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">受照護者生日</label>
                                <input type="text" class="form-control" id="受照護者生日3" placeholder="ex.2000-07-28" name="受照護者生日" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">受照護者家庭住址</label>
                                <input type="text" class="form-control" id="受照護者家庭住址3" placeholder="ex.台中市西屯區台灣大道四段1727號" name="受照護者家庭住址" required>
                            </div>
                            <div class="mb-3">
                                <label for="validationTextarea">受照護者身體狀態</label>
                                <textarea class="form-control" id="受照護者身體狀態3" placeholder="請輸入受照護者身體狀態" name="受照護者身體狀態" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">受照護者障礙別</label>
                                <input type="text" class="form-control" id="受照護者障礙別3" placeholder="ex.輕度障礙or重度障礙..." name="受照護者障礙別" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">聯絡人姓名</label>
                                <input type="text" class="form-control" id="聯絡人姓名3" placeholder="ex.王曉明" name="聯絡人姓名" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">聯絡人電話</label>
                                <input type="text" class="form-control" id="聯絡人電話3" placeholder="ex.+8860912256431" name="聯絡人電話" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Line Id</label>
                                <input type="text" class="form-control" id="Lineid3" placeholder="ex.請輸入Line Id" name="lineid" required>
                            </div>
                            <div class="form-group">
                                <label class="mr-sm-2" for="selection3">Preference</label>
                                <select class="custom-select mr-sm-2 selection3" id="selection3">
                              <option value="正常" >正常</option>
                              <option value="刪除">刪除</option>
                            </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" id="save-edit">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- 創建search-modal id2 -->
            <div class="modal fade" id="search-cared-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content" id="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">詳細資料</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                        </div>
                        <div class="modal-body" id="info-body-wrapper">
                            <div class="form-group">
                                <label for="exampleInputEmail1">家庭代碼</label>
                                <input type="text" class="form-control" id="家庭代碼2" aria-describedby="emailHelp" placeholder="ex.北0000001" name="家庭代碼" required="required">
                                <small id="emailHelp" class="form-text text-muted">前1碼為區域，後7碼為代碼</small>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">受照護者姓名</label>
                                <input type="text" class="form-control" id="受照護者姓名2" placeholder="ex.王大明" name="受照護者姓名" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">受照護者性別</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input sex2" type="radio" id="受照護者性別" value="男性" name="sex" required>
                                    <label class="form-check-label" for="inlineCheckbox1">男姓</label>
                                    <input class="form-check-input ml-2 sex2" type="radio" id="受照護者性別" value="女性" name="sex" required>
                                    <label class="form-check-label" for="inlineCheckbox1">女姓</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">受照護者生日</label>
                                <input type="text" class="form-control" id="受照護者生日2" placeholder="ex.2000-07-28" name="受照護者生日" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">受照護者家庭住址</label>
                                <input type="text" class="form-control" id="受照護者家庭住址2" placeholder="ex.台中市西屯區台灣大道四段1727號" name="受照護者家庭住址" required>
                            </div>
                            <div class="mb-3">
                                <label for="validationTextarea">受照護者身體狀態</label>
                                <textarea class="form-control" id="受照護者身體狀態2" placeholder="請輸入受照護者身體狀態" name="受照護者身體狀態" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">受照護者障礙別</label>
                                <input type="text" class="form-control" id="受照護者障礙別2" placeholder="ex.輕度障礙or重度障礙..." name="受照護者障礙別" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">聯絡人姓名</label>
                                <input type="text" class="form-control" id="聯絡人姓名2" placeholder="ex.王曉明" name="聯絡人姓名" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">聯絡人電話</label>
                                <input type="text" class="form-control" id="聯絡人電話2" placeholder="ex.+8860912256431" name="聯絡人電話" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Line Id</label>
                                <input type="text" class="form-control" id="Lineid2" placeholder="ex.請輸入Line Id" name="lineid" required>
                            </div>
                            <div class="form-group">
                                <label class="mr-sm-2" for="selection2">Preference</label>
                                <select class="custom-select mr-sm-2 selection2" id="selection2">
                              <option value="正常" >正常</option>
                              <option value="刪除">刪除</option>
                            </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" id="save-search">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-2"></div>
        </div>
    </div>
    <script type="text/javascript">
        //搜尋>65歲ajax
        $("#search").click(function(e) {
            e.preventDefault();

            let area = $(".area:checked").val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('post-areasearch')}}",
                type: "POST",
                data: {
                    area: area
                },
                success: function(response) {
                    if (response != '錯誤') {
                        if (response.area == '台灣') {
                            $('#answer').remove();
                            $("#show_upper_65").append('<h3 id="answer" class="text-left pt-2">全台平均年齡:' + response[0].average_age + '歲</h3>');
                        } else {
                            $('#answer').remove();
                            $("#show_upper_65").append('<h3 id="answer" class="text-left pt-2">' + response[0].area + '區平均年齡:' + response[0].average_age + '歲</h3>');
                        }
                    } else {
                        $('#answer').remove();
                        $("#show_upper_65").append('<h3 id="answer" class="text-left pt-2">該區無大於65歲人口</h3>');
                    }
                    console.log(response);
                }
            });
        });
    </script>
    <script type="text/javascript">
        //新增資料ajax
        var check_count = new Array(10);
        $("#form-submit").click(function(e) {
            for(i =0;i<10;i++){
                check_count[i] = 0;
            }
            checkfamily_code();
            takecare_name();
            if(check_count[0]==1 && check_count[1]==1){
                let family_code = $("#家庭代碼").val();
                let cared_name = $("#受照護者姓名").val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{route('add-caredfamily')}}",
                    type: "POST",
                    data: {
                        family_code: family_code,
                        cared_name: cared_name,
                    },
                    success: function(response) {
                        if (response == '該家庭代碼與受照護者已存在，請使用編輯模式!') {
                            $("#error").html("該家庭代碼與受照護者已存在，請使用編輯模式!");
                            var h = document.querySelector(".error"); //錯誤代碼
                            h.classList.add("active");
                            setTimeout(function() {
                                h.classList.remove('active');
                            }, 4000);
                        }
                    }

                });
            }
            gender();
            brithday();
            address();
            condition();
            category();
            contact_name();
            contact_phone();
            line_check();
            console.log(check_count);
            e.preventDefault();
            if(!check_count.includes(0)){
                let family_code = $("#家庭代碼").val();
                let cared_name = $("#受照護者姓名").val();
                let sex = $(".sex:checked").val();
                let cared_birth = $("#受照護者生日").val();
                let cared_address = $("#受照護者家庭住址").val();
                let cared_healthy = $('#受照護者身體狀態').val();
                let cared_barrier = $("#受照護者障礙別").val();
                let contact_name = $("#聯絡人姓名").val();
                let contact_phone = $("#聯絡人電話").val();
                let line_id = $("#LineId").val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{route('add-caredfamily')}}",
                    type: "POST",
                    data: {
                        family_code: family_code,
                        cared_name: cared_name,
                        sex: sex,
                        cared_birth: cared_birth,
                        cared_address: cared_address,
                        cared_healthy: cared_healthy,
                        cared_barrier: cared_barrier,
                        contact_name: contact_name,
                        contact_phone: contact_phone,
                        line_id: line_id
                    },
                    success: function(response) {
                        if (response == '該家庭代碼與受照護者已存在，請使用編輯模式!') {
                            $("#error").html("該家庭代碼與受照護者已存在，請使用編輯模式!");
                            var h = document.querySelector(".error"); //錯誤代碼
                            h.classList.add("active");
                            setTimeout(function() {
                                h.classList.remove('active');
                            }, 4000);
                        } else {
                            $("#cared-form")[0].reset();
                            $("#add-cared-modal").modal('hide');
                            document.cookie = "save_add=1;";
                            location.reload();
                        }

                        console.log(response);
                    }

                });
            }
        });
    </script>
    <script type="text/javascript">
        //搜尋指定目標ajax
        $("#search-submit").click(function(e) {
            e.preventDefault();
            if ($("#search-family-code").val() == "" || $("#search-cared-name").val() == "") { //如果家庭代碼，受照護者姓名為空 按鈕不觸發
                $("#error").html("兩項資料都不能為空哦~~");
                var h = document.querySelector(".error"); //錯誤代碼
                h.classList.add("active");
                setTimeout(function() {
                    h.classList.remove('active');
                }, 4000);
                return false;
            }
            let search_family_code = $("#search-family-code").val();
            let search_cared_name = $("#search-cared-name").val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('search_caredfamily')}}",
                type: "POST",
                data: {
                    search_family_code: search_family_code,
                    search_cared_name: search_cared_name,
                },
                success: function(response) {
                    $(".sex2").attr('checked', false);
                    if (response[0].length > 0) {
                        $('#search-cared-modal').modal('show');
                        $("#家庭代碼2").val(response[0][0]['家庭代碼']);
                        $("#受照護者姓名2").val(response[0][0]['受照護者姓名']);
                        // $(".sex").val();
                        if (response[0][0]['受照護者性別'] == '女性') {
                            $(".sex2[value='女性']").attr('checked', true);
                        } else {
                            $(".sex2[value='男性']").attr('checked', true);
                        }
                        $("#受照護者生日2").val(response[0][0]['受照護者生日']);
                        $("#受照護者家庭住址2").val(response[0][0]['受照護者家庭住址']);
                        $('#受照護者身體狀態2').val(response[0][0]['受照護者身體狀態']);
                        $("#受照護者障礙別2").val(response[0][0]['障礙別']);
                        $("#聯絡人姓名2").val(response[0][0]['聯絡人姓名']);
                        $("#聯絡人電話2").val(response[0][0]['連絡電話']);
                        $('#Lineid2').val(response[0][0]['Line ID']);
                        $('#selection2').val(response[0][0]['資料狀態']);
                        initial_family_code = response[0][0]['家庭代碼'];
                        initial_cared_name = response[0][0]['受照護者姓名'];
                        console.log(response[0]);
                    } else {
                        $("#error").html("伺服器查無該筆資訊!");
                        var h = document.querySelector(".error"); //錯誤代碼
                        h.classList.add("active");
                        setTimeout(function() {
                            h.classList.remove('active');
                        }, 4000);
                        //$("#search-cared-modal").modal('hide');
                        //return false; 
                    }
                }
            });
        });
    </script>
    <script type="text/javascript">
        //save搜尋表單
        $("#save-search").click(function(e) {
            e.preventDefault();
            let family_code = $("#家庭代碼2").val();
            let cared_name = $("#受照護者姓名2").val();
            let sex = $(".sex2:checked").val();
            let cared_birth = $("#受照護者生日2").val();
            let cared_address = $("#受照護者家庭住址2").val();
            let cared_healthy = $("#受照護者身體狀態2").val();
            let cared_barrier = $("#受照護者障礙別2").val();
            let contact_name = $("#聯絡人姓名2").val();
            let contact_phone = $("#聯絡人電話2").val();
            let line_id = $("#Lineid2").val();
            let select = $('#selection2').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{route('save-search-caredfamily')}}",
                type: "POST",
                data: {
                    initial_family_code: initial_family_code,
                    initial_cared_name: initial_cared_name,
                    family_code: family_code,
                    cared_name: cared_name,
                    sex: sex,
                    cared_birth: cared_birth,
                    cared_address: cared_address,
                    cared_healthy: cared_healthy,
                    cared_barrier: cared_barrier,
                    contact_name: contact_name,
                    contact_phone: contact_phone,
                    line_id: line_id,
                    select: select
                },
                success: function(response) {
                    if (response) {
                        $("#cared-form")[0].reset();
                        $("#add-cared-modal").modal('hide');
                        document.cookie = "save_edit=1;";
                        location.reload();
                    }

                    console.log(response);
                }

            });
        });
    </script>
    <script>
        //show詳細資料
        function show_cared_family(family_code, cared_name) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('info-caredfamily')}}",
                type: "POST",
                data: {
                    family_code: family_code,
                    cared_name: cared_name,
                },
                success: function(response) {
                    if (response) {
                        $(".sex1").attr('checked', false); //清空sex值
                        $("#家庭代碼1").val(response[0][0]['家庭代碼']);
                        $("#受照護者姓名1").val(response[0][0]['受照護者姓名']);
                        // $(".sex").val();
                        if (response[0][0]['受照護者性別'] == '女性') {
                            $(".sex1[value='女性']").attr('checked', true);
                        } else {
                            $(".sex1[value='男性']").attr('checked', true);
                        }
                        $("#受照護者生日1").val(response[0][0]['受照護者生日']);
                        $("#受照護者家庭住址1").val(response[0][0]['受照護者家庭住址']);
                        $('#受照護者身體狀態1').val(response[0][0]['受照護者身體狀態']);
                        $("#受照護者障礙別1").val(response[0][0]['障礙別']);
                        $("#聯絡人姓名1").val(response[0][0]['聯絡人姓名']);
                        $("#聯絡人電話1").val(response[0][0]['連絡電話']);
                        $('#Lineid1').val(response[0][0]['Line ID']);
                    }
                    console.log(response);
                }

            });
        }
    </script>
    <script>
        let initial_family_code;
        let initial_cared_name;
        //show_Edit資料
        function show_edit_cared_family(family_code, cared_name) {
            $('#edit-cared-modal').on('hidden.bs.modal', function() {
                $(this).find('form').trigger('reset');
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('show-edit-caredfamily')}}",
                type: "POST",
                data: {
                    family_code: family_code,
                    cared_name: cared_name,
                },
                success: function(response) {
                    if (response) {
                        $(".sex3").attr('checked', false); //清空sex值
                        $("#家庭代碼3").val(response[0][0]['家庭代碼']);
                        $("#受照護者姓名3").val(response[0][0]['受照護者姓名']);
                        // $(".sex").val();
                        if (response[0][0]['受照護者性別'] == '女性') {
                            $(".sex3[value='女性']").attr('checked', true);
                        } else {
                            $(".sex3[value='男性']").attr('checked', true);
                        }
                        $("#受照護者生日3").val(response[0][0]['受照護者生日']);
                        $("#受照護者家庭住址3").val(response[0][0]['受照護者家庭住址']);
                        $('#受照護者身體狀態3').val(response[0][0]['受照護者身體狀態']);
                        $("#受照護者障礙別3").val(response[0][0]['障礙別']);
                        $("#聯絡人姓名3").val(response[0][0]['聯絡人姓名']);
                        $("#聯絡人電話3").val(response[0][0]['連絡電話']);
                        $('#Lineid3').val(response[0][0]['Line ID']);
                        $("#selection3").val(response[0][0]['資料狀態']);
                        initial_family_code = response[0][0]['家庭代碼'];
                        initial_cared_name = response[0][0]['受照護者姓名'];

                    }
                    console.log(response);
                }

            });
        }

        //save edit表單
        $("#save-edit").click(function(e) {
            e.preventDefault();
            let family_code = $("#家庭代碼3").val();
            let cared_name = $("#受照護者姓名3").val();
            let sex = $(".sex3:checked").val();
            let cared_birth = $("#受照護者生日3").val();
            let cared_address = $("#受照護者家庭住址3").val();
            let cared_healthy = $("#受照護者身體狀態3").val();
            let cared_barrier = $("#受照護者障礙別3").val();
            let contact_name = $("#聯絡人姓名3").val();
            let contact_phone = $("#聯絡人電話3").val();
            let line_id = $("#Lineid3").val();
            let select = $("#selection3").val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{route('save-edit-caredfamily')}}",
                type: "POST",
                data: {
                    initial_family_code: initial_family_code,
                    initial_cared_name: initial_cared_name,
                    family_code: family_code,
                    cared_name: cared_name,
                    sex: sex,
                    cared_birth: cared_birth,
                    cared_address: cared_address,
                    cared_healthy: cared_healthy,
                    cared_barrier: cared_barrier,
                    contact_name: contact_name,
                    contact_phone: contact_phone,
                    line_id: line_id,
                    select: select
                },
                success: function(response) {
                    if (response) {
                        $("#cared-form")[0].reset();
                        $("#edit-cared-modal").modal('hide');
                        document.cookie = "save_edit=1;";
                        location.reload();

                    }

                    console.log(response);
                }

            });
        });
    </script>

{{-- 宗勳code 前台表單驗證 --}}
    <script>
     function checkfamily_code() {       //家庭代碼檢測
        var family_code=document.getElementById("家庭代碼").value;
        if (family_code == "") {
            $("#family-code-remind").remove();
            $("#form-group1").append('<small class="form-text text-muted" style="color:red !important;" id="family-code-remind">家庭代碼不能為空,請查核！</small>');//檢查格式是否為空值
            $("#家庭代碼").addClass("is-invalid");
            check_count[0] = 0;
            return false;
        }
        if (family_code.length!=8){
			$("#family-code-remind").remove();
            $("#form-group1").append('<small class="form-text text-muted" style="color:red !important;" id="family-code-remind">家庭代碼長度不符,請查核！</small>');//檢查格式是否為空值"")
            $("#家庭代碼").addClass("is-invalid");
            check_count[0] = 0;
            return false;
        }
        for (i=0; i<8; i++){
        var  character=family_code.charAt(i);
            if (i==0){	// 檢查第一碼是否是 "北,中,南,東"
                if (character!="北"&&character!="中"&&character!="南"&&character!="東"){
                    $("#family-code-remind").remove();
                    $("#form-group1").append('<small class="form-text text-muted" style="color:red !important;" id="family-code-remind">家庭代碼輸入有誤（第一碼請為北,中,南,東）,請查核!</small>');
                    $("#家庭代碼").addClass("is-invalid");
                    check_count[0] = 0;
                    return false;
                }
            }   
            if(1<=i && i<=8){
                if(!('0'<=character && character<='9')){//用ASCII檢查後七碼是否為0~9
                    $("#family-code-remind").remove();
                    $("#form-group1").append('<small class="form-text text-muted" style="color:red !important;" id="family-code-remind">家庭代碼輸入後七碼須為數字,請查核!</small>');
                    $("#家庭代碼").addClass("is-invalid");
                    check_count[0] = 0;
                    return false;
                }
            }
        }
        $("#family-code-remind").remove();
        $("#家庭代碼").removeClass("is-invalid");
        $("#家庭代碼").addClass("is-valid");
        check_count[0] = 1;
        return (true);
    }
     function takecare_name(){    //受照護者姓名檢測
        var takecare_code = document.getElementById("受照護者姓名").value;
        if(takecare_code == "") {//檢查格式是否為空值
            $("#takecare-name-remind").remove();
            $("#form-group2").append('<small class="form-text text-muted" style="color:red !important;" id="takecare-name-remind">受照護者姓名不能為空,請查核！</small>');
            $("#受照護者姓名").addClass("is-invalid");
            check_count[1] = 0;
            return false;
        }
        if(takecare_code.length>19){
            $("#takecare-name-remind").remove();
            $("#form-group2").append('<small class="form-text text-muted" style="color:red !important;" id="takecare-name-remind">受照護者姓名需小於20字,請查核！</small>');
            $("#受照護者姓名").addClass("is-invalid");
            check_count[1] = 0;
            return false;
        }
        $("#takecare-name-remind").remove();
        $("#受照護者姓名").removeClass("is-invalid");
        $("#受照護者姓名").addClass("is-valid");
        check_count[1] = 1;
        return (true);
     }
       function gender(){//受照護者性別檢測
        let sex = $(".sex:checked").val();
        if(sex==null){//檢測是否為空
            $("#takecare-gender-remind").remove();
            $("#form-group3").append('<small class="form-text text-muted" style="color:red !important;" id="takecare-gender-remind">請選取受照護者性別！</small>');
            $("#受照護者性別").addClass("is-invalid");
            check_count[2] = 0;
            return false;
        }    
            $("#takecare-gender-remind").remove();
            $("#受照護者性別").removeClass("is-invalid");
            $("#受照護者性別").addClass("is-valid");
            check_count[2] = 1; 
            return(true);
        }
        function brithday(){
           var cared_birth = document.getElementById("受照護者生日").value;
           var cared_month = cared_birth.substring(5,7);
           var cared_days = cared_birth.substring(8,10);
           if(cared_birth==""){
                $("#takecare-bri-remind").remove();
                $("#form-group4").append('<small class="form-text text-muted" style="color:red !important;" id="takecare-bri-remind">受照護者生日不能為空,請查核！</small>');//檢查格式是否為空值
                $("#受照護者生日").addClass("is-invalid");
                check_count[3] = 0;
                return false;
           }
            
            if (cared_birth.length!=10){
                $("#takecare-bri-remind").remove();
                $("#form-group4").append('<small class="form-text text-muted" style="color:red !important;" id="takecare-bri-remind">受照護者生日長度不符,請查核！</small>');//檢查格式是否為長度符合
                $("#受照護者生日").addClass("is-invalid");
                check_count[3] = 0;
                return false;
            }
           for(i=0;i<cared_birth.length;i++){
               var bri_char = cared_birth.charAt(i);
               if((i==4)||(i==7)){
                 if(bri_char!="-"){
                    $("#takecare-bri-remind").remove();
                    $("#form-group4").append('<small class="form-text text-muted" style="color:red !important;" id="takecare-bri-remind">受照護者生日格式不符(ex:2000-07-28),請查核！</small>');//檢查格式是否為空值
                    $("#受照護者生日").addClass("is-invalid");
                    check_count[3] = 0;
                        return false;
                         }
               }
               else{
                    if(!('0'<=bri_char && bri_char<='9')){
                        $("#takecare-bri-remind").remove();
                        $("#form-group4").append('<small class="form-text text-muted" style="color:red !important;" id="takecare-bri-remind">受照護者生日格式不符(格式須為數字<ex:2000-07-28>),請查核！</small>');//檢查格式是否為空值
                        $("#受照護者生日").addClass("is-invalid");
                        check_count[3] = 0;
                        return false;   
                  }
             }
             if(cared_month>'12'){
                 $("#takecare-bri-remind").remove();
                 $("#form-group4").append('<small class="form-text text-muted" style="color:red !important;" id="takecare-bri-remind">受照護者生日月份格式不符,月份只能為01-12(格式須為數字<ex:2000-07-28>),請查核！</small>');
                 $("#受照護者生日").addClass("is-invalid");
                 check_count[3] = 0;
                 return false;   
             }  
             if(i==5){
                   x=i+1;
                   y=i+3;
                   z=i+4;
                   var bri_char_1 = cared_birth.charAt(x);//存取i=6時的字元
                   var cared_birth_month =  bri_char + bri_char_1;//獲取月份
                   var cared_birth_char_8 = cared_birth.charAt(y);//存取i=8時的字元
                   var cared_birth_char_9 = cared_birth.charAt(z);//存取i=9時的字元
                   var cared_birth_day = cared_birth_char_8 + cared_birth_char_9;//獲取日子 
                   if(bri_char!='0'&& bri_char!='1'){//月份第一個字只能為1,2
                             $("#takecare-bri-remind").remove();
                             $("#form-group4").append('<small class="form-text text-muted" style="color:red !important;" id="takecare-bri-remind">受照護者生日月份格式不符,月份只能為01-12(格式須為數字<ex:2000-07-28>),請查核！</small>');
                             $("#受照護者生日").addClass("is-invalid");
                             check_count[3] = 0;
                             return false;   

                 }
                  if(bri_char =='0'){//月份不為00
                      if(bri_char_1 == '0'){
                             $("#takecare-bri-remind").remove();
                             $("#form-group4").append('<small class="form-text text-muted" style="color:red !important;" id="takecare-bri-remind">受照護者生日月份格式不符,月份不能為00,請查核！</small>');
                             $("#受照護者生日").addClass("is-invalid");
                             check_count[3] = 0;
                             return false;   
                          
                        }  
                  }
                  if(cared_days == '00'){
                             $("#takecare-bri-remind").remove();
                             $("#form-group4").append('<small class="form-text text-muted" style="color:red !important;" id="takecare-bri-remind">受照護者生日月份格式不符,日子不能為00,請查核！</small>');
                             $("#受照護者生日").addClass("is-invalid");
                             check_count[3] = 0;
                             return false;
                  }
                 if(cared_birth_month == '01'||cared_birth_month =='03'||cared_birth_month=='05'||cared_birth_month=='07'||cared_birth_month=='08'||cared_birth_month=='10'||cared_birth_month=='12')//判斷大月31天
                    {
                     if(cared_birth_day>'31'){
                             $("#takecare-bri-remind").remove();
                             $("#form-group4").append('<small class="form-text text-muted" style="color:red !important;" id="takecare-bri-remind">受照護者生日格式不符,所填月份與日期不相符(*您輸入的日期不能大於31*),請查核！</small>');
                             $("#受照護者生日").addClass("is-invalid"); 
                             check_count[3] = 0;
                             return false;   
                     }  
                 }
                 if(cared_birth_month =='04'||cared_birth_month=='06'||cared_birth_month =='09'||cared_birth_month=='11')//判斷小月30天
                    {
                     if(cared_birth_day>'30'){
                             $("#takecare-bri-remind").remove();
                             $("#form-group4").append('<small class="form-text text-muted" style="color:red !important;" id="takecare-bri-remind">受照護者生日格式不符,所填月份與日期不相符(*您輸入的日期不能大於30*),請查核！</small>');
                             $("#受照護者生日").addClass("is-invalid");
                             check_count[3] = 0;
                             return false;   
                     }  
                     
                 } 
                 if(cared_birth_month =='02'){
                       if(cared_birth_day>'29'){
                              $("takecare-bri-remind").remove();
                              $("#form-group4").append('<small class="form-text text-muted" style="color:red !important;" id="takecare-bri-remind">受照護者生日格式不符,所填月份與日期不相符(*您輸入的日期不能大於29*),請查核！</small>');
                              $("#受照護者生日").addClass("is-invalid");
                              check_count[3] = 0;
                              return false; 
                              }
                   } 
                
             }  
               
               
               
   }
            
        $("#takecare-bri-remind").remove();
        $("#受照護者生日").removeClass("is-invalid");
        $("#受照護者生日").addClass("is-valid");
        check_count[3] = 1;
        return (true);     
}
        function address(){
            var addr=document.getElementById("受照護者家庭住址").value;
            if(addr==""){
                $("#takecare-addr-remind").remove();
                $("#form-group5").append('<small class="form-text text-muted" style="color:red !important;" id="takecare-addr-remind">受照護者家庭住址不能為空,請查核！</small>');//檢查格式是否為空值
                $("#受照護者家庭住址").addClass("is-invalid");
                check_count[4] = 0;
                return false;
            }
            if(addr.length>40){
                $("#takecare-addr-remind").remove();
                $("#form-group5").append('<small class="form-text text-muted" style="color:red !important;" id="takecare-addr-remind">受照護者家庭住址不能大於40字,請查核！</small>');//檢查格式是否為空值
                $("#受照護者家庭住址").addClass("is-invalid");
                check_count[4] = 0;
                return false;   
            }
        $("#takecare-addr-remind").remove();
        $("#受照護者家庭住址").removeClass("is-invalid");
        $("#受照護者家庭住址").addClass("is-valid");
        check_count[4] = 1;
        return (true);     
        }
        function condition(){
            var cont=document.getElementById("受照護者身體狀態").value;
            if(cont==""){
                $("#takecare-cont-remind").remove();
                $("#form-group6").append('<small class="form-text text-muted" style="color:red !important;" id="takecare-cont-remind">受照護者身體狀態不能為空,請查核！</small>');//檢查格式是否為空值
                $("#受照護者身體狀態").addClass("is-invalid");
                check_count[5] = 0;
                return false;
                
            }
        $("#takecare-cont-remind").remove();
        $("#受照護者家庭狀態").removeClass("is-invalid");
        $("#受照護者家庭狀態").addClass("is-valid");
        check_count[5] = 1;
        return (true);     
        }
        function category(){
            var cate=document.getElementById("受照護者障礙別").value;
            if(cate==""){
                $("#takecare-cate-remind").remove();
                $("#form-group7").append('<small class="form-text text-muted" style="color:red !important;" id="takecare-cate-remind">受照護者障礙別不能為空,請查核！</small>');//檢查格式是否為空值
                $("#受照護者障礙別").addClass("is-invalid");
                check_count[6] = 0;
                return false;   
            }
          if(cate.length>14){
                $("#takecare-cate-remind").remove();
                $("#form-group7").append('<small class="form-text text-muted" style="color:red !important;" id="takecare-cate-remind">受照護者障礙別不能超過14個字,請查核！</small>');//檢查格式是否為空值
                $("#受照護者障礙別").addClass("is-invalid");
                check_count[6] = 0;
                return false;   
            }
        
            $("#takecare-cate-remind").remove();
            $("#受照護者障礙別").removeClass("is-invalid");
            $("#受照護者障礙別").addClass("is-valid");
            check_count[6] = 1;
            return (true); 
        }
        function contact_name(){
           var name=document.getElementById("聯絡人姓名").value;
            if(name==""){
                $("#contact-name-remind").remove();
                $("#form-group8").append('<small class="form-text text-muted" style="color:red !important;" id="contact-name-remind">聯絡人姓名不能為空,請查核！</small>');//檢查格式是否為空值
                $("#聯絡人姓名").addClass("is-invalid");
                check_count[7] = 0;
                return false;   
            }
            if(name.length>20){
                $("#contact-name-remind").remove();
                $("#form-group8").append('<small class="form-text text-muted" style="color:red !important;" id="takecare-cate-remind">聯絡人姓名不能超過20個字,請查核！</small>');//檢查格式是否為空值
                $("#聯絡人姓名").addClass("is-invalid");
                check_count[7] = 0;
                return false;     
            }
            
            $("#contact-name-remind").remove();
            $("#聯絡人姓名").removeClass("is-invalid");
            $("#聯絡人姓名").addClass("is-valid");
            check_count[7] = 1;
            return (true);  
        }
        function contact_phone(){
            var phone=document.getElementById("聯絡人電話").value; 
            if(phone==""){
                $("#contact-phone-remind").remove();
                $("#form-group9").append('<small class="form-text text-muted" style="color:red !important;" id="contact-phone-remind">聯絡人電話不能為空,請查核！</small>');//檢查格式是否為空值
                $("#聯絡人電話").addClass("is-invalid");
                check_count[8] = 0;
                return false;   
            }
            if (phone.length!=14){
			$("#contact-phone-remind").remove();
            $("#form-group9").append('<small class="form-text text-muted" style="color:red !important;" id="contact-phone-remind">聯絡人電話長度不符,格式為<+886>09xxxxxxxx,之14碼電話,請查核！</small>');//檢查格式是否為空值"")
            $("#家庭代碼").addClass("is-invalid");
            check_count[8] = 0;
            return false;
        }
            for (i=0; i<14; i++){
            var  check_phone=phone.charAt(i);
            if (i==0){	// 檢查第一碼是否是 "北,中,南,東"
                if (check_phone!="+"){
                    $("#contact-phone-remind").remove();
                    $("#form-group9").append('<small class="form-text text-muted" style="color:red !important;" id="contact-phone-remind">聯絡人電話第一碼為"+",請查核!</small>');
                    $("#聯絡人電話").addClass("is-invalid");
                    check_count[8] = 0;
                    return false;
                }
            }   
            if(1<=i && i<=14){
                if(!('0'<=check_phone && check_phone<='9')){//用ASCII檢查後七碼是否為0~9
                    $("#contact-phone-remind").remove();
                    $("#form-group9").append('<small class="form-text text-muted" style="color:red !important;" id="contact-phone-remind">聯絡人電話須為數字,請查核!</small>');
                    $("#聯絡人電話").addClass("is-invalid");
                    check_count[8] = 0;
                    return false;
                }
            }
        }
            $("#contact-phone-remind").remove();
            $("#聯絡人電話").removeClass("is-invalid");
            $("#聯絡人電話").addClass("is-valid");
            check_count[8] = 1;
            return (true);  
        }
        function line_check(){
           var line_id=document.getElementById("LineId").value;
            if(line_id==""){
                $("#line_id_remind").remove();
                $("#form-group10").append('<small class="form-text text-muted" style="color:red !important;" id="line_id_remind">Line_id不能為空,請查核！</small>');//檢查格式是否為空值
                $("#LineId").addClass("is-invalid");
                check_count[9] = 0;
                return false;   
            }
            if(line_id.length>20){
                $("#line_id_remind").remove();
                $("#form-group10").append('<small class="form-text text-muted" style="color:red !important;" id="line_id_remind">Line_id不能超過20個字,請查核！</small>');//檢查格式是否為空值
                $("#LineId").addClass("is-invalid");
                check_count[9] = 0;
                return false;     
            }
            
            $("#line_id_remind").remove();
            $("#LineId").removeClass("is-invalid");
            $("#LineId").addClass("is-valid");
            check_count[9] = 1;
            return (true);  
        }     
        
      

    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</body>

</html>